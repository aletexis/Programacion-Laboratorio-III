<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/autentificadora.php";
require_once __DIR__ . "/islimeable.php";
require_once __DIR__ . "/imiddleware.php";


class EjemploJWT implements ISlimeable, IMiddleware{

    public function Crear(Request $request, Response $response, array $args) : Response {

        $arrayDeParametros = $request->getParsedBody();

        $token = Autentificadora::CrearJWT($arrayDeParametros, 30);

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($token));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function Verificar(Request $request, Response $response, array $args) : Response {

        $token = $request->getParsedBody()["token"];

        $obj_rta = Autentificadora::VerificarJWT($token);

        $status = $obj_rta->verificado ? 200 : 403;

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerPayLoad(Request $request, Response $response, array $args) : Response {

        $token = $request->getParsedBody()["token"];

        $obj_rta = Autentificadora::ObtenerPayLoad($token);
        
        $status = $obj_rta->exito ? 200 : 500;

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerDatos(Request $request, Response $response, array $args) : Response {

        $token = $request->getParsedBody()["token"];

        $obj_rta = new stdClass();
        $obj_rta->data = NULL;
        $obj_rta->aud = NULL;
        $obj_rta->mensaje = "";

        $obj_payload = Autentificadora::ObtenerPayLoad($token);
        
        $status = $obj_payload->exito ? 200 : 500;

        if($obj_payload->exito){

            $obj_rta->data = $obj_payload->payload->data;
            $obj_rta->aud = $obj_payload->payload->aud;
        }
        else{

            $obj_rta->mensaje = $obj_payload->mensaje;
        }

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function VerificarPorHeader(Request $request, Response $response, array $args) : Response {

        $token = $request->getHeader("token")[0];

        $obj_rta = Autentificadora::VerificarJWT($token);

        $status = $obj_rta->verificado ? 200 : 403;

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerAutosJson(Request $request, Response $response, array $args) : Response {

        $autos = $this->ObtenerAutos();

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($autos));
    
        return $newResponse->withHeader('Content-Type', 'application/json');

    }

    public function VerificarToken(Request $request, RequestHandler $handler) : ResponseMW {

        $token = $request->getHeader("token")[0];

        $obj_token = Autentificadora::VerificarJWT($token);

        $status = 200;

        $obj_datos = new stdClass();
        $obj_datos->exito = FALSE;
        $obj_datos->mensaje = "";
        $obj_datos->autos = NULL;

        if($obj_token->verificado){

            $response = $handler->handle($request);
            $obj_datos->autos = json_decode($response->getBody());
            $obj_datos->exito = TRUE;
        }
        else{

            $obj_datos->mensaje = $obj_token->mensaje;
            $status = 500;
        } 

        $response = new ResponseMW($status);

        $response->getBody()->write(json_encode($obj_datos));

        return $response->withHeader('Content-Type', 'application/json');
    }

    private function ObtenerAutos() : string {

        $path = __DIR__ . "/../archivos/autos.json";

        $a = fopen($path ,"r");

        $autos_string = fread($a, filesize($path));

        fclose($a);

        return $autos_string;
    }

}