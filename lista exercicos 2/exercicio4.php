        <?php
        include("cabecalho.php");
        ?>
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
        include("rodape.php");
        ?>