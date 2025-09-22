        <?php
        include("cabecalho.php");
        ?>
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

            echo "<h3>Números de 1 até $numero:</h3>";
            echo "<p>";

            for ($i = 1; $i <= $numero; $i++) {
                echo $i . " ";
            }

            echo "</p>";
        }
        include("rodape.php");
        ?>