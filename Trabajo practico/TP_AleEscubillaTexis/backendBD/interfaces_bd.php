<?php
    interface IBaseDeDatos
    {
        public function TraerDeBaseDeDatos();
        public function AltaBaseDeDatos($empleado);
        public function EliminarDeBaseDeDatos($empleado);
        public function ModificarDeBaseDeDatos($empleado);
    }
?>