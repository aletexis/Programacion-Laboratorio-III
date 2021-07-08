<?php

/*Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays. */

$lapiceras[0] = array('color'=>"azul", 'marca'=>"bic", 'trazo'=>"fino", 'precio'=>"50");
$lapiceras[1] = array('color'=>"negro", 'marca'=>"faber", 'trazo'=>"medio", 'precio'=>"60");
$lapiceras[2] = array('color'=>"rojo", 'marca'=>"pelikan", 'trazo'=>"grueso", 'precio'=>"40");

$vec1 = array('lapicera0'=>$lapiceras[0], 'lapicera1'=>$lapiceras[1], 'lapicera2'=>$lapiceras[2]);
$vec2 = array($lapiceras[0],$lapiceras[1],$lapiceras[2]);


foreach($vec1 as $item)
{
    print_r($item);
    //var_dump($item);
    echo "<br>";
}
echo "<br>";
foreach($vec2 as $item)
{
    print_r($item);
    //var_dump($item);
    echo "<br>";
}

?>