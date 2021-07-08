<?php

    $traigoTodos = array();
    $archivo = fopen("./tipos_receta.json", "r");
    $archAux = fread($archivo, filesize("./tipos_receta.json"));
    $traigoTodos = json_decode($archAux, true, 512, JSON_OBJECT_AS_ARRAY); //traigo los arrays de json
    fclose($archivo);
    echo json_encode($traigoTodos);
