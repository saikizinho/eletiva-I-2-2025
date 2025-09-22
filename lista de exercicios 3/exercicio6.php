<?php
include("cabecalho.php");
?>
<form method="post">
    <div class="mb-3">
        <label for="numero" class="form-label">Digite um número decimal:</label>
        <input type="number" step="any" id="numero" name="numero" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
function arredondar($numero)
{
    return round($numero);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST['numero'];
    $numeroArredondado = arredondar($numero);
    echo "<p>O número $numero arredondado é: $numeroArredondado</p>";
}
include("rodape.php");
?>