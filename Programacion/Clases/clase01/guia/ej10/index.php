<?php

/*Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach. */

$vec = array(1,3,5,7,9,11,13,15,17,19);

for($i=0; $i<10; $i++)
{
    var_dump($vec[$i]);
    echo "<br>";
}

echo "<br>";

foreach($vec as $item)
{
    var_dump($item);
    echo "<br>";
}

echo "<br>";

$j=0;
while($j<10)
{
    var_dump($vec[$j]);
    echo "<br>";
    $j++;
}

?>