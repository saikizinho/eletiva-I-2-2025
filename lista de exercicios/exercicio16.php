<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1></h1>
        <form method="post">
            <div class="mb-3">
                <label for="preco" class="form-label">Digite o preço</label>
                <input type="number" id="preco" name="preco" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label for="desconto" class="form-label">Digite o percentual de desconto (1-100)</label>
                <input type="number" id="desconto" name="desconto" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $preco = $_POST['preco'];
            $desconto = $_POST['desconto'];
            $valor_final = $preco - ($preco * $desconto / 100);
            echo "<p>O preço final, com desconto de $desconto % sobre o preço de R$ $preco é : R$ $valor_final </p>";
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>

</html>