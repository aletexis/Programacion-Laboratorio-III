<?php

$number = 0;
$next = 1;
$sum = 0;
$counter = 0;

while($sum < 1000)
{
    $number = $number + $next;
    $sum = $number;
    echo "Numero sumado: " . $next . "<br>"; 
    echo "Suma: " . $sum . "<br>";
    $next++;
    $counter ++;
    if(($sum + $next) > 1000)
    {
        break;
    }
}

echo "Se sumaron " . $counter . " numeros";

?>