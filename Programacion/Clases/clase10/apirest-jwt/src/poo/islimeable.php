<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


interface ISlimeable{

    function Crear(Request $request, Response $response, array $args) : Response;
    function Verificar(Request $request, Response $response, array $args) : Response;
    function ObtenerPayLoad(Request $request, Response $response, array $args) : Response;
    function ObtenerDatos(Request $request, Response $response, array $args) : Response;
    function VerificarPorHeader(Request $request, Response $response, array $args) : Response;
    function ObtenerAutosJson(Request $request, Response $response, array $args) : Response;
}