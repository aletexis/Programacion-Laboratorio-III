<?php

$text = array("hola mundo");
$inverted = array("");

function InvertirPalabra ($text)
{
    for($i = sizeof($text)-1; $i=0; $i--)
    {
        $inverted = $inverted . $text[$i];
    }
}
var_dump($inverted);
?>