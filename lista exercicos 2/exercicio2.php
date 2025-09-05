<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Somar triplo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Somar triplo</h1>
        <form method="post">
            <div class="mb-3">
                <label for="vl1" class="form-label">Insira um valor :</label>
                <input type="number" id="vl1" name="vl1" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label for="vl2" class="form-label">Insira um valor</label>
                <input type="number" id="vl2" name="vl2" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $valor1 = $_POST['vl1'];
            $valor2 = $_POST['vl2'];

            if ($valor1 == $valor2) {
                $triplo = ($valor1 + $valor2) * 3;
                echo "<p>Por serem números iguais, o resultado será o triplo, logo: $valor1 + $valor2 * 3 = $triplo</p>";
            } else {
                $soma = $valor1 + $valor2;
                echo "<p>Por serem números diferentes, o resultado será somente a soma, logo: $valor1 + $valor2 = $soma</p>";
            }
        }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>

</html>