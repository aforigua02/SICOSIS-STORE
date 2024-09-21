<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start(); // Inicia la sesión
include '../config/conexion.php'; // Conexión a la base de datos


$database = new Database();
$pdo = $database->getConnection(); 

if($pdo) {
    echo "Conexión a la base de datos exitosa.";
} else {
    echo "Error al conectar a la base de datos.";
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Hasheamos la contraseña
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

// Datos del administrador
$email = 'admin@gmail.com';

try {
    // Inserta el administrador en la base de datos
    $query = $pdo->prepare("INSERT INTO administradores (admin_email, admin_password) VALUES (:email, :password)");
    $query->execute(['email' => $email, 'password' => $hashed_password]);
    
    // Crea la sesión para el administrador
    $_SESSION['admin_email'] = $email;
    $_SESSION['loggedin'] = true;
    
    echo "Usuario administrador creado con éxito.";
    header("Location: dashboard.php"); // Redirige al dashboard o la pantalla que desees
    exit();
} catch (PDOException $e) {
    echo "Error en la inserción: " . $e->getMessage();
}

