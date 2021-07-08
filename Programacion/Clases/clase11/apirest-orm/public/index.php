<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;


require __DIR__ . '/../vendor/autoload.php';

//referenciar la clase del modelo
require_once '../app/models/cd.php';

// y usar un alias para el namespace de la entidad Eloquent ORM
use \App\Models\cd as cdORM;


$app = AppFactory::create();

$container = $app->getContainer();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'cdcol_orm',
  'username' => 'root',
  'password' => '',
  'charset'   => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix'    => '',
]);

$capsule->bootEloquent();
$capsule->setAsGlobal();

$c = $container ;
$c['errorHandler'] = function ($c) {

    return function ($request, $response, $exception) use ($c) {

        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('¡Error no controlado!');
    };
};

$c['notFoundHandler'] = function ($c) {

    return function ($request, $response) use ($c) {

        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('No es una ruta correcta.');
    };
};

$c['notAllowedHandler'] = function ($c) {

    return function ($request, $response, $methods) use ($c) {

        return $response->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write('Sólo se puede por: ' . implode(', ', $methods));
    };
};

$c['phpErrorHandler'] = function ($c) {

    return function ($request, $response, $error) use ($c) {

        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('¡Algo está mal con tu PHP!');
    };
};

//************************************************************************************************************//

