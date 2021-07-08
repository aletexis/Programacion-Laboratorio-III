<?php

$opcion = isset($_POST["opcion"]) ? $_POST["opcion"]: NULL;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"]:NULL;


$host = "http://tareaclase05.orgfree.com/administracion.php";
$user = "268126";
$pass = "ale280400";
$base = "268126";

switch($opcion)
{
    case "Login":

        $conection = @mysqli_connect($host, $user, $pass, $base);
        $userFound = false;

        if(!$conection)
        {
            echo "Error! No se pudo conectar a la base de datos.<br>";
            return;
        }

        echo "Se estableció la conexión a la base de datos.<br>";
        
        $sql = "SELECT usuarios.correo, usuarios.clave, usuarios.nombre, perfiles.descripcion FROM usuarios
                INNER JOIN perfiles ON usuarios.perfil = perfiles.id";

        $rs = $conection->query($sql);
      
        while($row = $rs->fetch_object())
        {
            $user_array[] = $row;
        }
       
        foreach($user_array as $item)
        {
            if($item->correo === $correo && $item->clave === $clave)
            {
                $userFound = true;
                echo "Nombre: " . $item->nombre . "<br>" . "Descripcion: " . $item->descripcion . "<br>";
                break;
            }
        }

        if(!$userFound)
        {
            echo "Error! No se pudo encontrar al usuario en la base de datos.<br>";
        }   
        
        mysqli_close($conection);

    break;
    
   
    case "Mostrar":
    
        $conection = @mysqli_connect($host, $user, $pass, $base);
        $showed = false;
        
        if(!$conection)
        {
            echo "Error! No se pudo conectar a la base de datos.<br>";
            return;
        }

        $sql = "SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM usuarios
                INNER JOIN perfiles ON usuarios.perfil = perfiles.id";

        $rs = $conection->query($sql);

        while ($row = $rs->fetch_object())
        {
            $user_array[] = $row;
        }        
        
        foreach($user_array as $item)
        {
            $showed = true;
            echo  "ID: " . $item->id . "<br>";
            echo  "Correo: " . $item->correo . "<br>";
            echo  "Clave: " . $item->clave . "<br>";  
            echo  "Nombre de usuario: " . $item->nombre . "<br>";
            echo  "Numero de perfil: " . $item->perfil . "<br";
            echo  "Descripcion del perfil: " . $item->descripcion . "<br><br><br>";                    
        }
        
        if(!$showed)
        {
            echo "Error! No se pudo mostrar los usuarios de la base de datos.<br>";
        }  

        mysqli_close($conection);
        
    break;

    default:
        echo "<h1>:(</h1><br>" . "Error! La opción ingresada no es válida.<br>";
}