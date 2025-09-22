<?php
include("cabecalho.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produtos = [];
    $codigos = $_POST['codigo'];
    $nomes = $_POST['nome'];
    $precos = $_POST['preco'];

    echo "<h3>Lista de Produtos (com desconto):</h3>";
    echo "<ul>";

    for ($i = 0; $i < count($codigos); $i++) {
        $preco_original = (float) $precos[$i];
        $preco_final = $preco_original;

        if ($preco_original > 100.00) {
            $preco_final = $preco_original * 0.90;
        }

        $codigo = $codigos[$i];
        $nome = $nomes[$i];
        $preco = round($preco_final, 2);

        echo "<li>$codigo: " . $nome . " - R$ " . $preco . "</li>";
    }
    echo "</ul>";
}
?>

<form method="post">
    <h3>Adicionar 5 Produtos</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="mb-3">
            <label for="codigo<?php echo $i; ?>" class="form-label">Código do Produto <?php echo $i; ?>:</label>
            <input type="text" name="codigo[]" id="codigo<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nome<?php echo $i; ?>" class="form-label">Nome:</label>
            <input type="text" name="nome[]" id="nome<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="preco<?php echo $i; ?>" class="form-label">Preço:</label>
            <input type="number" step="0.01" name="preco[]" id="preco<?php echo $i; ?>" class="form-control" required>
        </div>
        <hr>
    <?php endfor; ?>
    <button type="submit" class="btn btn-primary">Aplicar Desconto</button>
</form>

<?php
include("rodape.php");
?>