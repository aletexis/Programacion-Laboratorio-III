<?php

for($number=1; $number<5; $number++)
{
    echo "Potencias de " . $number . "<br>";
    
    for($power=1; $power<5; $power++)
    {
        echo CalcularPotencia($number, $power) . "<br>";
    }
}

function CalcularPotencia($number, $power)
{
    return pow ($number, $power);
}

?>