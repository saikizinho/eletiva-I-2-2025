        <?php
        include("cabecalho.php");
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="valor1" class="form-label">Insira o primeiro valor</label>
                <input type="number" id="valor1" name="valor1" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label for="valor2" class="form-label">Insira o segundo valor</label>
                <input type="number" id="valor2" name="valor2" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];

            if ($valor1 > $valor2) {
                echo "<p> Exibindo valores em ordem crescente: $valor2 , $valor1</p>";
            } elseif ($valor1 == $valor2) {
                echo "<p> Os valores são iguais: $valor1 , $valor2</p>";
            } else {
                echo "<p> Exibindo valores em ordem crescente: $valor1 , $valor2</p>";
            }
        }
        include("rodape.php");
        ?>