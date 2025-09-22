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
function contarCaracteres($palavra)
{
    return strlen($palavra);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $palavra = $_POST['palavra'];
    $numeroDeCaracteres = contarCaracteres($palavra);
    echo "<p>A palavra \"$palavra\" tem $numeroDeCaracteres caracteres.</p>";
}
include("rodape.php");
?>