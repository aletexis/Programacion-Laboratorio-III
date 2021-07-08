<?php

$a = rand(1, 100);
$b = rand(1, 100);
$c = rand(1, 100);

/*
$a = 5;
$b = 5;
$c = 1;*/

echo "Numeros: " . $a . "-" . $b . "-" . $c . "<br>";

if($a>$b && $a<$c || $a>$c && $a<$b)
{
    echo "Numero medio: " . $a . "<br>";
}
else if($b>$a && $b<$c || $b>$c && $b<$a)
{
    echo "Numero medio: " . $b . "<br>";
}
else if($c>$a && $c<$b || $c>$b && $c<$a)
{
    echo "Numero medio: " . $c . "<br>";
}
else
{
    echo "No hay valor medio<br>";
}

?>