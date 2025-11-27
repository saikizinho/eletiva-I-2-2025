<?php
require("cabecalho.php");
require("conexao.php");
$usuario_id = $_SESSION['usuario_id'];

// =========================================================
// 1. CÁLCULO DOS SALDOS INDIVIDUAIS POR CONTA
// =========================================================

$saldos_contas = [];
$saldo_total_geral = 0;

try {
    // 1. Busca todas as contas do usuário
    $stmt_contas = $pdo->prepare("SELECT id, nome, saldo_inicial FROM conta WHERE usuario_id = ?");
    $stmt_contas->execute([$usuario_id]);
    $contas = $stmt_contas->fetchAll(PDO::FETCH_ASSOC);

    foreach ($contas as $conta) {
        $conta_id = $conta['id'];
        $saldo_atual = (float) $conta['saldo_inicial'];

        // 2. Calcula Receitas e Despesas para esta conta
        $stmt_mov = $pdo->prepare("
            SELECT SUM(CASE WHEN tipo = 'receita' THEN valor ELSE 0 END) AS total_receitas,
                   SUM(CASE WHEN tipo = 'despesa' THEN valor ELSE 0 END) AS total_despesas
            FROM movimentacao 
            WHERE conta_id = ?
        ");
        $stmt_mov->execute([$conta_id]);
        $totais = $stmt_mov->fetch(PDO::FETCH_ASSOC);

        $saldo_atual += (float) $totais['total_receitas'] - (float) $totais['total_despesas'];

        $saldos_contas[] = [
            'id' => $conta['id'],
            'nome' => $conta['nome'],
            'saldo' => $saldo_atual,
        ];

        $saldo_total_geral += $saldo_atual;
    }
} catch (\Exception $e) {
    echo "Erro ao calcular saldos: " . $e->getMessage();
}


// =========================================================
// 2. BUSCA E PRÉ-CÁLCULO DO HISTÓRICO DE MOVIMENTAÇÕES
// =========================================================
$historico_completo = [];
$saldos_acumulados = [];

try {
    // Consulta de MOVIMENTAÇÕES em ORDEM CRONOLÓGICA (ASC) para calcular saldos
    $stmt = $pdo->prepare("
            SELECT 
                m.id, m.tipo, m.valor, m.data_movimentacao, m.descricao, m.conta_id,
                c.nome AS conta_nome, c.saldo_inicial,
                cd.nome AS categoria_nome,
                fr.nome AS fonte_nome
            FROM movimentacao m
            INNER JOIN conta c ON c.id = m.conta_id
            LEFT JOIN categoria_despesa cd ON cd.id = m.categoria_despesa_id
            LEFT JOIN fonte_renda fr ON fr.id = m.fonte_renda_id
            WHERE m.usuario_id = ?
            ORDER BY m.data_movimentacao ASC, m.id ASC
        ");
    $stmt->execute([$usuario_id]);
    $historico_completo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcula o saldo acumulado para cada conta e cada movimentação
    $saldo_por_conta_atual = array_column($contas, 'saldo_inicial', 'id');

    foreach ($historico_completo as $key => $mov) {
        $conta_id = $mov['conta_id'];
        $valor = ($mov['tipo'] == 'despesa') ? -$mov['valor'] : $mov['valor'];

        $saldo_anterior = $saldo_por_conta_atual[$conta_id];

        $saldo_por_conta_atual[$conta_id] += $valor;

        $saldos_acumulados[$mov['id']] = [
            'saldo_apos' => $saldo_por_conta_atual[$conta_id],
            'saldo_anterior' => $saldo_anterior
        ];
    }

    // Inverte a ordem para exibir na tabela (mais recente primeiro)
    $dados = array_reverse($historico_completo);
} catch (\Exception $e) {
    echo "Erro ao consultar histórico e calcular saldos acumulados: " . $e->getMessage();
    $dados = [];
}

// Mensagens de feedback
if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'true') {
    echo "<p class='text-success'>Movimentação registrada com sucesso!</p>";
} else if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'false') {
    echo "<p class='text-danger'>Erro ao registrar movimentação!</p>";
}
?>

