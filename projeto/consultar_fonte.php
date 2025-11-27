<?php
require("cabecalho.php");
require("conexao.php");
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        $stmt = $pdo->prepare("SELECT * from fonte_renda WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$_GET['id'], $usuario_id]);
        $fonte = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fonte) {
            die("Fonte de Renda não encontrada ou você não tem permissão para consultar/excluir.");
        }
    } catch (Exception $e) {
        echo "Erro ao consultar fonte de renda: " . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    try {
        $stmt =
            $pdo->prepare("DELETE from fonte_renda WHERE id = ? AND usuario_id = ?");
        if ($stmt->execute([$id, $usuario_id])) {
            header('location: fontes_renda.php?excluir=true');
        } else {
            header('location: fontes_renda.php?excluir=false');
        }
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Consultar e Excluir Fonte de Renda (RF3)</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $fonte['id'] ?>">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Fonte de Renda:</label>
        <input disabled value="<?= $fonte['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>
    <p>Deseja excluir permanentemente esse registro?</p>
    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php
require("rodape.php");
?>