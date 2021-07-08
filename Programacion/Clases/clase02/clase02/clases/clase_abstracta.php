<?php
//DECLARO CLASE ABSTRACTA
abstract class ClaseAbstracta
{
	//ATRIBUTOS
	protected $atributo;
	
	//CONSTRUCTOR
	public function __construct($valor)
	{
		$this->atributo = $valor;
	}
	
	//METODO ABSTRACTO
	public abstract function metodoAbstracto();
	
	//METODO NO ABSTRACTO
	public function getAtributo()
	{
		return $this->atributo;
	}

}