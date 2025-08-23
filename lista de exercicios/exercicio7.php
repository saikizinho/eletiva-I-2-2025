<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exemplo - soma de valores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Exemplo - Conversão de temperatura de farenheit para celsius</h1>
        <form method="post">
            <form method="post">
                <div class="mb-3">
                    <label for="valor1" class="form-label">Informe a temperatura em ºF</label>
                    <input type="number" id="valor1" name="valor1" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $valor1 = $_POST['valor1'];

                $celsius = ($valor1 - 32) * 5 / 9;

                echo "<p>$valor1 °F é igual a $celsius °C</p>";
            }
            ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>

</html>