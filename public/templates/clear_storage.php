<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limpiando Sesión</title>
</head>
<body>
    <script>
        // Limpiar el localStorage y sessionStorage al cerrar sesión
        localStorage.removeItem('favorites');
        sessionStorage.removeItem('user_id');

        // Redirigir al usuario a la página de inicio
        window.location.href = '/Sicosis_Store/homepage';
    </script>
</body>
</html>
