<?php
class AdminController {
    public static function verificarSesion() {
        session_start();

        // Verifica si el usuario está logueado
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /Sicosis_Store/admin/login-admin'); // Redirigir al login si no hay sesión
            exit();
        }

        // Verifica el tiempo de inactividad
        if (isset($_SESSION['start_time'])) {
            $inactive_time = time() - $_SESSION['start_time']; // Calcula el tiempo inactivo

            if ($inactive_time > $_SESSION['expire_time']) { // Si ha pasado el tiempo de inactividad
                session_unset();  // Destruye las variables de sesión
                session_destroy(); // Destruye la sesión
                header('Location: /Sicosis_Store/admin/login-admin'); // Redirigir al login
                exit();
            } else {
                $_SESSION['start_time'] = time(); // Resetea el tiempo de inicio si el usuario está activo
            }
        }

        // Regenera el ID de la sesión para mayor seguridad
        session_regenerate_id(true);
    }
}
?>
