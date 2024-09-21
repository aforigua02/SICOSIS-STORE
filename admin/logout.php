<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir al login de administrador
header('Location: /Sicosis_Store/admin/login-admin');
exit();
