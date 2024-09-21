<?php
include '../config/conexion.php'; // Conexión a la base de datos

$database = new Database();
$pdo = $database->getConnection();

if (!$pdo) {
    die("Error: No se pudo conectar a la base de datos.");
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos directamente desde $_POST
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificar si los campos están completos
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, ingrese todos los campos']);
        exit;
    }

    // Buscar al administrador por el email utilizando los nombres de columna correctos
    $query = $pdo->prepare('SELECT * FROM administradores WHERE admin_email = :email');
    $query->execute(['email' => $email]);
    $admin = $query->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['admin_password'])) {
        // Contraseña verificada, iniciar sesión
        session_start();
        $_SESSION['admin_email'] = $email;
        $_SESSION['loggedin'] = true;
        $_SESSION['start_time'] = time(); // Guarda el tiempo de inicio de la sesión
        $_SESSION['expire_time'] = 3600;  // Expira después de 30 minutos (1800 segundos)

        // Redirigir a la URL amigable
        echo json_encode(['success' => true, 'message' => 'Login exitoso']);
        header('Location: /Sicosis_Store/admin/dashboard'); // URL amigable
        exit();
    } else {
        // Credenciales incorrectas
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no soportado']);
}
