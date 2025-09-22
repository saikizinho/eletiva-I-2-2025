        <?php
        include("cabecalho.php");
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="mes" class="form-label">Digite um número de 1 a 12:</label>
                <input type="number" id="mes" name="mes" class="form-control" min="1" max="12" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mes = $_POST['mes'];

            switch ($mes) {
                case 1:
                    $nomeMes = "Janeiro";
                    break;
                case 2:
                    $nomeMes = "Fevereiro";
                    break;
                case 3:
                    $nomeMes = "Março";
                    break;
                case 4:
                    $nomeMes = "Abril";
                    break;
                case 5:
                    $nomeMes = "Maio";
                    break;
                case 6:
                    $nomeMes = "Junho";
                    break;
                case 7:
                    $nomeMes = "Julho";
                    break;
                case 8:
                    $nomeMes = "Agosto";
                    break;
                case 9:
                    $nomeMes = "Setembro";
                    break;
                case 10:
                    $nomeMes = "Outubro";
                    break;
                case 11:
                    $nomeMes = "Novembro";
                    break;
                case 12:
                    $nomeMes = "Dezembro";
                    break;
                default:
                    $nomeMes = "Número inválido. Digite um valor entre 1 e 12.";
            }

            echo "<p><strong>Resultado:</strong> $nomeMes</p>";
        }
        include("rodape.php");
        ?>