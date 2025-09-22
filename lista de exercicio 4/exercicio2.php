<?php
include("cabecalho.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alunos_media = [];
    $nomes = $_POST['aluno'];
    $notas1 = $_POST['nota1'];
    $notas2 = $_POST['nota2'];
    $notas3 = $_POST['nota3'];

    for ($i = 0; $i < count($nomes); $i++) {
        $nome = $nomes[$i];
        $media = ($notas1[$i] + $notas2[$i] + $notas3[$i]) / 3;
        $alunos_media[$nome] = round($media, 2);
    }

    arsort($alunos_media);

    echo "<h3>Média dos Alunos (ordenado por média):</h3>";
    echo "<ul>";
    foreach ($alunos_media as $nome => $media) {
        echo "<li>$nome: Média $media</li>";
    }
    echo "</ul>";
}
?>

<form method="post">
    <h3>Adicionar 5 Alunos e Suas Notas</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="mb-3">
            <label for="aluno<?php echo $i; ?>" class="form-label">Nome do Aluno <?php echo $i; ?>:</label>
            <input type="text" name="aluno[]" id="aluno<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nota1_<?php echo $i; ?>" class="form-label">Nota 1:</label>
            <input type="number" step="0.01" name="nota1[]" id="nota1_<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nota2_<?php echo $i; ?>" class="form-label">Nota 2:</label>
            <input type="number" step="0.01" name="nota2[]" id="nota2_<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nota3_<?php echo $i; ?>" class="form-label">Nota 3:</label>
            <input type="number" step="0.01" name="nota3[]" id="nota3_<?php echo $i; ?>" class="form-control" required>
        </div>
        <hr>
    <?php endfor; ?>
    <button type="submit" class="btn btn-primary">Calcular Médias</button>
</form>

<?php
include("rodape.php");
?>