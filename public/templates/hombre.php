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
                <!-- Recorrer cada tipo de producto -->
                <?php foreach ($productosAgrupados as $tipoProducto => $productos): ?>
                    <div class="col-12 grupocards">
                        <h3><?php echo $tipoProducto; ?></h3> <!-- Título del tipo de producto -->
                        <div class="contenedorcard"> <!-- El contenedor principal para el scroll -->
                            <!-- Recorrer productos dentro de cada tipo -->
                            <?php foreach ($productos as $producto): ?>
                                <div class="card card-small card-individual">
                                    <img src="<?php echo $producto['url_imagen']; ?>" class="img-card" alt="Imagen del producto">
                                    <div class="cuerpocard">
                                        <h6><?php echo $producto['nombre_producto']; ?></h6>
                                        <p><?php echo "$" . number_format($producto['precio'], 0, ',', '.') . " COP"; ?></p>
                                        <button class="button-detalles">
                                            <a href="detalle-producto.php?id=<?php echo $producto['id_producto']; ?>">Más Detalles</a>
                                        </button>
                                        <div>
                                            <a href="#" class="heart-icon">Agregar a Favoritos</a>
                                            <a href="#" class="cart-icon">Agregar al carrito</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>

    <!-- Productos de la categoría "Hombre" agrupados por tipo -->

    <script src="../public/js/main.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
