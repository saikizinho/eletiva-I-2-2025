<?php
    $nome = "Vinicius";
    echo "<p> Todas em maiusculo: " .strtoupper($nome). "</p>";
    echo "<p> Todas em minusculo: " .strtolower($nome). "</p>";


    echo "<p> Qtd de caracteres: " .strlen($nome). "</p>";


    $posicao = strpos($nome, "s");
    echo "Caracter E na posição $posicao</p>";

    date_default_timezone_set('America/Sao_paulo');
    $data1 = date("d/m/Y");
    $dia = date("d");
    $hora = date("H:i:s");
    echo "<p>Data : $data1</p>";
    echo "<p>Dia : $dia</p>";
    echo "<p>Hora : $hora</p>";

    if (checkdate(2,30,2025)){
        echo "<p> A data informada existe (30/02/2025) </p>";
    }
    else {
        echo "<p>A data informada não existe (30/02/2025) </p>";
    }

    $valor = -10;
    echo "<p>Valor absoluto: " .abs($valor)."</p>";

    $valor = 5.9;
    echo "<p>Valor arredondado: " .round($valor). "</p>";

    $valor = rand (1,100);
    echo "<p>Valor aleatorio: $valor</p>";

    echo "<p> Raiz quadrada de 16: ".sqrt(16). "</p>";

    $valor = 13.5;
    echo "<p>Valor formatado : R$". number_format($valor,2,",","."). "</p>";


    function exibirSaudacao(){
        echo "<p> Olá mundo !</p>";
    }
    exibirSaudacao();

    function exibirSaudacaoComNome($nome){
        echo "<p>Seja bem-vindo $nome</p>";
    }

exibirSaudacaoComNome("Vinicius");


    function menorValor($valor1,$valor2){
        return min($valor1,$valor2);
    }
    echo "menor valor entre 4 e 8: " .menorValor(8,4);

    function somarValores(...$numeros){
        return array_sum($numeros);
    }
    $soma = somarValores(1,2,3,4,5,6);
    echo "<p>A soma dos valodes é :$soma </p>";