<?php
include 'config/conexion.php'; // Tu conexión a la base de datos

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    // Validar los datos ingresados
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
        exit;
    }

    // Aquí podrías consultar la base de datos para verificar los datos del usuario
    $query = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email AND password = :password');
    $query->execute(['email' => $email, 'password' => $password]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no soportado']);
}
