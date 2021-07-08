<?php

/*Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras. */

$lapiceras[0] = array('color'=>"azul", 'marca'=>"bic", 'trazo'=>"fino", 'precio'=>"50");
$lapiceras[1] = array('color'=>"negro", 'marca'=>"faber", 'trazo'=>"medio", 'precio'=>"60");
$lapiceras[2] = array('color'=>"rojo", 'marca'=>"pelikan", 'trazo'=>"grueso", 'precio'=>"40");

foreach($lapiceras as $item)
{
    print_r($item);
    //var_dump($item);
    echo "<br>";
}

?>