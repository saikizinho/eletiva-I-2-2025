<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    try {
        $stmt = $pdo->prepare("INSERT INTO categoria_despesa (nome, usuario_id) VALUES (?, ?)");
        if ($stmt->execute([$nome, $usuario_id])) {
            header('location: categorias_despesas.php?cadastro=true');
        } else {
            header('location: categorias_despesas.php?cadastro=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Nova Categoria de Despesa</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o nome da Categoria de Despesa:</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>