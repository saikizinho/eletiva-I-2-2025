<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabuada com For</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Tabuada</h1>
        <form method="post">
            <div class="mb-3">
                <label for="numero" class="form-label">Digite um número:</label>
                <input type="number" id="numero" name="numero" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Gerar Tabuada</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = (int) $_POST['numero'];

            echo "<h3>Tabuada do $numero</h3>";
            echo "<ul class='list-group'>";

            for ($i = 1; $i <= 10; $i++) {
                $resultado = $numero * $i;
                echo "<li class='list-group-item'>$numero x $i = $resultado</li>";
            }

            echo "</ul>";
        }
        ?>
    </div>
</body>

</html>