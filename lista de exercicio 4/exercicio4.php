<?php
include("cabecalho.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itens = [];
    $nomes = $_POST['nome'];
    $precos = $_POST['preco'];

    for ($i = 0; $i < count($nomes); $i++) {
        $preco_final = (float) $precos[$i] * 1.15;
        $itens[$nomes[$i]] = round($preco_final, 2);
    }

    asort($itens);

    echo "<h3>Preço dos Itens (com imposto e ordenado por preço):</h3>";
    echo "<ul>";
    foreach ($itens as $nome => $preco) {
        echo "<li>$nome: R$ $preco</li>";
    }
    echo "</ul>";
}
?>

<form method="post">
    <h3>Adicionar 5 Itens</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="mb-3">
            <label for="nome<?php echo $i; ?>" class="form-label">Nome do Item <?php echo $i; ?>:</label>
            <input type="text" name="nome[]" id="nome<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="preco<?php echo $i; ?>" class="form-label">Preço:</label>
            <input type="number" step="0.01" name="preco[]" id="preco<?php echo $i; ?>" class="form-control" required>
        </div>
        <hr>
    <?php endfor; ?>
    <button type="submit" class="btn btn-primary">Calcular Preço com Imposto</button>
</form>

<?php
include("rodape.php");
?>