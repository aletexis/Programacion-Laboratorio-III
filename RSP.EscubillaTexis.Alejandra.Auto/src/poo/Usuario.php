<?php

use Mpdf\Mpdf;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

include_once "./../../vendor/autoload.php";
require_once("AccesoDatos.php");
require_once("Autentificadora.php");

class Usuario
{
    public $id;
    public $nombre;
    public $correo;
    public $apellido;
    public $clave;
    public $perfil;
    public $foto;

    /************************************************************************************************************
     * INTERACTUAN CON LA BD                                                                                    *
     ************************************************************************************************************/

    public static function ValidarFoto($foto)
    {
        $returnValue = false;
        
        if($foto->getError() === UPLOAD_ERR_OK)
        {
            if($foto != FALSE)
            {
                $filename = $foto->getClientFilename();
                $extension = explode(".", $filename);
                $extension = array_reverse($extension)[0];
                
                if($extension == "jpg" ||  $extension == "bmp" ||  $extension == "gif" ||  $extension == "png" ||  $extension == "jpeg")
                {
                    $returnValue = true;
                }
            }
        }
        return $returnValue;
    }

    public static function AgregarUsuario($correo, $clave, $nombre, $apellido, $foto, $perfil)
    {
        $returnValue = false;

        if(Usuario::ValidarFoto($foto))
        {
            foreach(self::MostrarUsuarios() as $item)
            {
                $ultimoId = $item->id;
            }
            
            $ultimoId += 1;
            $filename = $foto->getClientFilename();
            $extension = explode(".", $filename);
            $nombreArchivo = $ultimoId .'_' . $apellido . '.'. array_reverse($extension)[0];
            $destino = "./../fotos/" . $nombreArchivo;
            
            try {
                $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
                $query = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,apellido,foto,perfil) VALUES (:correo, :clave, :nombre, :apellido, :foto, :perfil)");
                $query->bindValue(':correo', $correo, PDO::PARAM_STR);
                $query->bindValue(':clave', $clave, PDO::PARAM_STR);
                $query->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $query->bindValue(':apellido', $apellido, PDO::PARAM_STR);
                $query->bindValue(':foto', $nombreArchivo, PDO::PARAM_STR);
                $query->bindValue(':perfil', $perfil, PDO::PARAM_STR);
                $query->execute();
                
                if($query->rowCount() > 0)
                {
                    $foto->moveTo(__DIR__ . $destino);
                    $returnValue = true;
                }
            }
            catch (Exception $e)
            {
                echo "Error: {$e->getMessage()}";
            }
        }

