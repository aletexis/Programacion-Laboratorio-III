<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response as ResponseMW;

include_once __DIR__ . "/AccesoDatos.php";
include_once __DIR__ . "/Usuario.php";
include_once __DIR__ . "/Autentificadora.php";

class MW
{
    //MW 1
    public function VerificarDatosUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
        $datosJSON = isset($request->getParsedBody()['usuario']) ? $request->getParsedBody()['usuario'] : null;
            $response = new ResponseMW();
            $stdClass = new stdClass();
            
            if($datosJSON != null)
            {
                $objJSON = json_decode($datosJSON);
                if(!isset($objJSON->correo) && !isset($objJSON->clave))
                {
                    $stdClass->mensaje = "no existe el correo y la clave";
                    $stdClass->status = 403;
                    $response->getBody()->write(json_encode($stdClass));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                if(!isset($objJSON->correo))
                {
                    $stdClass->mensaje = "no existe el correo";
                    $stdClass->status = 403;
                    $response->getBody()->write(json_encode($stdClass));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                if(!isset($objJSON->clave))
                {
                    $stdClass->mensaje = "no existe la clave";
                    $stdClass->status = 403;
                    $response->getBody()->write(json_encode($stdClass));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                    //$response = $handler->handle($request);
                    //return $response;
            }
            $response = $handler->handle($request);
            return $response;
            /*
            else
            {
                $stdClass->mensaje = "no existe el JSON";  
                $stdClass->status = 403;
                $response->getBody()->write(json_encode($stdClass));
                return $response->withHeader('Content-Type', 'application/json');
            }*/
    }

    //MW 2
    public function VerificarDatosVacios(Request $request, RequestHandler $handler): ResponseMW
    {
        $stdClass = new stdClass();
        $datosJSON = $request->getParsedBody()['usuario'];
        $response = new ResponseMW();
        
        if($datosJSON != null){
            $objJSON = json_decode($datosJSON);
            if($objJSON->correo === "" && $objJSON->clave === ""){
                $stdClass->mensaje = "Correo y Clave Vacios";
                $stdClass->status = 409;
                $response->getBody()->write(json_encode($stdClass));
                return $response->withHeader('Content-Type', 'application/json');
            }
            if($objJSON->correo === ""){
                $stdClass->mensaje = "Correo Vacio";
                $stdClass->status = 409;
                $response->getBody()->write(json_encode($stdClass));
                return $response->withHeader('Content-Type', 'application/json');
            }
            if($objJSON->clave === ""){
                $stdClass->mensaje = "Clave Vacia";
                $stdClass->status = 409;
                $response->getBody()->write(json_encode($stdClass));
                return $response->withHeader('Content-Type', 'application/json');
            }
                //$response = $handler->handle($request);
                //return $response;
                
            }
            $response = $handler->handle($request);
            return $response;
            /*else{
            $stdClass->mensaje = "no existe el obj_json";  
            $stdClass->status = 403;
            $response->getBody()->write(json_encode($stdClass));
            return $response->withHeader('Content-Type', 'application/json');
        }*/
    }

    //MW 3
    public function VerificarCorreoClaveBD(Request $request, RequestHandler $handler): ResponseMW
    {
        $stdClass = new stdClass();
            $newResponse = new ResponseMW();
            $datosJSON = json_decode($request->getParsedBody()['usuario']);
            $User = self::TraerCorreoyClave($datosJSON);
            if($User != null){
                $response = $handler->handle($request);
                return $response;
                // $stdClass->mensaje = "Datos Correctos";
                // $stdClass->status = 200;
                // $newResponse->getBody()->write(json_encode($stdClass));
                // return $newResponse->withHeader('Content-Type', 'application/json');
            }else{
                $stdClass->mensaje = "No existe la clave y el correo en la Base de Datos";
                $stdClass->status = 403;
                $newResponse->getBody()->write(json_encode($stdClass));
                return $newResponse->withHeader('Content-Type', 'application/json');
            }
    }

    public static function TraerCorreoyClave($datosJSON) 
        {
            $correo = $datosJSON->correo;
            $clave = $datosJSON->clave;
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso("localhost","root","","concesionaria_bd"); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuarios.correo,usuarios.clave,usuarios.nombre,usuarios.apellido,usuarios.perfil,usuarios.foto FROM usuarios WHERE usuarios.correo=:correo AND usuarios.clave=:clave");
            $consulta->bindValue(':correo',$correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->execute();
            $buscado = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
            return $buscado;		
        }
        
    //MW 4
    public function VerificarCorreoBD(Request $request, RequestHandler $handler): ResponseMW
    {
        /*
        $returnJSON = new stdClass();
        $returnJSON->status = 403;
        
        $newResponse = new ResponseMW();

        $params = $request->getParsedBody();
        $json = json_decode($params["usuario"]);

        $usuario = Usuario::TraerUnoCorreo($json->correo);

        if ($usuario != null)//dudoso
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());
        }
        else
        {
            $returnJSON->mensaje = "El correo ya existe en la base de datos";
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
        */

        $json = $request->getParsedBody();
        if(isset($json['user']))
        {
            $verificarCorreo = Usuario::VerificarExisteCorreoBD(json_decode($json['usuario']));
        }
        else if(isset($json['usuario']))
        {
            $verificarCorreo = Usuario::VerificarExisteCorreoBD(json_decode($json['usuario']));
        }
        $retorno = new stdClass();
        $retorno->mensaje = 'El correo existe en la base de datos';
        $retorno->status = 403;
        $responseMW = new ResponseMW();

        if(!$verificarCorreo->exito)
        {
            $response = $handler->handle($request);
            $responseMW->withStatus(200, 'OK');
            $responseMW->getBody()->write((string)$response->getBody());
            return $responseMW;
        }
        $responseMW->withStatus($retorno->status, 'Error');
        $responseMW->getBody()->write(json_encode($retorno));
        return $responseMW;
    }

    //MW 5
    public function VerificarAuto(Request $request, RequestHandler $handler): ResponseMW
    {
        $returnJSON = new stdClass();
        $returnJSON->status = 409;
        
        $newResponse = new ResponseMW();

        $params = $request->getParsedBody();
        $json = json_decode($params["auto"]);

        if (($json->precio < 50000 || $json->precio > 600000) && $json->color === "amarillo") 
        {
            $returnJSON->error = "El precio no esta en el rango permitido y el color amarillo no esta permitido";
        } 
        else if ($json->precio < 50000 || $json->precio > 600000) 
        {
            $returnJSON->error = "El precio no esta en el rango permitido";
        }
        else if ($json->color === "amarillo") 
        {
            $returnJSON->error = "El color amarillo no esta permitido";
        }
        else 
        {
            unset($returnJSON->status);
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 6
    public function VerificarToken(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);

        if ($retorno->verificado) 
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());
        }
        else
        {
            $returnJSON->error = $retorno->mensaje;
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 7
    public function VerificarPropietario(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 409;
        $returnJSON->propietario = false;

        $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
        $obj = $payloadObtenido->payload->data;
        
        if ($obj->perfil === "propietario") 
        {
            $returnJSON->propietario = true;
            $returnJSON->status = 200;
        }
        else 
        {
            $returnJSON->mensaje = "El usuario es {$obj->perfil}";
        }

        if ($returnJSON->propietario) 
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 8
    public function VerificarEncargadoYPropietario(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 409;
        $returnJSON->perfilPermitido = false;

        $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
        $obj = $payloadObtenido->payload->data;

        if ($obj->perfil === "encargado" || $obj->perfil === "propietario")
        {
            $returnJSON->perfilPermitido = true;
        }
        else
        {
            $returnJSON->mensaje = "El usuario es {$obj->perfil}";
        }

        if ($returnJSON->perfilPermitido)
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());
        }


        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 9
    public function RetornarListadoEncargado(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado) 
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "encargado") 
            {
                foreach ($returnJSON->tabla as $item) 
                {
                    unset($item->id);
                }
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 10
    public function CantidadColores(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado)
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "empleado")
            {
                $colorArray = array();
                foreach ($returnJSON->tabla as $item)
                {
                    array_push($colorArray, $item->color);
                }

                $cantidadArray = array_count_values($colorArray);

                unset($returnJSON->tabla);
                unset($returnJSON->mensaje);
                $colorArray = array_values(array_unique($colorArray));

                $returnJSON->cantidad = "Hay " . count($cantidadArray) . " colores";
                $returnJSON->colores = $colorArray;
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 11
    public function MostrarDatosPropietario(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $id = isset($request->getHeader("id")[0]) ? $request->getHeader("id")[0] : null;
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado) 
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "propietario") 
            {
                if ($id != null) 
                {
                    foreach ($returnJSON->tabla as $item) 
                    {
                        if ($item->id == $id) 
                        {
                            unset($returnJSON->tabla);
                            $returnJSON->auto = $item;
                            break;
                        }
                    }
                }
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 12
    public function RetornarUsuariosEncargado(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado) 
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "encargado") 
            {
                foreach ($returnJSON->tabla as $item) 
                {
                    unset($item->id);
                    unset($item->clave);
                }
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 13
    public function MostrarUsuariosEmpleado(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado)
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "empleado")
            {
                foreach($returnJSON->tabla as $item)
                {
                    unset($item->id);
                    unset($item->correo);
                    unset($item->clave);
                    unset($item->perfil);
                }
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //MW 14
    public function CantidadApellido(Request $request, RequestHandler $handler): ResponseMW
    {
        $jwt = $request->getHeader("jwt")[0];
        $apellido = isset($request->getHeader("apellido")[0]) ? $request->getHeader("apellido")[0] : null;
        $newResponse = new ResponseMW();
        $returnJSON = new stdClass();
        $returnJSON->status = 403;

        $retorno = Autentificadora::VerificarJWT($jwt);
        $returnJSON->mensaje = $retorno->mensaje;

        if ($retorno->verificado)
        {
            $response = $handler->handle($request);
            $returnJSON = json_decode($response->getBody());

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;

            if ($obj->perfil === "propietario")
            {
                $apellidosArray = array();

                foreach ($returnJSON->tabla as $item)
                {
                    array_push($apellidosArray, $item->apellido);
                }

                $cantidadArray = array_count_values($apellidosArray);

                unset($returnJSON->tabla);
                unset($returnJSON->mensaje);

                if ($apellido != null)
                {
                    foreach ($cantidadArray as $key => $item)
                    {
                        if ($key == $apellido)
                        {
                            $returnJSON->cantidad = "Hay {$item} apellidos iguales al pasado";
                        }
                    }
                }
                else
                {
                    $returnJSON->apellidos = $cantidadArray;
                }
            }
        }

        $newResponse->getBody()->write(json_encode($returnJSON));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    
}