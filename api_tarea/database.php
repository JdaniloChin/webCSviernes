<?php
    /**
     * Configuracion a la base de datos
     * Esta clase se conecta a mysql
     */

    class Database {
        private $host;
        private $database_name;
        private $username;
        private $password;
        private $connection;

        public function __construct(){
            $this->host = "localhost";
            $this->database_name = "control_tareas";
            $this->username = "root";
            $this->password = "Jdcc7206.";
        }

        public function getConnection(){
            $this->connection = null;

            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database_name . ";charset=utf8mb4";
                
                // Opciones específicas para MySQL 8.0
                $opciones = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                ];
                
                $this->connection = new PDO($dsn, $this->username, $this->password, $opciones);
            } catch(PDOException $exception) {
                error_log("Error de conexion: " . $exception->getMessage());
                throw new Exception("Error al conectar con la base de datos");
            }

            return $this->connection;
        }
    }
?>