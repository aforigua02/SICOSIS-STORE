<?php
session_start();
header('Content-Type: application/json'); // Asegúrate de que el encabezado sea JSON

include '../config/conexion.php'; // Asegúrate de que esta conexión funcione correctamente

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$pdo = $database->getConnection(); // Asegúrate de obtener la conexión aquí

// Verificar si la conexión falló
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos']);
    exit;
}

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos están en $_POST (cuando se usa FormData en fetch, debería estar aquí)
    if (!isset($_POST['loginEmail']) || !isset($_POST['loginpassword'])) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos del formulario']);
        exit;
    }

    // Limpiar y validar los datos
    $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['loginpassword'], ENT_QUOTES, 'UTF-8');

    // Consulta para obtener el usuario
    $query = $pdo->prepare('SELECT * FROM usuarios WHERE usuario_email = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar credenciales
    if ($user && password_verify($password, $user['usuario_password'])) {
        // Guardar datos de sesión
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_email'] = $user['usuario_email'];

        // Devolver respuesta JSON
        echo json_encode(['success' => true, 'message' => 'Login exitoso']);
    } else {
        // Respuesta de error si las credenciales son incorrectas
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    // Manejar el caso en el que el método no sea POST
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
exit;
