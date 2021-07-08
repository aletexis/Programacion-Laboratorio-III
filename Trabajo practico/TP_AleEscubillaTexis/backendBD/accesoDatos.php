<?php
    class AccesoDatos
    {
        private static $accesoDatos;
        private $objetoPDO;

        public function __construct()
        {
            try
            {
                $host = "localhost";
                $dbname = "273910";
                $user = "273910";
                $pass = "28042000";
                $dsn  = "mysql:host=$host;dbname=$dbname"; 

                $this->objetoPDO = new PDO($dsn, $user, $pass);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function RetornarConsulta($sql)
        {
            return $this->objetoPDO->prepare($sql);
        }

        public static function ObjetoAccesoDatos()
        {
            if(!isset(self::$accesoDatos))
            {
                return self::$accesoDatos = new AccesoDatos();
            }

            return self::$accesoDatos;
        }

        public function __clone()
        {
            trigger_error('La clonacion de este objeto no esta permitida.',E_USER_ERROR);
        }
    }
?>