        <?php
        include("cabecalho.php");
        ?>
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
                echo "<p>Por serem números iguais, o resultado será a soma  x o triplo, logo: $valor1 + $valor2 * 3 = $triplo</p>";
            } else {
                $soma = $valor1 + $valor2;
                echo "<p>Por serem números diferentes, o resultado será somente a soma, logo: $valor1 + $valor2 = $soma</p>";
            }
        }
        include("rodape.php");
        ?>