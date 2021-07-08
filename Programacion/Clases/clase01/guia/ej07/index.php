<?php

date_default_timezone_set('America/Buenos_Aires');
echo "Fecha del servidor: " . date("d/m/Y - h:i:s");

$day = date("d");
$month = date("m");
$dayInt = intval($day);

switch($month)
{
    case "01":
    case "02":
        echo "<br>Estacion: Verano <br>";
        break;
    
    case "04":
    case "05":
        echo "<br>Estacion: Otoño <br>";
        break;

    case "07":
    case "08":
        echo "<br>Estacion: Invierno <br>";
        break;

    case "10":
    case "11":
        echo "<br>Estacion: Primavera <br>";
        break;
}

if($month == "12" && $dayInt >= 21 || $month == "03" && $dayInt < 21)
{
    echo "<br>Estacion: Verano <br>";
}
if($month == "03" && $dayInt >= 21 || $month == "06" && $dayInt < 21)
{
    echo "<br>Estacion: Otoño <br>";
}
if($month == "06" && $dayInt >= 21 || $month == "09" && $dayInt < 21)
{
    echo "<br>Estacion: Invierno <br>";
}
if($month == "09" && $dayInt >= 21 || $month == "12" && $dayInt < 21)
{
    echo "<br>Estacion: Primavera <br>";
}

?>