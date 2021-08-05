<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response as ResponseMW;

include_once __DIR__ . "./AccesoDatos.php";
include_once __DIR__ . "./Usuario.php";
include_once __DIR__ . "./Autentificadora.php";

class MW
{
    public function VerificarDatosUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $newResponse = new ResponseMW();

            $params = $request->getParsedBody();
            $json = json_decode($params['usuario_json']);

            if($json != null)
            {
                $returnJSON->error = "Error al pasar el JSON con los parametros";

                if(!isset($json->correo) && !isset($json->clave))
                {
                    $returnJSON->error = "No se le paso el correo ni la clave";
                }
                else if(!isset($json->correo))
                {
                    $returnJSON->error = "No se le paso el correo";
                }
                else if(!isset($json->clave))
                {
                    $returnJSON->error = "No se le paso la clave";
                }
                else
                {
                    $response = $handler->handle($request);
                    $returnJSON = json_decode($response->getBody());
                }
            }

            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json');
        }
        
        public function VerificarDatosVacios(Request $request, RequestHandler $handler): ResponseMW
        {
            $returnJSON = new stdClass();
            $returnJSON->status = 409;
            $newResponse = new ResponseMW();

            $params = $request->getParsedBody();
            $json = json_decode($params["usuario_json"]);

            if($json->correo === "" && $json->clave === "")
            {
                $returnJSON->error = "El correo y la clave estan vacios";
            }
            else if($json->correo === "")
            {
                $returnJSON->error = "El correo esta vacio";
            }
            else if($json->clave === "")
            {
                $returnJSON->error = "La clave esta vacia";
            }
            else
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());
            }

            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public function VerificarCorreoClaveBD(Request $request, RequestHandler $handler): ResponseMW
        {
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $params = $request->getParsedBody();

            $json = $params["usuario_json"];

            $usuario = Usuario::TraerUnoCorreoClave($json);

            if($usuario != null)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());
            }
            else
            {
                $returnJSON->mensaje = "El correo y clave no existen en la base de datos";
            }

            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json'); 
        }

        public function VerificarCorreoBD(Request $request, RequestHandler $handler): ResponseMW
        {
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $params = $request->getParsedBody();

            $json = json_decode($params["usuario_json"]);

            $usuario = Usuario::TraerUnoCorreo($json->correo);

            if($usuario != null)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());
            }
            else
            {
                $returnJSON->mensaje = "El correo no existe en la base de datos";
            }

            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json'); 
        }

        public function VerificarAuto(Request $request, RequestHandler $handler): ResponseMW
        {
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 409;

            $params = $request->getParsedBody();

            $json = json_decode($params["auto_json"]);

            if(($json->precio < 50000 || $json->precio > 600000) && $json->color === "azul")
            {
                $returnJSON->error = "El precio no esta en el rango permitido y el color azul no esta permitido";
            }
            else if($json->precio < 50000 || $json->precio > 600000)
            {
                $returnJSON->error = "El precio no esta en el rango permitido";
            }
            else if($json->color === "azul")
            {
                $returnJSON->error = "El color azul no esta permitido";
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

        public function VerificarToken(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);

            if($retorno->verificado)
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

        public function VerificarPropietario(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 409;
            $returnJSON->propietario = false;

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;
            if($obj->perfil === "propietario")
            {
                $returnJSON->propietario = true;
            }
            else
            {
                $returnJSON->mensaje = "El usuario es {$obj->perfil}";
            }

            if($returnJSON->propietario)
            {
                    $response = $handler->handle($request);
                    $returnJSON = json_decode($response->getBody());
            }

            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json'); 
        }

        public function VerificarEncargadoYPropietario(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 409;
            $returnJSON->perfilPermitido = false;

            $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
            $obj = $payloadObtenido->payload->data;
            if($obj->perfil === "encargado" || $obj->perfil === "propietario")
            {
                $returnJSON->perfilPermitido = true;
            }
            else
            {
                $returnJSON->mensaje = "El usuario es {$obj->perfil}";
            }

            if($returnJSON->perfilPermitido)
            {
                    $response = $handler->handle($request);
                    $returnJSON = json_decode($response->getBody());
            }


            $newResponse->getBody()->write(json_encode($returnJSON));

            return $newResponse->withHeader('Content-Type', 'application/json'); 
        }

        public function RetornarListadoEncargado(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "encargado")
                {
                    foreach($returnJSON->tabla as $item)
                    {
                        unset($item->id);
                    }
                }
            }
            
            $newResponse->getBody()->write(json_encode($returnJSON));
            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public function CantidadColores(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "empleado")
                {
                    $colorArray = array();
                    foreach($returnJSON->tabla as $item)
                    {
                        array_push($colorArray, $item->color);
                    }

                    $cantidadArray = array_count_values($colorArray);
                    
                    unset($returnJSON->tabla);
                    unset($returnJSON->mensaje);
                    $colorArray = array_values(array_unique($colorArray));

                    $returnJSON->cantidad = "Hay ". count($cantidadArray) . " colores";
                    $returnJSON->colores = $colorArray;           
                }
            }

            $newResponse->getBody()->write(json_encode($returnJSON));
            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public function MostrarDatosPropietario(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $id = isset($request->getHeader("id")[0]) ? $request->getHeader("id")[0] : null;
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "propietario")
                {
                    if($id != null)
                    {
                        foreach($returnJSON->tabla as $item)
                        {
                            if($item->id == $id)
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
        
        public function RetornarUsuariosEncargado(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "encargado")
                {
                    foreach($returnJSON->tabla as $item)
                    {
                        unset($item->id);
                        unset($item->clave);
                    }
                }
            }
            
            $newResponse->getBody()->write(json_encode($returnJSON));
            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public function CantidadApellido(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $apellido = isset($request->getHeader("apellido")[0]) ? $request->getHeader("apellido")[0] : null;
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "propietario")
                {
                    $apellidosArray = array();
                    
                    foreach($returnJSON->tabla as $item)
                    {
                        array_push($apellidosArray, $item->apellido);
                    }

                    $cantidadArray = array_count_values($apellidosArray);
                    
                    unset($returnJSON->tabla);
                    unset($returnJSON->mensaje);

                    if($apellido != null)
                    {
                        foreach($cantidadArray as $key => $item)
                        {
                            if($key == $apellido)
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

        public function MostrarUsuariosEmpleado(Request $request, RequestHandler $handler): ResponseMW
        {
            $jwt = $request->getHeader("jwt")[0];
            $newResponse = new ResponseMW();
            $returnJSON = new stdClass();
            $returnJSON->status = 403;

            $retorno = Autentificadora::VerificarJWT($jwt);
            $returnJSON->mensaje = $retorno->mensaje;

            if($retorno->verificado)
            {
                $response = $handler->handle($request);
                $returnJSON = json_decode($response->getBody());

                $payloadObtenido = Autentificadora::ObtenerPayLoad($jwt);
                $obj = $payloadObtenido->payload->data;

                if($obj->perfil === "empleado")
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
}
