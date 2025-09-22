<?php
include("cabecalho.php");
?>
<form method="post">
    <div class="mb-3">
        <label for="numero" class="form-label">Digite um número:</label>
        <input type="number" step="any" id="numero" name="numero" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
function calcularRaizQuadrada($numero)
{
    if ($numero >= 0) {
        return sqrt($numero);
    } else {
        return "Não é possível calcular a raiz quadrada de um número negativo.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST['numero'];
    $resultado = calcularRaizQuadrada($numero);
    echo "<p>A raiz quadrada de $numero é: $resultado</p>";
}
include("rodape.php");
?>