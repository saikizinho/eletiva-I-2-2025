<?php
require("cabecalho.php");
require("conexao.php");
$usuario_id = $_SESSION['usuario_id'];


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        $stmt = $pdo->prepare("
                SELECT 
                    m.*,
                    c.nome AS conta_nome,
                    cd.nome AS categoria_nome,
                    fr.nome AS fonte_nome
                FROM movimentacao m
                INNER JOIN conta c ON c.id = m.conta_id
                LEFT JOIN categoria_despesa cd ON cd.id = m.categoria_despesa_id
                LEFT JOIN fonte_renda fr ON fr.id = m.fonte_renda_id
                WHERE m.id = ? AND m.usuario_id = ?
            ");
        $stmt->execute([$_GET['id'], $usuario_id]);
        $movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movimentacao) {
            die("Movimentação não encontrada ou você não tem permissão para consultar/excluir.");
        }

        $valor_formatado = number_format($movimentacao['valor'], 2, ',', '.');
        $data_formatada = date('d/m/Y', strtotime($movimentacao['data_movimentacao']));
    } catch (Exception $e) {
        echo "Erro ao consultar movimentação: " . $e->getMessage();
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    try {
        $stmt =
            $pdo->prepare("DELETE from movimentacao WHERE id = ? AND usuario_id = ?");
        if ($stmt->execute([$id, $usuario_id])) {
            header('location: movimentacoes.php?excluir=true');
        } else {
            header('location: movimentacoes.php?excluir=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Consultar e Excluir Movimentação</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $movimentacao['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Tipo de Movimentação:</label>
        <input disabled value="<?= ucfirst($movimentacao['tipo']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Valor:</label>
        <input disabled value="R$ <?= $valor_formatado ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Data:</label>
        <input disabled value="<?= $data_formatada ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Conta:</label>
        <input disabled value="<?= htmlspecialchars($movimentacao['conta_nome']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Categoria / Fonte:</label>
        <input disabled value="<?= htmlspecialchars($movimentacao['tipo'] == 'despesa' ? $movimentacao['categoria_nome'] : $movimentacao['fonte_nome']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição / Observação:</label>
        <textarea disabled class="form-control" rows="2"><?= $movimentacao['descricao'] ?></textarea>
    </div>

    <p class="text-danger">Deseja **excluir permanentemente** essa movimentação? A exclusão afetará o seu saldo total.</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>