<?php
include("cabecalho.php");
?>
<form method="post">
    <div class="mb-3">
        <label for="palavra" class="form-label">Digite uma palavra:</label>
        <input type="text" id="palavra" name="palavra" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
function converterPalavra($palavra)
{
    $maiuscula = strtoupper($palavra);
    $minuscula = strtolower($palavra);
    return ['maiuscula' => $maiuscula, 'minuscula' => $minuscula];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $palavra = $_POST['palavra'];
    $resultado = converterPalavra($palavra);
    echo "<p>Em maiúsculo: " . $resultado['maiuscula'] . "</p>";
    echo "<p>Em minúsculo: " . $resultado['minuscula'] . "</p>";
}
include("rodape.php");
?>