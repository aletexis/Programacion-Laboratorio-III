<?php
/*Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por
pantalla.
Para cargar los arrays utilizar la función array_push. Para juntarlos, utilizar la función
array_merge. */

$vec = array("Perro", "Gato", "Ratón", "Araña", "Mosca");
array_push($vec, "1986", "1996", "2015", "78", "86");
array_push($vec, "php", "mysql", "html5", "typescript", "ajax");
$mix = array_merge($vec);

var_dump($mix);

?>