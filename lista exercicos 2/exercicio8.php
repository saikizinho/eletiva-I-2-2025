<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contagem Regressiva com do-while</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Contagem regressiva</h1>
        <form method="post">
            <div class="mb-3">
                <label for="numero" class="form-label">Digite um número:</label>
                <input type="number" id="numero" name="numero" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = (int) $_POST['numero'];

            if ($numero > 0) {
                echo "<h3>Contagem regressiva de $numero até 1:</h3>";
                echo "<p>";

                do {
                    echo $numero;
                    $numero--;

                    if ($numero >= 1) {
                        echo " - ";
                    }
                } while ($numero >= 1);

                echo "</p>";
            } else {
                echo "<p class='text-danger'>Digite um número maior que zero.</p>";
            }
        }
        ?>
    </div>
</body>

</html>