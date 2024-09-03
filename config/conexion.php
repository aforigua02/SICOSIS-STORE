<?php 
$host = '127.0.0.1';
$dbname = "sicosis_store";
$username = "root";
$password = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "TIENE CONEXION";
}catch (PDOException $e) {
    die("La conexion a fallado : ".$e->getMessage());
}
