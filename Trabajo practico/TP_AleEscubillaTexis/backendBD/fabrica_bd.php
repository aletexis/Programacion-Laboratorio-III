<?php
    require_once("empleado_bd.php");
    require_once("interfaces_bd.php");
    require_once("accesoDatos.php");

    class Fabrica implements IBaseDeDatos
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
            if(is_object($empleado) && get_class($empleado) == "Empleado")
            {
                if($this->_cantidadMaxima > count($this->_empleados))
                {
                    array_push($this->_empleados, $empleado);
                    $this->EliminarEmpleadosRepetidos();
                    return true;
                }
            }
            return false;
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
            foreach($this->_empleados as $key => $value)
            {
                if($value->GetLegajo() === $empleado->GetLegajo())
                {
                    unset($this->_empleados[$key]);
                    unlink($value->GetPathFoto());
                    return true;
                }
            } 
            return false;
        }

        private function EliminarEmpleadosRepetidos()
        {
            $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
        }
        
        public function ToString()
        {
            $resultado = "Cantidad maxima de empleados: $this->_cantidadMaxima <br> $this->_razonSocial <br>";

            foreach($this->_empleados as $item)
            {
                $resultado .= $item->__toString();
            }

            $resultado .= "Sueldo total a pagar: " . $this->CalcularSueldos() . "<br>";

            return $resultado;
        }

        public function TraerDeBaseDeDatos()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "SELECT * FROM empleados";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->execute();
            
            $query->setFetchMode(PDO::FETCH_OBJ);

            foreach($query as $item)
            {
                $empleado = new Empleado($item->nombre, $item->apellido, $item->dni, $item->sexo, $item->legajo, $item->sueldo, $item->turno);
                $empleado->SetPathFoto($item->path_foto);
                $this->AgregarEmpleado($empleado);
            }
        }

        public function AltaBaseDeDatos($empleado)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "INSERT INTO empleados (dni, nombre, apellido, sexo, legajo, sueldo, turno, path_foto) VALUES (:dni, :nombre, :apellido, :sexo, :legajo, :sueldo, :turno, :path_foto)";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->bindValue(':dni', $empleado->GetDni(), PDO::PARAM_INT);
            $query->bindValue(':nombre', $empleado->GetNombre(), PDO::PARAM_STR);
            $query->bindValue(':apellido', $empleado->GetApellido(), PDO::PARAM_STR);
            $query->bindValue(':sexo', $empleado->GetSexo(), PDO::PARAM_STR);
            $query->bindValue(':legajo', $empleado->GetLegajo(), PDO::PARAM_INT);
            $query->bindValue(':sueldo', $empleado->GetSueldo(), PDO::PARAM_INT);
            $query->bindValue(':turno', $empleado->GetTurno(), PDO::PARAM_STR);
            $query->bindValue(':path_foto', $empleado->GetPathFoto(), PDO::PARAM_STR);

            try
            {
                $query->execute();
                return true;
            }
            catch(PDOException $e)
            {
                echo "Error! {$e->getMessage()}";
            }
        }

        public function EliminarDeBaseDeDatos($empleado)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "DELETE FROM empleados WHERE legajo = :legajo";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->bindValue(':legajo', $empleado->GetLegajo(), PDO::PARAM_INT);
            
            try
            {
                $query->execute();
                $this->EliminarEmpleado($empleado);
                return true;
            }
            catch(PDOException $e)
            {
                echo "Error! {$e->getMessage()}";
            }
        }

        public function ModificarDeBaseDeDatos($empleado)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "UPDATE empleados SET  nombre = :nombre, apellido = :apellido, sexo = :sexo, sueldo = :sueldo, turno = :turno, path_foto = :path_foto WHERE dni = :dni";

            $query = $accesoDatos->RetornarConsulta($sql);


            $query->bindValue(':dni', $empleado->GetDni(),PDO::PARAM_INT);
            $query->bindValue(':nombre', $empleado->GetNombre(),PDO::PARAM_STR);
            $query->bindValue(':apellido', $empleado->GetApellido(),PDO::PARAM_STR);
            $query->bindValue(':sexo', $empleado->GetSexo(),PDO::PARAM_STR);
            $query->bindValue(':sueldo', $empleado->GetSueldo(),PDO::PARAM_INT);
            $query->bindValue(':turno', $empleado->GetTurno(),PDO::PARAM_STR);
            $query->bindValue(':path_foto', $empleado->GetPathFoto(),PDO::PARAM_STR);

            try
            {
                $query->execute();
                return true;
            }
            catch(PDOException $e)
            {
                echo "Error! {$e->getMessage()}";
            }
        }
    }
?>