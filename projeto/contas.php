<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];


try {
    $stmt_contas = $pdo->prepare("SELECT id, nome, saldo_inicial FROM conta WHERE usuario_id = ? ORDER BY nome");
    $stmt_contas->execute([$usuario_id]);
    $dados = $stmt_contas->fetchAll();
} catch (\Exception $e) {
    echo "Erro ao consultar contas: " . $e->getMessage();
}


function obter_total_movimentacao($pdo, $conta_id, $tipo)
{
    $stmt = $pdo->prepare("SELECT SUM(valor) FROM movimentacao WHERE conta_id = ? AND tipo = ?");
    $stmt->execute([$conta_id, $tipo]);
    $total = $stmt->fetchColumn();
    return (float) $total;
}


if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'true') {
    echo "<p class='text-success'>Conta cadastrada com sucesso!</p>";
} else if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'false') {
    echo "<p class='text-danger'>Erro ao cadastrar conta!</p>";
}
if (isset($_GET['editar']) && $_GET['editar'] == 'true') {
    echo "<p class='text-success'>Conta editada com sucesso!</p>";
} else if (isset($_GET['editar']) && $_GET['editar'] == 'false') {
    echo "<p class='text-danger'>Erro ao editar conta!</p>";
}
if (isset($_GET['excluir']) && $_GET['excluir'] == 'true') {
    echo "<p class='text-success'>Conta excluída com sucesso!</p>";
} else if (isset($_GET['excluir']) && $_GET['excluir'] == 'false') {
    echo "<p class='text-danger'>Erro ao excluir conta!</p>";
}
?>

<h2>Contas Financeiras</h2>
<a href="nova_conta.php" class="btn btn-success mb-3 no-print">Nova Conta</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th colspan="4">Contas Cadastradas</th>
            <th class="no-print">
                <button class="btn btn-secondary" onclick="window.print()">
                    Imprimir
                </button>
            </th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Saldo Inicial</th>
            <th>Saldo atual</th>
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($dados as $d):

            $total_receitas = obter_total_movimentacao($pdo, $d['id'], 'receita');
            $total_despesas = obter_total_movimentacao($pdo, $d['id'], 'despesa');


            $saldo_atual = $d['saldo_inicial'] + $total_receitas - $total_despesas;


            $classe_saldo = ($saldo_atual >= 0) ? 'text-success' : 'text-danger';
        ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= $d['nome'] ?></td>
                <td>R$ <?= number_format($d['saldo_inicial'], 2, ',', '.') ?></td>
                <td class="<?= $classe_saldo ?>">
                    <strong>R$ <?= number_format($saldo_atual, 2, ',', '.') ?></strong>
                </td>
                <td class="d-flex gap-2 no-print">
                    <a href="editar_conta.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="consultar_conta.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require("rodape.php");
?>