<?php
include '../config/conexion.php'; // Conexión a la base de datos

// Hasheamos la contraseña


echo "Ejecutando archivo PHP correctamente";



if($pdo) {
    echo "Conexión a la base de datos exitosa.";
} else {
    echo "Error al conectar a la base de datos.";
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

// Inserta el administrador en la base de datos
$email = 'admin@gmail.com'; // Email del administrador
$query = $pdo->prepare("INSERT INTO administradores (email, password) VALUES (:email, :password)");
$query->execute(['email' => $email, 'password' => $hashed_password]);

echo "Usuario administrador creado con éxito.";

try {
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $email = 'admin@gmail.com';
    $query = $pdo->prepare("INSERT INTO administradores (email, password) VALUES (:email, :password)");
    $query->execute(['email' => $email, 'password' => $hashed_password]);
    echo "Usuario administrador creado con éxito.";
} catch (PDOException $e) {
    echo "Error en la inserción: " . $e->getMessage();
}

