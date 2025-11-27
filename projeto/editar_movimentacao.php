<?php
require("cabecalho.php");
require("conexao.php");
$usuario_id = $_SESSION['usuario_id'];

try {
    $stmt_contas = $pdo->prepare("SELECT id, nome FROM conta WHERE usuario_id = ? ORDER BY nome");
    $stmt_contas->execute([$usuario_id]);
    $contas = $stmt_contas->fetchAll();

    $stmt_cats = $pdo->prepare("SELECT id, nome FROM categoria_despesa WHERE usuario_id = ? ORDER BY nome");
    $stmt_cats->execute([$usuario_id]);
    $categorias = $stmt_cats->fetchAll();

    $stmt_fontes = $pdo->prepare("SELECT id, nome FROM fonte_renda WHERE usuario_id = ? ORDER BY nome");
    $stmt_fontes->execute([$usuario_id]);
    $fontes = $stmt_fontes->fetchAll();
} catch (Exception $e) {
    die("Erro ao carregar dados auxiliares: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        $stmt = $pdo->prepare("SELECT * from movimentacao WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$_GET['id'], $usuario_id]);
        $movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movimentacao) {
            die("Movimentação não encontrada ou você não tem permissão para editar.");
        }

        $valor_formatado = number_format($movimentacao['valor'], 2, ',', '');
    } catch (Exception $e) {
        echo "Erro ao consultar movimentação: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $valor = str_replace(',', '.', $_POST['valor']);
    $data_movimentacao = $_POST['data_movimentacao'];
    $descricao = $_POST['descricao'];
    $conta_id = $_POST['conta_id'];

    $categoria_despesa_id = ($tipo == 'despesa') ? $_POST['categoria_despesa_id'] : null;
    $fonte_renda_id = ($tipo == 'receita') ? $_POST['fonte_renda_id'] : null;

    try {
        $stmt = $pdo->prepare("
            UPDATE movimentacao SET 
                tipo = ?, 
                valor = ?, 
                data_movimentacao = ?, 
                descricao = ?, 
                conta_id = ?, 
                categoria_despesa_id = ?, 
                fonte_renda_id = ? 
            WHERE id = ? AND usuario_id = ?
        ");

        if ($stmt->execute([
            $tipo,
            $valor,
            $data_movimentacao,
            $descricao,
            $conta_id,
            $categoria_despesa_id,
            $fonte_renda_id,
            $id,
            $usuario_id
        ])) {
            header('location: movimentacoes.php?editar=true');
        } else {
            header('location: movimentacoes.php?editar=false');
        }
    } catch (\Exception $e) {
        echo "Erro ao editar movimentação: " . $e->getMessage();
    }
}
?>

<h1>Editar Movimentação</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $movimentacao['id'] ?>">

    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo de Movimentação:</label>
        <select id="tipo" name="tipo" class="form-select" required>
            <option value="receita" <?= ($movimentacao['tipo'] == 'receita' ? 'selected' : '') ?>>Receita</option>
            <option value="despesa" <?= ($movimentacao['tipo'] == 'despesa' ? 'selected' : '') ?>>Despesa</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input value="<?= $valor_formatado ?>" type="text" id="valor" name="valor" class="form-control" placeholder="Use vírgula, ex: 50,00" required>
    </div>

    <div class="mb-3">
        <label for="data_movimentacao" class="form-label">Data da Movimentação:</label>
        <input value="<?= $movimentacao['data_movimentacao'] ?>" type="date" id="data_movimentacao" name="data_movimentacao" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="conta_id" class="form-label">Conta (Origem/Destino):</label>
        <select id="conta_id" name="conta_id" class="form-select" required>
            <option value="">Selecione a Conta...</option>
            <?php foreach ($contas as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $movimentacao['conta_id'] ? 'selected' : '') ?>>
                    <?= $c['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3" id="campo-categoria">
        <label for="categoria_despesa_id" class="form-label">Categoria de Despesa:</label>
        <select id="categoria_despesa_id" name="categoria_despesa_id" class="form-select">
            <option value="">Selecione a Categoria de Despesa...</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $movimentacao['categoria_despesa_id'] ? 'selected' : '') ?>>
                    <?= $c['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3" id="campo-fonte">
        <label for="fonte_renda_id" class="form-label">Fonte de Renda:</label>
        <select id="fonte_renda_id" name="fonte_renda_id" class="form-select">
            <option value="">Selecione a Fonte de Renda...</option>
            <?php foreach ($fontes as $f): ?>
                <option value="<?= $f['id'] ?>" <?= ($f['id'] == $movimentacao['fonte_renda_id'] ? 'selected' : '') ?>>
                    <?= $f['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição / Observação:</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="2"><?= $movimentacao['descricao'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Edição</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<script>
    function toggleCampos() {
        var tipo = document.getElementById('tipo').value;
        var campoCategoria = document.getElementById('campo-categoria');
        var campoFonte = document.getElementById('campo-fonte');

        if (tipo === 'despesa') {
            campoCategoria.style.display = 'block';
            campoFonte.style.display = 'none';
            document.getElementById('categoria_despesa_id').setAttribute('required', 'required');
            document.getElementById('fonte_renda_id').removeAttribute('required');
        } else if (tipo === 'receita') {
            campoCategoria.style.display = 'none';
            campoFonte.style.display = 'block';
            document.getElementById('fonte_renda_id').setAttribute('required', 'required');
            document.getElementById('categoria_despesa_id').removeAttribute('required');
        }
    }

    document.getElementById('tipo').addEventListener('change', toggleCampos);
    document.addEventListener('DOMContentLoaded', toggleCampos);
</script>

<?php
require("rodape.php");
?>