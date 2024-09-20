<?php
include '../config/conexion.php'; // Conexión a la base de datos

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    // Verificar si los campos están completos
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, ingrese todos los campos']);
        exit;
    }

    // Buscar al administrador por el email
    $query = $pdo->prepare('SELECT * FROM administradores WHERE email = :email');
    $query->execute(['email' => $email]);
    $admin = $query->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        // Contraseña verificada
        echo json_encode(['success' => true, 'message' => 'Login exitoso']);
    } else {
        // Credenciales incorrectas
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no soportado']);
}