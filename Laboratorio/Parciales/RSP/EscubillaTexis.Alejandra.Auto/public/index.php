<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/poo/Usuario.php';
require_once __DIR__ . '/../src/poo/Auto.php';
require_once __DIR__ . '/../src/poo/MW.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->setBasePath("/public");


$twig = Twig::create('../src/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/front-end-login', function (Request $request, Response $response, array $args): Response {

    $view = Twig::fromRequest($request);

    return $view->render($response, 'login.html', []);
}); 

$app->get('/front-end-registro', function (Request $request, Response $response, array $args): Response {

    $view = Twig::fromRequest($request);

    return $view->render($response, 'registro.html', []);
});

$app->get('/front-end-principal', function (Request $request, Response $response, array $args): Response {

    $view = Twig::fromRequest($request);

    return $view->render($response, 'principal.php', []);
});


$app->post('/usuarios', \Usuario::class . ':agregarUno')->add(\MW::class . ":VerificarCorreoBD")
                                                        ->add(\MW::class . ":VerificarDatosVacios")
                                                        ->add(\MW::class . ":VerificarDatosUsuario");

$app->get('/', \Usuario::class . ':mostrarTodos')->add(\MW::class . ":RetornarUsuariosEncargado")
                                                 ->add(\MW::class . ":CantidadApellido")
                                                 ->add(\MW::class . ":MostrarUsuariosEmpleado");
                                               
$app->post('/', \Auto::class . ":agregarUno")->add(\MW::class . ':VerificarAuto');

$app->get('/autos', \Auto::class . ":mostrarTodos")->add(\MW::class . ':RetornarListadoEncargado')
                                                   ->add(\MW::class . ':CantidadColores')
                                                   ->add(\MW::class . ":MostrarDatosPropietario");

$app->post('/login', \Usuario::class . ":login")->add(\MW::class . ":VerificarCorreoClaveBD")
                                                ->add(\MW::class . ":VerificarDatosVacios")
                                                ->add(\MW::class . ":VerificarDatosUsuario");

$app->get('/login', \Usuario::class . ":verificarJWT");

$app->delete('/', \Auto::class . ":borrarUno")->add(\MW::class . ":VerificarPropietario")
                                              ->add(\MW::class . ":VerificarToken");

$app->put('/', \Auto::class . ":modificarUno")->add(\MW::class . ":VerificarEncargadoYPropietario")
                                              ->add(\MW::class . ":VerificarToken");

//$app->run();
try {
    $app->run();     
} catch (Exception $e) {    
  die( json_encode(array("status" => "failed", "message" => "This action is not allowed"))); 
}