<?php
include("cabecalho.php");
?>
<form method="post">
    <div class="mb-3">
        <label for="dia" class="form-label">Dia:</label>
        <input type="number" id="dia" name="dia" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="mes" class="form-label">Mês:</label>
        <input type="number" id="mes" name="mes" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="ano" class="form-label">Ano:</label>
        <input type="number" id="ano" name="ano" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
function formatarData($dia, $mes, $ano)
{
    if (checkdate($mes, $dia, $ano)) {
        return "A data $dia/$mes/$ano é válida.";
    } else {
        return "A data informada ($dia/$mes/$ano) é inválida.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
    echo "<p>" . formatarData($dia, $mes, $ano) . "</p>";
}
include("rodape.php");
?>