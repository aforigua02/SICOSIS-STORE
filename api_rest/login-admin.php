<?php
include '../config/conexion.php'; // Conexión a la base de datos

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    // Verificar credenciales de administrador
    $query = $pdo->prepare('SELECT * FROM administradores WHERE email = :email AND password = :password');
    $query->execute(['email' => $email, 'password' => $password]);
    $admin = $query->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo json_encode(['success' => true, 'message' => 'Login exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no soportado']);
}
