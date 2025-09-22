<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>exercicio 18</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>exercicio 18</h1>
        <form method="post">
            <div class="mb-3">
                <label for="capital" class="form-label">capital</label>
                <input type="number" id="capital" name="capital" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label for="taxa de juros" class="form-label">taxa de juros (mensal)</label>
                <input type="number" id="taxa de juros" name="taxa_de_juros" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label for="periodo" class="form-label">periodo (meses)</label>
                <input type="number" id="periodo" name="periodo" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $capital = $_POST['capital'];
            $taxa = $_POST['taxa_de_juros'];
            $periodo = $_POST['periodo'];
            $juros = $capital * (1 + $taxa / 100) ** $periodo;

            $capital_formatado = number_format($capital, 2, ',', '.');
            $taxa_formatada = number_format($taxa, 2, ',', '.');
            $juros_formatado = number_format($juros, 2, ',', '.');

            echo "<p>O montante do capital R$ $capital_formatado, com taxa de juros de $taxa_formatada% ao mês, no período de $periodo meses é de: R$ $juros_formatado</p>";
        }
        ?>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>

</html>