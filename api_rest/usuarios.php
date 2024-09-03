<?php 
require '../config/conexion.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $stmt = $pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();

        // Obtener los resultados
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados como JSON
        echo json_encode($usuarios);
    }catch(PDOException $e){
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los usuarios']);
    }
}   else{
    http_response_code(405);
    echo json_encode(['error' => 'Metodo no permitido']);
}