<?php
namespace mi_namespace;

class Clase 
{
    public static function test()
    {
        return "método desde namespace.";
    }
}

function funcion()
{ 
    return "función desde namespace.";
}

const CONSTANTE = 3;

//echo "namespace actual: " . __NAMESPACE__ . "<br/>";