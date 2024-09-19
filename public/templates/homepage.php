<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Sicosis_Store/public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sicosis</title>
</head>
<body>
<!-------------------------------------BARRA DE NAVEGACIÓN------------------------------------------------>

    <!-- Modal -->
    <section class="carrusel-main">
        <div id="carouselExampleSlidesOnly contenedor-texto-carrusel" class="carousel slide mt-2" data-bs-ride="carousel">
            <div class="carousel-inner contenedor-texto">
                <div class="carousel-item active carrusel-texto">
                    <p class="texto-carrusel">Paga con Addi</p>
                </div>
                <div class="carousel-item carrusel-texto">
                    <p class="texto-carrusel">Paga con Siste-Credito</p>
                </div>
                <div class="carousel-item carrusel-texto">
                    <p class="texto-carrusel">Paga con tarjeta</p>
                </div>
            </div>
        </div>
    </section>
<!--------------------------------------------------------------------------------------------------------->
<!----------------------------------------MAIN PRINCIPAL---------------------------------------------------->
    
    <div class="layout-container">
        <aside class="carrusel-nav">
            <div id="carouselExampleSlidesOnly" class="carousel slide contendor-imagen-izq" data-bs-ride="carousel">
                <div class="carousel-inner contenedor-carrusel">
                    <div class="carousel-item active">
                        <img src="/Sicosis_Store/public/img/chica-modelo.jpg" class="d-block w-100 imagen-carrusel-izq" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/Sicosis_Store/public/img/pantalon-algodojpg.jpg" class="d-block w-100 imagen-carrusel-izq" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/Sicosis_Store/public/img/conjunto-deportivo-chica.jpg" class="d-block w-100 imagen-carrusel-izq" alt="...">
                    </div>
                </div>
            </div>
        </aside>
        <section class="cards-main">
            <div class="container-fluid container-cards">
                <div class="row contenedor-fila-cards">
                    <!-- Primera tarjeta -->
                    <div class="col-lg-3 col-md-6 col-sm-12 my-1 d-flex align-items-stretch contenedor-card">
                        <div class="card card-small">
                            <a data-bs-toggle="collapse" href="#imagen-1" role="button" aria-expanded="false" aria-controls="imagen-1">
                                <img src="/Sicosis_Store/public/img/eminem.jpg" class="card-img-top img-fluid" alt="...">
                            </a>
                            <div class="collapse" id="imagen-1">
                                <div class="card-body">
                                    <h6 class="card-title">CAMISETA OVERZIDE</h6>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">$75.000 COP</li>
                                    <li class="list-group-item">Todas las tallas</li>
                                    <button class="button-detalles"><a href="">Más Detalles</a></button>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="card-link"><i class="bi bi-heart"></i></a>
                                    <a href="#" class="card-link">Agregar al carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Segunda tarjeta -->
                    <div class="col-lg-3 col-md-6 col-sm-12 my-1 d-flex align-items-stretch contenedor-card">
                        <div class="card card-small">
                            <a data-bs-toggle="collapse" data-bs-target="#imagen-2" role="button" aria-expanded="false" aria-controls="imagen-2">
                                <img src="/Sicosis_Store/public/img/eminem.jpg" class="card-img-top img-fluid" alt="...">
                            </a>
                            <div class="collapse" id="imagen-2">
                                <div class="card-body">
                                    <h6 class="card-title">CAMISETA OVERZIDE</h6>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">$75.000 COP</li>
                                    <li class="list-group-item">Todas las tallas</li>
                                    <button class="button-detalles"><a href="">Más Detalles</a></button>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="card-link"><i class="bi bi-heart"></i></a>
                                    <a href="#" class="card-link">Agregar al carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </section>
    </div>
    

    <script src="../public/js/main.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<!-------------------------------------MATEO SE CONECTO------------------------------------------------>
</html>