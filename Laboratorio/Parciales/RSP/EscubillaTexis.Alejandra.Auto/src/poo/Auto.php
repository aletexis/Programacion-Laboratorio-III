<?php

use Slim\Psr7\Response;
use Slim\Psr7\Request;

require_once "AccesoDatos.php";

class Auto
{
    public $color;
    public $marca;
    public $precio;
    public $modelo;

    /************************************************************************************************************
     * INTERACTUAN CON LA BD                                                                                    *
     ************************************************************************************************************/

    public function AgregarAuto()
	{
		$returnValue = false;

        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("INSERT INTO autos (marca, modelo, color, precio) VALUES (:marca, :modelo, :color, :precio)");
            $query->bindValue(':color',$this->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$this->marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$this->precio, PDO::PARAM_INT);
            $query->bindValue(':modelo', $this->modelo, PDO::PARAM_STR);
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

    public static function EliminarAuto($id)
	{
		$returnValue = false;
        
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("DELETE FROM autos WHERE id=:id");
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

    public static function ModificarAuto($id, $color, $marca, $precio, $modelo)
	{
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("UPDATE autos SET color = :color, marca = :marca, precio = :precio, modelo = :modelo WHERE id = :id");
            $query->bindValue(':id',$id, PDO::PARAM_INT);
            $query->bindValue(':color',$color, PDO::PARAM_STR);
            $query->bindValue(':marca',$marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$precio, PDO::PARAM_INT);
            $query->bindValue(':modelo', $modelo, PDO::PARAM_STR);
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

		return $query->execute();
	}

    /*public static function MostrarAuto($id)
	{
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("SELECT color FROM autos WHERE id=:id");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

		return $query->fetch();
	}*/

	public static function MostrarAutos()
	{
        try {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
            $query = $objetoAccesoDato->RetornarConsulta("SELECT id, marca, modelo, precio, color FROM autos");
            $query->execute();
        }
        catch (Exception $e)
        {
            echo "Error: {$e->getMessage()}";
        }

		return $query->fetchAll(PDO::FETCH_CLASS, "Auto");
	}


    /************************************************************************************************************
     * INTERACTUAN CON LA API                                                                                   *
     ************************************************************************************************************/

    public static function agregarUno(Request $request, Response $response, array $args): Response
    {
        $paramsAuto = json_decode($request->getParsedBody()['auto']);
		$newAuto = new Auto();
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = "No se pudo agregar el auto";
        $returnJSON->status = 418;
        
		$newAuto->color = $paramsAuto->color;
		$newAuto->marca = $paramsAuto->marca;
		$newAuto->precio = $paramsAuto->precio;
		$newAuto->modelo = $paramsAuto->modelo;

        if($newAuto->AgregarAuto())
        {
            $returnJSON->exito = true;
            $returnJSON->mensaje = "Auto agregado correctamente";
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function borrarUno(Request $request, Response $response, array $args): Response
    {
        $idAuto = json_decode($request->getBody())->id_auto;
        $token = $request->getHeader('token')[0];
        
        $verificacion = Autentificadora::ObtenerPayLoad($token);
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo eliminar el auto ' . $verificacion->mensaje;
        $returnJSON->status = 418;

        if($verificacion->exito)
        {
            $datosAuto = $verificacion->payload->data;
            if($datosAuto[0]->perfil == "propietario")
            {
                if(Auto::EliminarAuto($idAuto))
                {
                    $returnJSON->exito = true;
                    $returnJSON->mensaje = "Auto eliminado correctamente";
                    $returnJSON->status = 200;
                }
            }
            else
            {
                $returnJSON->mensaje = ' No es propietario';
            }
        }
        
        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function modificarUno(Request $request, Response $response, array $args): Response
    {
        $paramAuto = json_decode($request->getBody());
        $idAuto = json_decode($request->getBody())->id_auto;
        $token = $request->getHeader('token')[0];

        $verificacion = Autentificadora::ObtenerPayLoad($token);
        $returnJSON = new stdClass();
        $returnJSON->exito = false;
        $returnJSON->mensaje = 'No se pudo modificar el auto ' . $verificacion->mensaje;
        $returnJSON->status = 418;

        if($verificacion->exito)
        {
            $datosAuto = $verificacion->payload->data;
            if($datosAuto[0]->perfil == "encargado")
            {
                if(Auto::ModificarAuto($idAuto, $paramAuto->color, $paramAuto->marca, $paramAuto->precio, $paramAuto->modelo))
                {
                    $returnJSON->exito = true;
                    $returnJSON->mensaje = "Auto modificado correctamente";
                    $returnJSON->status = 200;
                }
            }
            else
            {
                $returnJSON->mensaje = ' No es encargado';
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
        $returnJSON->mensaje = 'No se pudo mostrar el listado de autos';
        $returnJSON->dato = "";
        $returnJSON->status = 424;

        $dato = Auto::MostrarAutos();

        if($dato != false)
        {
            $returnJSON->exito = true;
            $returnJSON->mensaje = "Listado de autos mostrado correctamente";
            $returnJSON->dato = $dato;
            $returnJSON->status = 200;
        }

        $newResponse = new Response($returnJSON->status);
        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
}