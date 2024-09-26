<?php
session_start();
header('Content-Type: application/json'); // Para devolver respuestas JSON

include '../config/conexion.php'; // Conexión a la base de datos

$database = new Database();
$pdo = $database->getConnection();

// Verificar si la conexión falló
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos']);
    exit;
}

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos
    $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['loginpassword'], ENT_QUOTES, 'UTF-8');

    // Consultar el usuario por correo
    $query = $pdo->prepare('SELECT * FROM usuarios WHERE usuario_email = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar credenciales
    if ($user && password_verify($password, $user['usuario_password'])) {
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_email'] = $user['usuario_email'];

        // Devolver el ID del usuario para guardarlo en sessionStorage
        echo json_encode(['success' => true, 'message' => 'Login exitoso', 'userId' => $_SESSION['user_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
exit;
