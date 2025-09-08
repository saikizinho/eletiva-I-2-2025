<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produto com desconto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Produto com desconto</h1>
        <form method="post">
            <div class="mb-3">
                <label for="valor1" class="form-label">Insira o valor do produto</label>
                <input type="number" id="valor1" name="valor1" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        // Função para formatar valores monetários
        function moeda($valor)
        {
            return number_format($valor, 2, ",", ".");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $valor1 = $_POST['valor1'];

            if ($valor1 > 100.00) {
                $desconto = $valor1 * 0.15;
                $vlfinal = $valor1 - $desconto;

                echo "<p> 
                        O valor do produto foi de R$ " . moeda($valor1) .
                    " , superior a R$ 100,00.<br> 
                        Logo haverá desconto de 15% (R$ " . moeda($desconto) . ") 
                        e o novo valor será = R$ " . moeda($vlfinal) .
                    "</p>";
            } else {
                echo "<p> 
                        O valor do produto é menor ou igual a R$ 100,00.<br> 
                        Logo seu preço se mantém o mesmo = R$ " . moeda($valor1) .
                    "</p>";
            }
        }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>