<?php
require("cabecalho.php");
require("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM categoria_despesa WHERE usuario_id = ? ORDER BY nome");
    $stmt->execute([$usuario_id]);
    $dados = $stmt->fetchAll();
} catch (\Exception $e) {
    echo "Erro ao consultar: " . $e->getMessage();
}

if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'true') {
    echo "<p class='text-success'>Cadastro realizado com sucesso!</p>";
} else if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'false') {
    echo "<p class='text-danger'>Erro ao cadastrar!</p>";
}
if (isset($_GET['editar']) && $_GET['editar'] == 'true') {
    echo "<p class='text-success'>Registro editado com sucesso!</p>";
} else if (isset($_GET['editar']) && $_GET['editar'] == 'false') {
    echo "<p class='text-danger'>Erro ao editar!</p>";
}
if (isset($_GET['excluir']) && $_GET['excluir'] == 'true') {
    echo "<p class='text-success'>Registro excluído com sucesso!</p>";
} else if (isset($_GET['excluir']) && $_GET['excluir'] == 'false') {
    echo "<p class='text-danger'>Erro ao excluir!</p>";
}
?>

<h2>Categorias de Despesas</h2>
<a href="nova_categoria_despesa.php" class="btn btn-success mb-3 no-print">Nova Categoria</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th colspan="2">Categorias Cadastradas</th>
            <th class="no-print">
                <button class="btn btn-secondary" onclick="window.print()">
                    Imprimir
                </button>
            </th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($dados as $d):
        ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= $d['nome'] ?></td>
                <td class="d-flex gap-2 no-print">
                    <a href="editar_categoria_despesa.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="consultar_categoria_despesa.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require("rodape.php");
?>