
<?php

$vec = array(rand(1,20),rand(1,20),rand(1,20),rand(1,20),rand(1,20));
$average = array_sum($vec) / 5;

if($average == 6)
{
    echo "El promedio " . number_format($average, 2) . " es igual a 6.";
}
else if($average > 6)
{
    echo "El promedio " . number_format($average, 2) . " es mayor a 6.";
}
else
{
    echo "El promedio " . number_format($average, 2) . " es menor a 6.";
}

?>