<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once "AccesoDatos.php";
require_once "islimeable.php";

class Cd implements ISlimeable
{
	public $id;
 	public $titulo;
  	public $cantante;
  	public $año;

//*********************************************************************************************//
/* IMPLEMENTO LAS FUNCIONES PARA SLIM */
//*********************************************************************************************//

	public function TraerTodos(Request $request, Response $response, array $args): Response 
	{
		$todosLosCds = Cd::TraerTodoLosCds();
  
		$newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write(json_encode($todosLosCds));

		return $newResponse->withHeader('Content-Type', 'application/json');	
	}

	public function TraerUno(Request $request, Response $response, array $args): Response 
	{
     	$id = $args['id'];
    	$elCd = Cd::TraerUnCd($id);

		$newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write(json_encode($elCd));	

		return $newResponse->withHeader('Content-Type', 'application/json');
	}
	
	public function AgregarUno(Request $request, Response $response, array $args): Response 
	{
        $arrayDeParametros = $request->getParsedBody();

		$titulo= $arrayDeParametros['titulo'];
        $cantante= $arrayDeParametros['cantante'];
        $año= $arrayDeParametros['anio'];
        
        $micd = new Cd();
        $micd->titulo = $titulo;
        $micd->cantante = $cantante;
		$micd->año = $año;		

        $id_agregado = $micd->InsertarCd();

//*********************************************************************************************//
//SUBIDA DE ARCHIVOS (SE PUEDEN TENER FUNCIONES DEFINIDAS)
//*********************************************************************************************//

		$archivos = $request->getUploadedFiles();
        $destino = __DIR__ . "/../fotos/";

        $nombreAnterior = $archivos['foto']->getClientFilename();
        $extension = explode(".", $nombreAnterior);

        $extension = array_reverse($extension);

		$archivos['foto']->moveTo($destino . $id_agregado . $titulo . "." . $extension[0]);
		
        $response->getBody()->write("cd agregado!");

      	return $response;
    }
	
	public function ModificarUno(Request $request, Response $response, array $args): Response
	{
		$obj = json_decode(($args["cadenaJson"]));   

	    $micd = new Cd();
	    $micd->id = $obj->id;
	    $micd->titulo = $obj->titulo;
	    $micd->cantante = $obj->cantante;
	    $micd->año = $obj->anio;

		$resultado = $micd->ModificarCd();
		   
	   	$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->resultado = $resultado;

		$newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write(json_encode($objDelaRespuesta));

		return $newResponse->withHeader('Content-Type', 'application/json');		
	}
	
	public function BorrarUno(Request $request, Response $response, array $args): Response 
	{		 
     	$id = $args['id'];
		 
		$cd= new Cd();
		$cd->id = $id;
		 
     	$cantidadDeBorrados = $cd->BorrarCd();

     	$objDeLaRespuesta= new stdclass();
		$objDeLaRespuesta->cantidad = $cantidadDeBorrados;
		
	    if($cantidadDeBorrados>0)
	    {
	    	$objDeLaRespuesta->resultado = "...algo borró!!!";
	    }
	    else
	    {
	    	$objDeLaRespuesta->resultado = "...no borró nada!!!";
		}

		$newResponse = $response->withStatus(200, "OK");
		$newResponse->getBody()->write(json_encode($objDeLaRespuesta));	

		return $newResponse->withHeader('Content-Type', 'application/json');
    }
	
//*********************************************************************************************//
/* FIN - AGREGO FUNCIONES PARA SLIM */
//*********************************************************************************************//

	public static function TraerTodoLosCds()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año from cds");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Cd");		
	}

	public static function TraerUnCd($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año from cds where id = $id");
		$consulta->execute();
		$cdBuscado= $consulta->fetchObject('cd');
		return $cdBuscado;		
	}

	public function InsertarCd()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into cds (titel,interpret,jahr)values(:titulo,:cantante,:anio)");
		$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
		$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public function ModificarCd()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				update cds 
				set titel=:titulo,
				interpret=:cantante,
				jahr=:anio
				WHERE id=:id");
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
		$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
		$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
		return $consulta->execute();
	 }

	public function BorrarCd()
	{
	 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from cds	WHERE id=:id");	
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

}