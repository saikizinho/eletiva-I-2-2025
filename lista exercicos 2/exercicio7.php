<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contador com while</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Contador até o número informado</h1>
        <form method="post">
            <div class="mb-3">
                <label for="numero" class="form-label">Digite um número:</label>
                <input type="number" id="numero" name="numero" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero = $_POST['numero'];
            $soma = 0;
            $i = 1;

            echo "<h3>Números de 1 até $numero:</h3>";
            echo "<p>";

            while ($i <= $numero) {
                echo $i;
                $soma += $i;

                if ($i < $numero) {
                    echo "+";
                }
                $i++;
            }

            echo " = $soma";
            echo "</p>";
        }
        ?>
    </div>
</body>

</html>