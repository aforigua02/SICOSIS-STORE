<?php
session_start();
include_once '../../config/conexion.php';
include_once '../../controllers/ProductController.php';

// Crear instancia del controlador
$database = new Database();
$pdo = $database->getConnection();
$productController = new ProductController($pdo);

// Obtener productos de la categoría "Hombre"
$productosHombre = $productController->getProductsByCategoryAndType('Hombre');

// Agrupar los productos por tipo de producto
$productosAgrupados = [];
foreach ($productosHombre as $producto) {
    $tipoProducto = $producto['nombre_tipo_producto'];
    if (!isset($productosAgrupados[$tipoProducto])) {
        $productosAgrupados[$tipoProducto] = [];
    }
    $productosAgrupados[$tipoProducto][] = $producto;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Sicosis_Store/public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sicosis Store - Hombre</title>
</head>
<body>
    <section class="title-section">
        <section class="cards-main contenedorfilacards">
            <div class="container-fluid container-cards-categoria">
                <div class="row contenedorfilas">
                    <!-- Mostrar cada grupo de productos por tipo -->
                    <?php foreach ($productosAgrupados as $tipoProducto => $productos): ?>
                        <div class="col-12 grupocards">
                            <h3><?php echo $tipoProducto; ?></h3> <!-- Título del tipo de producto -->
                            <div class="row contenedorcard">
                                <?php foreach ($productos as $producto): ?>
                                    <div class="col-lg-3 col-md-6 col-sm-12 my-1 d-flex align-items-stretch contenedor-card" data-id="<?php echo $producto['id_producto']; ?>">
                                        <div class="card card-small card-individual">
                                            <!-- Imagen del producto -->
                                            <img  src="<?php echo $producto['url_imagen']; ?>" class="card-img-top img-fluid img-card" alt="Imagen del producto">
                                            <!-- Detalles del producto -->
                                            <div class="card-body cuerpocard">
                                                <h6 class="precio-categ card-title titulo-card-indiv"><?php echo $producto['nombre_producto']; ?></h6>
                                                <ul class="list-group list-group-flush">
                                                    <li class="precio-categ list-group-item"><?php echo "$" . number_format($producto['precio'], 0, ',', '.') . " COP"; ?></li>
                                                </ul>
                                                <button class="button-detalles">
                                                    <a href="detalle-producto.php?id=<?php echo $producto['id_producto']; ?>">Más Detalles</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>  
        </section>
    </section>

    <!-- Productos de la categoría "Hombre" agrupados por tipo -->

    <script src="../public/js/main.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
