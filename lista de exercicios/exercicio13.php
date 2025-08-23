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
        <h1>Exemplo - Conversão de metros para centímetros</h1>
        <form method="post">
            <div class="mb-3">
                <label for="valor1" class="form-label">informe o valor em metros (somente numeros, sem pontos ou virgulas)</label>
                <input type="number" id="valor1" name="valor1" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $valor1 = $_POST['valor1'];
            $conversao = $valor1 * 100;
            echo "<p>A conversão do valor de $valor1 m para centrímetros é : $conversao cm</p>";
        }
        // -  * x**y x/y x//y x%y x<y x>y x<=y x>=y x==y x!=y 
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>

</html>