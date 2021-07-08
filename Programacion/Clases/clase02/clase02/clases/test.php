<?php

class Test
{
	private $cadena;//privado
	public $entero; //publico
	var $flotante;  //publico
	
	//CONSTRUCTOR
	public function __construct()
	{
		$this->cadena = $this->formatearCadena("valor inicial");
		$this->entero = 1;
		$this->flotante = 0.0;
	}
	
	//METODO PUBLICO DE INSTANCIA
	public function mostrar()
	{
		return $this->cadena . " - " . $this->entero . " - " . $this->flotante;
	}
	
	//METODO PRIVADO DE INSTANCIA
	private function formatearCadena($cadena)
	{
		return ucwords($cadena);
	}
	
	//METODO DE CLASE
	public static function mostrarTest($obj)
	{
		return $obj->mostrar();
	}
}