<?php

//CLASE QUE DERIVA DE LA CLASE ABSTRACTA
class Clase extends ClaseAbstracta
{
	//ATRIBUTOS
	public $otroAtributo;
	
	//CONSTRUCTOR
	public function __construct($valor, $otroValor)
	{
		parent::__construct($valor);
		$this->otroAtributo = $otroValor;
	}
	
	//IMPLEMENTO METODO ABSTRACTO
	public function MetodoAbstracto(){
		return "<br/>M&eacute;todo Abstracto";
	}
}