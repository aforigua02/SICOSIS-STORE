<?php
session_start(); // Iniciar la sesión para verificar si hay una sesión activa
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Sicosis_Store/public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sicosis Store</title>
</head>
<body>
    <!-------------------------------------BARRA DE NAVEGACIÓN------------------------------------------------>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top contenedor-nav-principal">
        <div class="container-fluid">
            <a class="navbar-brand" href="/Sicosis_Store/homepage" onclick="event.preventDefault(); navigateTo('/homepage');">SICOSIS store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/Sicosis_Store/homepage" onclick="event.preventDefault(); navigateTo('/homepage');">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sicosis_Store/calzado"onclick="event.preventDefault(); navigateTo('/calzado');">CALZADO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sicosis_Store/hombre" onclick="event.preventDefault(); navigateTo('/hombre');">HOMBRE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sicosis_Store/dama" onclick="event.preventDefault(); navigateTo('/dama');">DAMA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sicosis_Store/nino" onclick="event.preventDefault(); navigateTo('/nino');">NIÑO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sicosis_Store/accesorios" onclick="event.preventDefault(); navigateTo('/accesorios');">ACCESORIOS</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline" type="submit"><i class="button-nav bi bi-search"></i></button>
                </form>
                <a href="/Sicosis_Store/carrito" onclick="event.preventDefault(); navigateTo('/carrito');" class="btn btn-outline button-carrito"><i class="button-nav bi bi-cart-fill"></i></a>
                <a href="/Sicosis_Store/favoritos" onclick="event.preventDefault(); navigateTo('/favoritos');" class="btn btn-outline button-favoritos"><i class="button-nav bi bi-heart-fill"></i></a>

                <!-- Verificar si hay una sesión activa -->
                <?php if (isset($_SESSION['user_email'])): ?>
                    <!-- Si el usuario está logueado, mostramos el correo y el botón para cerrar sesión -->

                    <a href="/Sicosis_Store/public/templates/logout.php" class="btn btn-outline button-logout">Cerrar Sesión</a>
                <?php else: ?>
                    <!-- Si no está logueado, mostramos el botón para iniciar sesión -->
                    <button class="btn btn-outline" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><i class="button-nav bi bi-person-fill"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Modal de inicio de sesión -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Iniciar Sesión</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container-form">
                    <!-- Aquí cambiamos el action del formulario a login.php -->
                    <form id="loginForm" method="POST">
                        <div class="mb-3 row">
                            <label for="loginEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10 contener-input">
                                <input type="email" class="form-control input-registro" id="loginEmail" name="loginEmail">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="loginpassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10 contener-input">
                                <input type="password" class="form-control input-registro" id="loginpassword" name="loginpassword">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" id="loginButton">Iniciar Sesion</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Registrarme</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered bd-example-modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Registrarme</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Iniciar el formulario -->
                        <form id="registerForm" method="POST" action="/Sicosis_Store/register.php">
                            <div class="mb-3 row ">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10 contener-input">
                                    <input type="text" class="form-control" name="userName" id="userName">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                                <div class="col-sm-10 contener-input">
                                    <input type="text" class="form-control" name="userApellido" id="userApellido">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10 contener-input">
                                    <input type="email" class="form-control" name="userEmail" id="userEmail">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10 contener-input">
                                    <input type="password" class="form-control" name="userPassword" id="userPassword">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" id="registerButton">Registrarme</button>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Iniciar Sesión</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> 

    <!-- Contenido principal -->
    <div id="content-principal" class="contenedor-principal-index"></div>

    <!-- Footer -->
    <footer class="py-5 container-footer">
        <div class="container">
        <div class="row">
                <div class="col-md-4 ">
                    <img src="../Sicosis_Store/public/img/Logo-sicosis.png" alt="Logo de sicosis" class="display-6 fw-bold Logo-sicosis">
                    <p class="mt-3">We creates possibilities<br>for the connected world.</p>
                </div>
                <div class="col-md-2">
                    <h2 class="h5 fw-semibold">Explore</h2>
                    <ul class="list-unstyled mt-3">
                        <li>Home</li>
                        <li>About</li>
                        <li>Capabilities</li>
                        <li>Careers</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h2 class="h5 fw-semibold">SEDES</h2>
                    <h6 class="h6 fw-bold mt-3"><a href="https://maps.app.goo.gl/jJ1x1RrPMxoZnxbE8" class="footer-text" target="_blank">Sicosis Quirigua</a></h6>
                    <p class="mt-3">Tv. 94a #80d-73, Bogotá</p>
                    <h6 class="h6 fw-bold mt-3"><a href="https://maps.app.goo.gl/BTWuVozfuUoPBaLq6" class="footer-text" target="_blank">Sicosis Engativa</a></h6>
                    <p class="mt-3">Cl 64 #116c 04 Piso 2, Bogotá</p>
                </div>
                <div class="col-md-2">
                    <h2 class="h5 fw-semibold">SIGUENOS</h2>
                    <ul class="list-unstyled mt-3">
                        <li>Instagram</li>
                        <li>Twitter</li>
                        <li>LinkedIn</li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h2 class="h5 fw-semibold">Legal</h2>
                    <ul class="list-unstyled mt-3">
                        <li>Terminos</li>
                        <li>condiciones</li>
                    </ul>
                </div>
            </div>
            <div class="mt-5 text-center text-secondary">
                © 2020 Envoy. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="/Sicosis_Store/routes/routes.js"></script>
    <script src="public\js\main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
