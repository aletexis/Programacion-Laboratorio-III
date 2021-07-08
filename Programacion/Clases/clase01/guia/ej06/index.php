<?php

$operador = rand(1,4);
$op1 = rand(1, 100);
$op2 = rand(-50, 100);
$result;

// 1 es + 2 es - 3 es * 4 es /
echo "Numeros a operar: " . $op1 . " - " . $operador . " - " . $op2 .  "<br>";

switch($operador)
{
    case 1:
        $result = $op1+$op2;
        echo $result;
        break;
    case 2:
        $result = $op1-$op2;
        echo $result;
        break;
    case 3:
        $result = $op1*$op2;
        echo $result;
        break;
    case 4:
        $result = $op1/$op2;
        if($op2 < 1)
        {
            echo "Operador 2 no valido<br>";
            break;
        }
        echo $result;
        break;
}


?>