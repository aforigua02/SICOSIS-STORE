<?php
class Database {
    private $host = '127.0.0.1';
    private $dbname = 'sicosis_store'; // Asegúrate de usar el nombre correcto aquí
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            // Cambiar $this->db_name a $this->dbname para que coincida con el nombre de la propiedad
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