<style>
    /* Esconde elementos que não devem aparecer no papel */
    @media print {

        .no-print,
        .acoes-coluna {
            display: none !important;
        }

        body {
            background-color: #fff !important;
        }

        .table-danger,
        .table-success {
            background-color: transparent !important;
            opacity: 1 !important;
        }

        .container {
            width: 100% !important;
            max-width: none !important;
        }
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Visão Geral Financeira</h1>
        <!-- Botão de Impressão -->
        <button onclick="window.print()" class="btn btn-secondary no-print">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>

    <div class="row mb-5">
        <?php foreach ($saldos_contas as $sc):
            $saldo = $sc['saldo'];

            // Cor do card baseada no saldo
            $card_class = ($saldo > 0) ? 'bg-success' : (($saldo < 0) ? 'bg-danger' : 'bg-secondary');

            // Define ícone condicional
            $card_icon = ($saldo > 0) ? '💰' : (($saldo < 0) ? '🚨' : '⚪');
        ?>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-white <?= $card_class ?> shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $card_icon ?> Saldo: <?= htmlspecialchars($sc['nome']) ?></h5>
                        <p class="card-text fs-3">
                            R$ <?= number_format($saldo, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">💵 Saldo Consolidado</h5>
                    <p class="card-text fs-3">
                        R$ <?= number_format($saldo_total_geral, 2, ',', '.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h3>Histórico de Transações</h3>
    <a href="nova_movimentacao.php" class="btn btn-success mb-3 no-print">Nova Movimentação</a>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th class="text-end">Saldo Inicial</th>
                <th>Valor</th>
                <th>Descrição</th>
                <th>Conta</th>
                <th class="text-end">Saldo Atual</th>
                <th>Categoria/Fonte</th>
                <th class="no-print acoes-coluna">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($dados as $d):
                // Valores de Saldo Anterior e Saldo Atual
                $saldos = $saldos_acumulados[$d['id']] ?? ['saldo_apos' => 0.00, 'saldo_anterior' => 0.00];

                $saldo_apos_op = $saldos['saldo_apos'];
                $saldo_anterior_op = $saldos['saldo_anterior'];

                // Formatação do Saldo Anterior
                $saldo_anterior_formatado = number_format($saldo_anterior_op, 2, ',', '.');
                $classe_saldo_anterior = ($saldo_anterior_op > 0) ? 'text-success' : (($saldo_anterior_op < 0) ? 'text-danger' : 'text-muted');

                // Formatação do Saldo Atual
                $saldo_formatado = number_format($saldo_apos_op, 2, ',', '.');
                $classe_saldo_atual = ($saldo_apos_op > 0) ? 'text-success' : (($saldo_apos_op < 0) ? 'text-danger' : 'text-muted');

                // Formatação do Valor da Operação
                $valor_formatado = number_format($d['valor'], 2, ',', '.');
                $classe_valor = ($d['tipo'] == 'receita') ? 'text-success' : 'text-danger';
            ?>
                <tr class="<?= ($d['tipo'] == 'despesa') ? 'table-danger' : 'table-success' ?> bg-opacity-10">
                    <td><?= date('d/m/Y', strtotime($d['data_movimentacao'])) ?></td>
                    <td><?= ucfirst($d['tipo']) ?></td>
                    <td class="text-end fw-bold <?= $classe_saldo_anterior ?>">
                        R$ <?= $saldo_anterior_formatado ?>
                    </td>
                    <td class="<?= $classe_valor ?>">
                        <?= ($d['tipo'] == 'despesa' ? '-' : '+') ?> R$ <?= $valor_formatado ?>
                    </td>
                    <td><?= htmlspecialchars($d['descricao']) ?></td>
                    <td class="fw-bold"><?= htmlspecialchars($d['conta_nome']) ?></td>
                    <td class="text-end fw-bold <?= $classe_saldo_atual ?>">
                        R$ <?= $saldo_formatado ?>
                    </td>
                    <td>
                        <?php
                        echo ($d['tipo'] == 'despesa') ? htmlspecialchars($d['categoria_nome']) : htmlspecialchars($d['fonte_nome']);
                        ?>
                    </td>
                    <td class="d-flex gap-2 no-print acoes-coluna">
                        <a href="editar_movimentacao.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="consultar_movimentacao.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    require("rodape.php");
    ?>