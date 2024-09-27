<?php
session_start();
include_once '../../config/conexion.php';
include_once '../../controllers/ProductController.php';

// Crear instancia del controlador
$database = new Database();
$pdo = $database->getConnection();
$productController = new ProductController($pdo);

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $producto = $productController->getProductById($id);
    echo json_encode($producto);
    exit; // Terminar la ejecución para no cargar el HTML completo en la respuesta
}

// Obtener productos (puedes filtrar por categoría si lo necesitas)
$productos = $productController->showAllProducts();
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

    <!-- Modal -->
    <section class="carrusel-main">
        <div id="carouselExampleSlidesOnly" class="carousel slide mt-2" data-bs-ride="carousel">
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
                    <!-- Generar tarjetas dinámicamente desde la base de datos -->
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <div class="col-lg-3 col-md-6 col-sm-12 my-1 d-flex align-items-stretch contenedor-card" data-id="<?php echo $producto['id_producto']; ?>">
                                <div class="card card-small">
                                    <!-- Imagen del producto -->
                                    <img src="<?php echo $producto['url_imagen']; ?>" class="card-img-top img-fluid" alt="Imagen del producto">
                                    
                                    <!-- Detalles del producto -->
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo $producto['nombre_producto']; ?></h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><?php echo "$" . number_format($producto['precio'], 0, ',', '.') . " COP"; ?></li>
                                        </ul>
                                        <button class="button-detalles" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#productModal"
                                            data-id="<?php echo $producto['id_producto']; ?>">
                                            Más Detalles
                                        </button>

                                    </div>
                                    <div class="card-body contenedorcarritofavorito">
                                        <a href="#" class="card-link heart-icon" id="heart-<?php echo $producto['id_producto']; ?>" onclick="toggleHeart(event, '<?php echo $producto['id_producto']; ?>')">
                                            <i class="bi bi-heart" id="heart-icon-<?php echo $producto['id_producto']; ?>"></i> <!-- Corazón vacío -->
                                            <i class="bi bi-heart-fill" id="heart-fill-icon-<?php echo $producto['id_producto']; ?>" style="display: none;"></i> <!-- Corazón lleno -->
                                        </a>                                            
                                        <a href="#" class="card-link">A</a>
                                    </div>
                                    <!-- Input oculto para almacenar el ID del producto -->
                                    <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay productos disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>  
        </section>
        <script>
                                            console.log("Nombre:", nombre, "Precio:", precio, "Talla:", talla, "Color:", color, "URL:", url);

                                        </script>

        <!-- Modal template -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Detalles del producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modalProductImage" class="img-fluid mb-3" alt="Imagen del producto">
                        <h5 id="modalProductName"></h5>
                        <p id="modalProductPrice"></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" id="modalProductTalla"></li>
                            <li class="list-group-item" id="modalProductColor"></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="../public/js/main.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<!-------------------------------------MATEO SE CONECTO------------------------------------------------>
</html>
