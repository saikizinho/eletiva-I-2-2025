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
    echo "Erro ao carregar dados auxiliares: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $tipo               = $_POST['tipo'];
    $valor              = str_replace(',', '.', $_POST['valor']);
    $data_movimentacao  = $_POST['data_movimentacao'];
    $descricao          = $_POST['descricao'];
    $conta_id           = $_POST['conta_id'];

    $categoria_despesa_id = ($tipo == 'despesa') ? $_POST['categoria_despesa_id'] : null;
    $fonte_renda_id       = ($tipo == 'receita') ? $_POST['fonte_renda_id'] : null;

    try {
        $stmt = $pdo->prepare("
            INSERT INTO movimentacao 
                (tipo, valor, data_movimentacao, descricao, conta_id, categoria_despesa_id, fonte_renda_id, usuario_id) 
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if ($stmt->execute([
            $tipo,
            $valor,
            $data_movimentacao,
            $descricao,
            $conta_id,
            $categoria_despesa_id,
            $fonte_renda_id,
            $usuario_id
        ])) {
            header('location: movimentacoes.php?cadastro=true');
        } else {
            header('location: movimentacoes.php?cadastro=false');
        }
    } catch (\Exception $e) {
        echo "Erro ao registrar movimentação: " . $e->getMessage();
    }
}
?>

<h1>Nova Movimentação</h1>
<form method="post">

    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo de Movimentação:</label>
        <select id="tipo" name="tipo" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input type="text" id="valor" name="valor" class="form-control" placeholder="Use vírgula, ex: 50,00" required>
    </div>

    <div class="mb-3">
        <label for="data_movimentacao" class="form-label">Data da Movimentação:</label>
        <input type="date" id="data_movimentacao" name="data_movimentacao" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="conta_id" class="form-label">Conta (Origem/Destino):</label>
        <select id="conta_id" name="co_