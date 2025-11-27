<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];

    try {
        $stmt = $pdo->prepare("INSERT INTO fonte_renda (nome, usuario_id) VALUES (?, ?)");

        if ($stmt->execute([$nome, $usuario_id])) {
            header('location: fontes_renda.php?cadastro=true');
        } else {
            header('location: fontes_renda.php?cadastro=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Nova Fonte de Renda</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Fonte de Renda (Ex: Salário, Freelance):</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar Fonte</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>