$app->get('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => GET";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));

  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->post('/', function (Request $request, Response $response, array $args) : Response { 

  $datos = new stdclass();

  $datos->mensaje = "API => POST";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->put('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => PUT";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->delete('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => DELETE";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});
//************************************************************************************************************//

//************************************************************************************************************//
//ORM
//************************************************************************************************************//

/*LLAMADA a funciones del ORM*/
$app->group('/orm', function (RouteCollectorProxy $grupo) {

  //TRAER TODOS
    $grupo->get('/todos/', function (Request $request, Response $response, array $args) : Response {
  
      echo  "Traer todos los cds. <br>";
  
      $array_cds = App\Models\cd::all();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($array_cds->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
      
    });

  //TRAER EL PRIMERO
    $grupo->get('/primero/', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer el primero. <br>";
  
      $cd = new \App\Models\cd();
  
      $primero = $cd->all()->first();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($primero->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //TRAER EL ÚLTIMO
    $grupo->get('/ultimo/', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer el último. <br>";
  
      $cd = new \App\Models\cd();
  
      $ultimo = $cd->all()->last();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($ultimo->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //TRAER POR ID
    $grupo->get('/{id}', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por id. <br>";
  
      $id = $args["id"];
  
      $cd = new \App\Models\cd();
  
      $un_cd = $cd->find($id);
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($un_cd->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //TRAER POR AÑO
    $grupo->get('/anio/{anio}',function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por año. <br>";
  
      $anio = $args["anio"];
  
      $cd = new \App\Models\cd();
  
      $array_cds = $cd->where('jahr', $anio)->get();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($array_cds->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //TÍTULO
    $grupo->get('/titulo/{titulo}', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por título. <br>";
  
      $titulo = $args["titulo"];
  
      $cd = new \App\Models\cd();
  
      $array_cds = $cd->where('titel', "like", $titulo)->get();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($array_cds->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //INTÉRPRETE
    $grupo->get('/interprete/{inter}', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por intérprete. <br>";
  
      $inter = $args["inter"];
  
      $cd = new \App\Models\cd();
  
      $array_cds = $cd->whereinterpret($inter)->get();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($array_cds->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });
  
  //TRAER POR PARÁMETROS
    $grupo->post('/params/', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por parámetros. <br>";
  
      $param_array = $request->getParsedBody();
  
      $obj = json_decode($param_array["obj_json"]);
  
      $cd = new cdORM();
  
      $array_cds = [];
  
      if(property_exists($obj, "id")){
  
        $array_cds = $cd->whereid($obj->id)->get();
      }
  
      if(property_exists($obj, "titel")){
        
        $array_cds = $cd->wheretitel($obj->titel)->get();
      }
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($array_cds->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });
  
  //AGREGAR
    $grupo->post('/', function (Request $request, Response $response, array $args) : Response {
  
      echo "Agregar un cd. <br>";
  
      $cd = new cdORM();
  
      $cd->titel = "Álbum nuevo";
      $cd->interpret = "uno nuevo";
      $cd->jahr = 2021;
      
      $cd->save();

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($cd->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //MODIFICAR
    $grupo->patch('/{id}', function (Request $request, Response $response, array $args) : Response {
  
      echo "Modificar un cd. <br>";
  
      $cd = new cdORM();
  
      $id = $args["id"];
    
      $un_cd = $cd->find($id);
  
      $un_cd->titel = "Álbum modificado";
      $un_cd->interpret = "uno modificado";
      $un_cd->jahr = 2022;
      
      $un_cd->save();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($un_cd->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //BORRAR    
    $grupo->delete('/{id}', function (Request $request, Response $response, array $args) : Response {
  
      echo "Borrar un cd. <br>";
  
      $id = $args["id"];
  
      $cd = new cdORM();
  
      $cd->find($id)->delete();
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode("Borrado!!!"));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });
  
  
  //EJECUTAR QUERY O FUNCIÓN
    $grupo->get('/funciones/', function (Request $request, Response $response, array $args) : Response {
  
      $rta = new stdClass();
      $rta->mensaje = "Traer el primer cd por parámetros o ejecutar función. <br>";
  
      $param_array = $request->getParsedBody();

      $obj = json_decode($param_array["obj_json"]);
  
      $un_cd = cdORM::where('titel', $obj->titel)->firstOr(function(){
        
        $rta = new stdClass();
        $rta->exito = false;
        $rta->mensaje = "No hay registros que coincidan con el parámetro envidado.";
        
        echo json_encode($rta);
  
      });
  
      if($un_cd != null){
  
        $rta->cd = $un_cd;
      }

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($rta));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
      
    });

  //EJECUTAR QUERY O LANZAR EXCEPCIÓN
    $grupo->get('/excepciones/', function (Request $request, Response $response, array $args) : Response {
  
      echo "Traer un cd por parámetros o lanzar excepción. <br>";
  
      $param_array = $request->getParsedBody();
  
      $obj = json_decode($param_array["obj_json"]);
  
      $cd = new cdORM();
  
      $un_cd = $cd->findOrFail($obj->id);
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write($un_cd->toJson());
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //EJECUTAR QUERY CON FUNCIONES DE AGREGADO
    $grupo->get('/funciones/agregado/', function (Request $request, Response $response, array $args) : Response {
  
      $mensaje = "Funciones de agregado (count, max, min, avg, y sum). <br>";
  
      $cantidad_cds = cdORM::all()->count();
      $anio_mayor = cdORM::all()->max("jahr");
      $anio_menor = cdORM::all()->min("jahr");
      $suma_anios = cdORM::all()->sum("jahr");
      $promedio_anios = cdORM::all()->avg("jahr");
  
      $mensaje .= "Total: {$cantidad_cds} - año mayor: {$anio_mayor} - año menor: {$anio_menor} " . 
            "- sumatoria de años: {$suma_anios} - promedio de años: {$promedio_anios}";

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($mensaje));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
        
    });
  
  //https://laravel.com/docs/8.x/queries
  
  //EJECUTAR QUERY
  $grupo->get('/query/', function (Request $request, Response $response, array $args) : Response {
  
    echo "Ejecuta query desde Capsule. <br>";
  
    $cds = Capsule::table('cds')->where('jahr', '>', 1990)->get();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($cds->toJson());
    
    return $newResponse->withHeader('Content-Type', 'application/json');
  
  });
  //EJECUTAR QUERY COMPLETA
  $grupo->get('/query/completa/', function (Request $request, Response $response, array $args) : Response {
  
    echo "Ejecuta query completa desde Capsule. <br>";
  
    $cds = Capsule::table('cds')->where('jahr', '>', 1990)
                                ->whereIn('id', [1,2,3,4,5])
                                ->where('titel', 'like', 'G%')
                                ->orWhere('interpret', 'Ryuichi Sakamoto')
                                ->orWhere(function($query) {
                                  $query->whereDate('created_at', '>', '2021-03-01')
                                        ->whereNull('updated_at');
                                })
                                ->orderBy('titel')
                                ->limit(3)
                                ->get();
    //select * from cds 
    //where jahr > 1990 and id in (1,2,3,4,5) 
    //and titel like 'G%' or interpret = 'Ryuichi Sakamoto' 
    //or (created_at > '2021-03-01' and updated_at = null)
    //order by titel
    //limit 3
    
    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($cds->toJson());
    
    return $newResponse->withHeader('Content-Type', 'application/json');
  
  });

  //EJECUTAR CONSULTA COMO SQL 
    $grupo->get('/select_sql/', function (Request $request, Response $response, array $args) : Response {
  
      $mensaje = "Ejecuta query desde Capsule, como consulta sql. <br>";
  
      $rs = Capsule::select('select * from cds where id >= ?', [1]);
      
      foreach ($rs as $value) {
        
        $mensaje .= $value->id . " - " . $value->titel . " - " . $value->jahr . " - " . $value->interpret . "<br>";
  
      }

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($mensaje));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });

  //EJECUTAR CONSULTA PARA ABM 
    $grupo->post('/query_abm/', function (Request $request, Response $response, array $args) : Response {
  
      $mensaje = "Agregar cd desde query. <br>";
  
      $id_agregado = Capsule::table('cds')->insertGetId([
        'titel' => 'agregado desde query',
        'jahr' => 2021,
        'interpret' => 'interprete desde query'
      ]);
  
      $mensaje .= "ID del nuevo registro: {$id_agregado}";

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($mensaje));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });
  
    $grupo->patch('/query_abm/', function (Request $request, Response $response, array $args) : Response {
  
      $mensaje = "Modificar cd desde query. <br>";
    
      $cantidad_filas_afectadas = Capsule::table('cds')->where('id', 8)
                                                       ->update(['titel' => 'modificado desde query',
                                                                 'jahr' => 2020,
                                                                 'interpret' => 'interprete modificado']);
  
      $mensaje .= "Cantidad de filas afectadas = {$cantidad_filas_afectadas}";

      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($mensaje));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
  
    });
  
    $grupo->delete('/query_abm/', function (Request $request, Response $response, array $args) : Response {
  
      $mensaje = "Borrar cd desde query. <br>";
    
      $cantidad_filas_afectadas = Capsule::table('cds')->where('id', 8)->delete();
  
      $mensaje .= "Cantidad de filas afectadas = {$cantidad_filas_afectadas}";
  
      $newResponse = $response->withStatus(200);
      $newResponse->getBody()->write(json_encode($mensaje));
      
      return $newResponse->withHeader('Content-Type', 'application/json');
    }); 
  
  });

  
//CORRE LA APLICACIÓN.
$app->run();