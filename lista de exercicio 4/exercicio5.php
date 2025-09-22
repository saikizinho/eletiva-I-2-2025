<?php
include("cabecalho.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livros = [];
    $titulos = $_POST['titulo'];
    $quantidades = $_POST['quantidade'];
    $alerta_estoque = [];

    for ($i = 0; $i < count($titulos); $i++) {
        $titulo = $titulos[$i];
        $quantidade = (int) $quantidades[$i];

        $livros[$titulo] = $quantidade;

        if ($quantidade < 5) {
            $alerta_estoque[] = "Atenção: O livro \"$titulo\" tem apenas $quantidade unidades em estoque.";
        }
    }

    ksort($livros);

    if (count($alerta_estoque) > 0) {
        echo "<h3>Alertas de Estoque Baixo:</h3>";
        foreach ($alerta_estoque as $alerta) {
            echo "<p style='color:red;'>$alerta</p>";
        }
        echo "<hr>";
    }

    echo "<h3>Lista de Livros (ordenada por título):</h3>";
    echo "<ul>";
    foreach ($livros as $titulo => $quantidade) {
        echo "<li>$titulo: $quantidade unidades em estoque</li>";
    }
    echo "</ul>";
}
?>

<form method="post">
    <h3>Adicionar 5 Livros</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="mb-3">
            <label for="titulo<?php echo $i; ?>" class="form-label">Título do Livro <?php echo $i; ?>:</label>
            <input type="text" name="titulo[]" id="titulo<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="quantidade<?php echo $i; ?>" class="form-label">Quantidade em Estoque:</label>
            <input type="number" name="quantidade[]" id="quantidade<?php echo $i; ?>" class="form-control" required>
        </div>
        <hr>
    <?php endfor; ?>
    <button type="submit" class="btn btn-primary">Verificar Estoque</button>
</form>

<?php
include("rodape.php");
?>