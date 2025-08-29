<?php

include("cabecalho.php");

$valor = 10;
if ($valor > 10) {
    echo "<h1>Valor maior que 10!</h1>";
} elseif ($valor < 20) {
    echo "<h1>Valor menor a 10!</h1>";
} else 
    echo "<h1>Valor é 10!</h1>";

include("rodape.php");
