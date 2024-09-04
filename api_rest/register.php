<?php
include '../config/conexion.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"));

$nombre = $data->nombre ?? '';
$email = $data->email ?? '';
$password = $data->password ?? '';

// Verificar que los campos no estén vacíos
if (empty($nombre) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
    exit;
}

// Insertamos el nuevo usuario en la base de datos
$query = $pdo->prepare('INSERT INTO usuarios (nombre_usuario, email, password) VALUES (:nombre_usuario, :email, :password)');
$result = $query->execute(['nombre_usuario' => $nombre, 'email' => $email, 'password' => $password]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error en el registro']);
}
