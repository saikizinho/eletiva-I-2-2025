<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $saldo_inicial = str_replace(',', '.', $_POST['saldo_inicial']);

    try {
        $stmt = $pdo->prepare("INSERT INTO conta (nome, saldo_inicial, usuario_id) VALUES (?, ?, ?)");

        if ($stmt->execute([$nome, $saldo_inicial, $usuario_id])) {
            header('location: contas.php?cadastro=true');
        } else {
            header('location: contas.php?cadastro=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Nova Conta Financeira</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Conta (Ex: Nubank, Carteira):</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <div class="mb-3">
        <label for="saldo_inicial" class="form-label">Saldo Inicial:</label>
        <input type="text" id="saldo_inicial" name="saldo_inicial" class="form-control" placeholder="Use vírgula, ex: 100,50" required="">
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar Conta</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>