        return $returnValue;
    }

    public static function EliminarUsuario($id)
	{
		$returnValue = false;
		
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id=:id");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() > 0)
            {
                $returnValue = true;
            }
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

		return $returnValue;
	}

    public static function ModificarUsuario($datosModificar,$newPathFoto)
	{
        $returnValue = false;

        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido, foto =:foto, perfil = :perfil WHERE id = :id");
            $query->bindValue(':id', $datosModificar->id, PDO::PARAM_INT);
            $query->bindValue(':correo', $datosModificar->correo, PDO::PARAM_STR);
            $query->bindValue(':clave', $datosModificar->clave, PDO::PARAM_STR);
            $query->bindValue(':nombre', $datosModificar->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido', $datosModificar->apellido, PDO::PARAM_STR);
            $query->bindValue(':foto', $newPathFoto, PDO::PARAM_STR);
            $query->bindValue(':perfil', $datosModificar->perfil, PDO::PARAM_STR);
            $query->execute();
            
            if($query->rowCount() > 0)
            {
                $returnValue = true;
            }
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

        return $returnValue;
    }

    public static function MostrarUsuario($id)
    {
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta('SELECT * FROM usuarios WHERE id = :id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

        return $query->fetch();		
    }

    public static function MostrarUsuarios()
    {
        try {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT * FROM usuarios");
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ);
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

        return $query->fetchAll();
    }

    public static function VerificarUsuario($correo, $clave)
    {
        try {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT id, correo, nombre, apellido, foto, perfil FROM usuarios where clave = :clave AND correo = :correo");
            $query->bindValue(':clave', $clave);
            $query->bindValue(':correo', $correo);
            $query->execute();
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

        return $query->fetchObject();
    }

    public static function TraerUnoCorreoClave($json)
    {
        $usuario = json_decode($json);
        $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo AND clave = :clave");
        $query->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $query->bindValue(':correo', $usuario->correo, PDO::PARAM_STR);

        try
        {
            $query->execute();
            return $query->fetchObject("Usuario");
        }
        catch(PDOException $e)
        {
            echo "Error: {$e->getMessage()}";
        }
    }

    public static function TraerUnoCorreo($correo)
    {
        $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo");
        $query->bindValue(':correo', $correo, PDO::PARAM_STR);

        try
        {
            $query->execute();
            return $query->fetchObject("Usuario");
        }
        catch(PDOException $e)
        {
            echo "Error: {$e->getMessage()}";
        }
    }

    /************************************************************************************************************
     * INTERACTUAN CON LA API                                                                                   *
     ************************************************************************************************************/
    
    public static function agregarUno(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();
        $obj_json = null;
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo agregar el usuario';
        $returnJSON->status = 418;

        if(isset($params['usuario']))
        {
            $obj_json = json_decode($params["usuario"]);
        }

        $newUser = $obj_json;
        $foto = $request->getUploadedFiles()['foto'];

        if(Usuario::AgregarUsuario($newUser->correo, $newUser->clave, $newUser->nombre, $newUser->apellido, $foto, $newUser->perfil))
        {
            $returnJSON->exito = true;
            $returnJSON->mensaje = "Usuario agregado correctamente";
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function borrarUno(Request $request, Response $response, array $args): Response
    {
        $paramsUsuario = json_decode($request->getBody());
        $token = $request->getHeader('token')[0];

        $verificacion = Autentificadora::ObtenerPayLoad($token);
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo eliminar el usuario' . $verificacion->mensaje;
        $returnJSON->status = 418;

        if($verificacion->exito)
        {
            if(Usuario::EliminarUsuario($paramsUsuario->id_usuario))
            {
                $returnJSON->exito = true;
                $returnJSON->mensaje = "Usuario eliminado correctamente";
                $returnJSON->status = 200;
            }
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function modificarUno(Request $request, Response $response, array $args): Response
    {
        $paramsUsuario = json_decode($request->getBody());
        $token = $request->getHeader('token')[0];

        $verificacion = Autentificadora::ObtenerPayLoad($token);
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo modificar el usuario' . $verificacion->mensaje;
        $returnJSON->status = 418;

        $file = $request->getUploadedFiles();//$_FILES
        $destiny = __DIR__ . "/../fotos/";
        $nameBefore = $file['foto']->getClientFilename();
        $extension = explode(".", $nameBefore);
        $extension = array_reverse($extension);
        $newPathFoto = $paramsUsuario->id."_".$paramsUsuario->apellido.'.'.$extension[0];
        $fotoAnterior = self::MostrarUsuario($paramsUsuario->id)[0]->foto;

        if($verificacion->exito)
        {
            if(Usuario::ModificarUsuario($paramsUsuario->id, $paramsUsuario->correo, $paramsUsuario->clave, $paramsUsuario->nombre, $paramsUsuario->apellido, $paramsUsuario->perfil))
            {
                if(file_exists("/../fotos/".$fotoAnterior))
                {
                    unlink("/../fotos/".$fotoAnterior);
                }
                $file['foto']->moveTo($destiny . $newPathFoto);
                self::ModificarUsuario($paramsUsuario,$newPathFoto);
                $returnJSON->exito = true;
                $returnJSON->mensaje = "Usuario modificado correctamente";
                $returnJSON->status = 200;
            }
        }
        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function mostrarTodos(Request $request, Response $response, array $args): Response
    {
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo mostrar el listado de usuarios';
        $returnJSON->dato = "";
        $returnJSON->status = 424;

        $dato = Usuario::MostrarUsuarios();

        if($dato != false)
        {
            $returnJSON->exito = true;
            $returnJSON->mensaje = "Listado de usuarios mostrado correctamente";
            $returnJSON->dato = $dato;
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function login(Request $request, Response $response, array $args): Response
    {
        $user = json_decode($request->getParsedBody()['user']);
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->jwt = null;
        $returnJSON->status = 403;

        $usuario = Usuario::VerificarUsuario($user->correo, $user->clave);

        if($usuario != null)
        {
            $returnJSON->exito = true;
            $returnJSON->jwt = Autentificadora::CrearJWT($usuario, 45);
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function verificarJWT(Request $request, Response $response, array $args): Response
    {
        $token = $request->getHeader('token')[0];
        $returnJSON = new stdClass();
        $returnJSON->status = 403;
        $verificacion = Autentificadora::VerificarJWT($token);
        $returnJSON->msg = $verificacion->mensaje;

        if($verificacion->verificado)
        {
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
}
