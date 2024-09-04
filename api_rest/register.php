<?php
// api_rest/register.php
include('../config/conexion.php');

$data = json_decode(file_get_contents("php://input"));

$nombre = $data->nombre;
$email = $data->email;
$password = $data->password;

// Insertamos el nuevo usuario en la base de datos
$query = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Usuario registrado exitosamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error en el registro"]);
}
