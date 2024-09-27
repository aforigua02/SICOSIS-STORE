<?php
include '../config/conexion.php'; // Asegúrate de tener la conexión

header('Content-Type: application/json');

// Obtener la conexión
$conexión = new Database();
$db = $conexión->getConnection();

// Decodificar el JSON enviado por el fetch 
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No se enviaron datos."
    ]);
    exit;
}

// Extraer los valores del usuario
$userName = $data['userName'];
$userApellido = $data['userApellido'];
$userEmail = $data['userEmail'];
$userPassword = $data['userPassword'];

// Hashear la contraseña
$hashed_password = password_hash($userPassword, PASSWORD_DEFAULT);

// Llamar al procedimiento almacenado
$sql = "CALL InsertUser(:usuario_nombre, :usuario_apellido, :usuario_email, :usuario_password)";
$stmt = $db->prepare($sql);

try {
    // Vincular los parámetros
    $stmt->bindParam(':usuario_nombre', $userName);
    $stmt->bindParam(':usuario_apellido', $userApellido);
    $stmt->bindParam(':usuario_email', $userEmail);
    $stmt->bindParam(':usuario_password', $hashed_password);

    // Ejecutar la consulta
    $stmt->execute();

    // Enviar respuesta en JSON
    echo json_encode([
        "success" => true,
        "message" => "Usuario registrado correctamente."
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error al registrar usuario: " . $e->getMessage()
    ]);
}
