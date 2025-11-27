<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        
        $stmt = $pdo->prepare("SELECT * from categoria_despesa WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$_GET['id'], $usuario_id]);
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$categoria) {
            die("Categoria não encontrada ou você não tem permissão para consultar/excluir.");
        }
    } catch (Exception $e) {
        echo "Erro ao consultar categoria: " . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    try {
        $stmt =
            $pdo->prepare("DELETE from categoria_despesa WHERE id = ? AND usuario_id = ?");
        if ($stmt->execute([$id, $usuario_id])) {
            header('location: categorias_despesas.php?excluir=true');
        } else {
            header('location: categorias_despesas.php?excluir=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Consultar e Excluir Categoria de Despesa</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da categoria:</label>
        <input disabled value="<?= $categoria['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <p>Deseja excluir esse registro?</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>