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
            die("Conta não encontrada ou você não tem permissão para editar.");
        }
        $saldo_formatado = number_format($conta['saldo_inicial'], 2, ',', '');
    } catch (Exception $e) {
        echo "Erro ao consultar conta: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $id = $_POST['id'];
    $saldo_inicial = str_replace(',', '.', $_POST['saldo_inicial']);

    try {
        $stmt = $pdo->prepare("UPDATE conta set nome = ?, saldo_inicial = ? WHERE id = ? AND usuario_id = ?");
        if ($stmt->execute([$nome, $saldo_inicial, $id, $usuario_id])) {
            header('location: contas.php?editar=true');
        } else {
            header('location: contas.php?editar=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Editar Conta Financeira</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $conta['id'] ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Conta:</label>
        <input value="<?= $conta['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <div class="mb-3">
        <label for="saldo_inicial" class="form-label">Saldo Inicial:</label>
        <input value="<?= $saldo_formatado ?>" type="text" id="saldo_inicial" name="saldo_inicial" class="form-control" placeholder="Use vírgula, ex: 100,50" required="">
    </div>
    <button type="submit" class="btn btn-primary">Salvar Edição</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>