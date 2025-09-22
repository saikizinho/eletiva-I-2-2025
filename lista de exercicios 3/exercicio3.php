<?php
include("cabecalho.php");
?>
<form method="post">
    <div class="mb-3">
        <label for="palavraA" class="form-label">Primeira palavra:</label>
        <input type="text" id="palavraA" name="palavraA" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="palavraB" class="form-label">Segunda palavra:</label>
        <input type="text" id="palavraB" name="palavraB" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
function verificar($palavraA, $palavraB)
{
    return (strpos($palavraA, $palavraB) !== false);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $palavraA = $_POST['palavraA'];
    $palavraB = $_POST['palavraB'];
    if (verificar($palavraA, $palavraB)) {
        echo "<p>A segunda palavra ($palavraB) está contida na primeira ($palavraA).</p>";
    } else {
        echo "<p>A segunda palavra ($palavraB) NÃO está contida na primeira ($palavraA).</p>";
    }
}
include("rodape.php");
?>