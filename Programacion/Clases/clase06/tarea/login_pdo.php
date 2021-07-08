<?php

$opcion = isset($_POST["opcion"]) ? $_POST["opcion"]: NULL;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"]:NULL;


$host = "http://tareaclase06.orgfree.com/login_pdo.php";
$user = "271097";
$pass = "28042000";
$base = "271097";

switch($opcion)
{
    case "Login":
        
        try
        {
            $pdo = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user, $pass);
            $login = $pdo->prepare('SELECT nombre, perfiles.descripcion FROM usuarios
                                    INNER JOIN perfiles ON perfiles.id = usuarios.id WHERE correo = :correo AND clave = :clave');

            $login->bindValue(':correo', $correo, PDO::PARAM_STR);
            $login->bindValue(':clave', $clave, PDO::PARAM_STR);
            $login->execute();
            $usuario = $login->fetch(PDO::FETCH_ASSOC);
            
            if(!$login->rowCount())
            {
                echo "Error! Correo y/o contraseña incorrectos.";
            }
            else
            {
                echo $usuario['nombre'] . ' ' . $usuario['descripcion'];
            }
        }
        catch (PDOException $e) 
        {
            print "Error! " . $e->getMessage();
            die();
        }

    break;
    
   
    case "Mostrar":
        
        try
        {
            $pdo = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user, $pass);
            $mostrar = $pdo->prepare('SELECT * FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.perfil');
            $mostrar->execute();
            
            if(!$mostrar->rowCount())
            {
                echo "Error! No se pudo mostrar los usuarios";
            }
            else
            {
                while($user = $mostrar->fetch(PDO::FETCH_OBJ))
                {
                    echo ($user->id . " - " . $user->correo . " - " . $user->clave . " - " . $user->nombre . " - " . $user->perfil . " - " . $user->descripcion) . "<br/>";
                }
            }
        }
        catch(PDOException $e)
        {
            print "Error! " . $e->getMessage();
            die();
        }

    break;
    
    case "Alta":
        
        try
        {
            $obj = json_decode($_POST['obj_json']);
            $pdo = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user, $pass);
            $alta = $pdo->prepare('INSERT INTO usuarios (id, correo, clave, nombre, perfil) VALUES (NULL, :correo, :clave, :nombre, :perfil)');
            $alta->bindValue(':correo', $obj->correo, PDO::PARAM_STR);
            $alta->bindValue(':clave', $obj->clave, PDO::PARAM_STR);
            $alta->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
            $alta->bindValue(':perfil', $obj->perfil, PDO::PARAM_INT);
            $alta->execute();

            if(!$alta->rowCount())
            {
                echo "Error! No se pudo dar de alta al usuario";
            }
            else
            {
                echo "Usuario agregado exitosamente!";
            }
        }
        catch(PDOException $e)
        {
            print "Error! " . $e->getMessage();
            die();
        }
        break;
    
    case "Modificacion":
        
        $obj = json_decode($_POST['obj_json']);
        $id_usuario = $_POST['id'];
        
        try
        {
            $pdo = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user, $pass);
            $update = $pdo->prepare('UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, perfil = :perfil WHERE usuarios.id = :id');
            $update->bindValue(':correo', $obj->correo, PDO::PARAM_STR);
            $update->bindValue(':clave', $obj->clave, PDO::PARAM_STR);
            $update->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
            $update->bindValue(':perfil', $obj->perfil, PDO::PARAM_INT);
            $update->bindValue(':id', $id_usuario, PDO::PARAM_INT);
            $update->execute();
            
            if(!$update->rowCount())
            {
                echo "Error! No se pudo modificar al usuario";
            }
            else
            {
                echo "Usuario modificado exitosamente!";
            }
        }
        catch(PDOException $e)
        {
            print "Error! " . $e->getMessage();
            die();
        }

        break;
    
    case "Baja":
        
        try
        {
            $pdo = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user, $pass);
            $delete = $pdo->prepare('DELETE FROM usuarios WHERE usuarios.id = :id');
            $delete->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
            $delete->execute();
            
            if(!$delete->rowCount())
            {
                echo "Error! No se pudo borrar al usuario";
            }
            else
            {
                echo "Usuario borrado exitosamente!";
            }
        }
        catch(PDOException $e)
        {
            print "Error! " . $e->getMessage();
            die();
        }

        break;

    default:
        echo "<h1>:(</h1><br>" . "Error! La opción ingresada no es válida.<br>";
}

?>