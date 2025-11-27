<?php
require("cabecalho.php");
require("conexao.php");
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        $stmt = $pdo->prepare("SELECT * from conta WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$_GET['id'], $usuario_id]);
        $conta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$conta) {
            die("Conta não encontrada ou você não tem permissão para consultar/excluir.");
        }

        $saldo_formatado = number_format($conta['saldo_inicial'], 2, ',', '.');
    } catch (Exception $e) {
        echo "Erro ao consultar conta: " . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    try {
        $stmt =
            $pdo->prepare("DELETE from conta WHERE id = ? AND usuario_id = ?");
        if ($stmt->execute([$id, $usuario_id])) {
            header('location: contas.php?excluir=true');
        } else {
            header('location: contas.php?excluir=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Consultar e Excluir Conta Financeira</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $conta['id'] ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Conta:</label>
        <input disabled value="<?= $conta['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <div class="mb-3">
        <label for="saldo_inicial" class="form-label">Saldo Inicial:</label>
        <input disabled value="R$ <?= $saldo_formatado ?>" type="text" id="saldo_inicial" name="saldo_inicial" class="form-control" required="">
    </div>
    <p>Deseja EXCLUIR PERMANENTEMENTE essa conta e TODAS AS MOVIMENTAÇÕES ligadas a ela?</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>