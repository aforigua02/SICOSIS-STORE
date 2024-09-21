<?php
include '../controllers/AdminController.php'; // Incluye el controlador

// Verificar sesión a través del controlador
AdminController::verificarSesion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard - Administrador</title>
</head>
<body>

<!-- NAVBAR ESPECÍFICO PARA ADMINISTRADOR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-admin">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/Sicosis_Store/admin/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Sicosis_Store/admin/productos-admin">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Sicosis_Store/admin/usuarios">Usuarios</a>
                </li>
            </ul>
            <div class="d-flex">
                <!-- Mostrar correo del admin logueado -->
                <span class="navbar-text me-3">
                    <?php echo $_SESSION['admin_email']; ?>
                </span>
                <a href="/Sicosis_Store/admin/logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>
