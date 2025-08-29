<?php
include("cabecalho.php");

//1 domingo, 2 segunda, 3 terça, 4 quarta, 5 quinta, 6 sexta, 7 sábado

$diaSemana = 3;

switch ($diaSemana) {
    case 1:
        echo "<h1>Domingo</h1>";
        break;
    case 2:
        echo "<h1>Segunda-feira</h1>";
        break;
    case 3:
        echo "<h1>Terça-feira</h1>";
        break;
    case 4:
        echo "<h1>Quarta-feira</h1>";
        break;
    default:
        echo "<h1>Hoje pode ser quinta,sexta,sábado</h1>";
        break;
}    

include("rodape.php");
?>