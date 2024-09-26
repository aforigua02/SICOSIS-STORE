<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión si está activa
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio o página que limpie el localStorage
header("Location: /Sicosis_Store/public/templates/clear_storage.php");
exit();
