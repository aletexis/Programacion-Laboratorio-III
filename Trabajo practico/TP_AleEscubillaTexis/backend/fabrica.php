<?php
    require_once("empleado.php");
    require_once("interfaces.php");

    class Fabrica implements IArchivo
    {
        private $_cantidadMaxima;
        private $_empleados;
        private $_razonSocial;

        public function __construct($razonSocial, $cantidad = 5)
        {
            $this->_cantidadMaxima = $cantidad;
            $this->_empleados = array();
            $this->_razonSocial = $razonSocial;
        }

        public function GetEmpleados()
        {
            return $this->_empleados;
        }

        public function AgregarEmpleado($empleado)
        {
            $agregado = false;
            
            if(is_object($empleado) && get_class($empleado) == "Empleado")
            {
                if($this->_cantidadMaxima > count($this->_empleados))
                {
                    array_push($this->_empleados, $empleado);
                    $this->EliminarEmpleadosRepetidos();
                    $agregado = true;
                }
            }
            
            return $agregado;
        }

        public function CalcularSueldos()
        {
            $total = 0;

            foreach($this->_empleados as $item)
            {
                $total += $item->GetSueldo(); 
            }

            return $total;
        }

        public function EliminarEmpleado($empleado)
        {
            $eliminado = false;
            
            foreach($this->_empleados as $key => $value)
            {
                if($value->GetLegajo() === $empleado->GetLegajo())
                {
                    unset($this->_empleados[$key]);
                    $eliminado = true;
                }
            } 
            
            return $eliminado;
        }

        private function EliminarEmpleadosRepetidos()
        {
            $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
        }
        
        public function ToString()
        {
            $cadena = "Cantidad maxima de empleados: $this->_cantidadMaxima <br> $this->_razonSocial <br>";

            foreach($this->_empleados as $item)
            {
                $cadena .= $item->__toString();
            }

            $cadena .= "Sueldo total a pagar: " . $this->CalcularSueldos() . "<br>";

            return $cadena;
        }

        public function TraerDeArchivo($nombreArchivo)
        {        
            if(file_exists($nombreArchivo))
            {
                $archivo = fopen($nombreArchivo,"r");

                if(filesize($nombreArchivo))
                {
                    do
                    {
                        $cadena = fgets($archivo);
                        $cadena = is_string($cadena) ? trim($cadena) : false;
                        
                        if($cadena != false)
                        {
                            $array = explode(" - ", $cadena);
                            if($array[0] != "" && $array[0] != "\r\n")
                            {   
                                $empleado = new Empleado($array[1],$array[2],$array[0],$array[3],$array[4],$array[5],$array[6]);
                                $empleado->SetPathFoto($array[7]);
                                $this->AgregarEmpleado($empleado);
                            }
                        }
                        
                    }while(!feof($archivo));
                }
                fclose($archivo);
            }
        }

        public function GuardarArchivo($nombreArchivo)
        {
            $archivo = fopen($nombreArchivo,"w");
            $guardado = false;
            
            if(file_exists($nombreArchivo))
            {
                foreach($this->_empleados as $item)
                {
                    $cadena = $item->__toString() . PHP_EOL;
                    fwrite($archivo,$cadena);
                }
                
                fclose($archivo);
                $guardado = true;
            }
            
            return $guardado;
        }
    }
?>