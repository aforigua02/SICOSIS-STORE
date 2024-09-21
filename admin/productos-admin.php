<?php
include '../config/conexion.php';
include '../controllers/ProductController.php';

// Crear instancia del controlador
$database = new Database();
$pdo = $database->getConnection();
$productController = new ProductController($pdo);

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        // Pasar cada campo del formulario individualmente a createProduct
        $productController->createProduct(
            $_POST['nombre'], 
            $_POST['descripcion'], 
            $_POST['precio'], 
            $_POST['cantidad'], 
            $_POST['url_imagen'], 
            $_POST['id_categoria'],
            $_POST['talla'],  // Nuevo campo
            $_POST['color']   // Nuevo campo
        );
    } elseif (isset($_POST['delete'])) {
        // Eliminar producto
        $productController->deleteProduct($_POST['id']);
    } elseif (isset($_POST['update'])) {
        // Editar producto
        $productController->editProduct(
            $_POST['id'], 
            $_POST['nombre'], 
            $_POST['descripcion'], 
            $_POST['precio'], 
            $_POST['cantidad'], 
            $_POST['url_imagen'], 
            $_POST['id_categoria'],
            $_POST['talla'],  // Nuevo campo
            $_POST['color']   // Nuevo campo
        );
    }
    // Después de procesar, redireccionar para evitar reenvío del formulario
    header("Location: productos-admin.php");
    exit;
}

// Obtener todos los productos
$productos = $productController->showAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CRUD Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/Sicosis_Store/public/styles.css"> <!-- Tu archivo de estilos -->
</head>
<body>
    
    <div class="container-fluid mt-1 producto-container">
        <h1 class="text-center titulo-dashboard">Administración Sicosis</h1>
        <div class="row contenedor-formulario">
            <div class="col-md-9">
                <div class="card p-4 mt-4">
                    <h2 class="tituloCrud">Agregar / Actualizar Producto</h2>
                    <form class="mt-4" action="productos-admin.php" method="POST">
                        <input type="hidden" name="id" value="">

                        <!-- Primera fila: Nombre del producto, Precio y Talla -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label ">Nombre del producto</label>
                                <input type="text" name="nombre" class="form-control input-agregar" placeholder="Nombre del producto" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="precio" class="form-label ">Precio</label>
                                <input type="number" name="precio" class="form-control input-agregar" placeholder="Precio" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="talla" class="form-label ">Talla</label>
                                <input type="text" name="talla" class="form-control input-agregar" placeholder="Talla" required>
                            </div>
                        </div>

                        <!-- Segunda fila: Descripción, Cantidad disponible y Color -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="descripcion" class="form-label ">Descripción</label>
                                <textarea name="descripcion" class="form-control input-agregar" placeholder="Descripción" required></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cantidad" class="form-label ">Cantidad disponible</label>
                                <input type="number" name="cantidad" class="form-control input-agregar" placeholder="Cantidad disponible" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="color" class="form-label ">Color</label>
                                <input type="text" name="color" class="form-control input-agregar" placeholder="Color" required>
                            </div>
                        </div>

                        <!-- Tercera fila: URL de la imagen y Categoría -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="url_imagen" class="form-label ">URL de la imagen</label>
                                <input type="text" name="url_imagen" class="form-control input-agregar" placeholder="URL de la imagen" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_categoria" class="form-label ">Categoría</label>
                                <select name="id_categoria" class="form-select input-agregar" required>
                                    <option value="">Seleccionar Categoría</option>
                                    <?php
                                    // Obtener todas las categorías
                                    $stmt = $pdo->prepare("SELECT id_categoria, nombre_categoria FROM categorias");
                                    $stmt->execute();
                                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($categorias as $categoria) {
                                        echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre_categoria']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="btn-group-producto mt-3">
                            <button type="submit" name="create" class="btn btn-primary buttonCrearproducto">Crear Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="contenedorTablaproductos">
        <h2 class="mt-5 listaProductos">Lista de Productos</h2>
        <?php if (!empty($productos)): ?>
        <table class="table table-bordered table-producto mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Talla</th> <!-- Nueva columna -->
                    <th>Color</th> <!-- Nueva columna -->
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['id_producto']; ?></td>
                    <td><?php echo $producto['nombre_producto']; ?></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['cantidad_disponible']; ?></td>
                    <td><?php echo $producto['talla']; ?></td> <!-- Mostrar Talla -->
                    <td><?php echo $producto['color']; ?></td> <!-- Mostrar Color -->
                    <td class="contenedorImagenProducto"><img src="<?php echo $producto['url_imagen']; ?>" class="imagenProducto" alt="Imagen del producto" style="width:100px;"></td>
                    <td><?php echo $producto['nombre_categoria']; ?></td>
                    <td>
                        <form action="productos-admin.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                        </form>
                        <a href="editar-producto.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-primary">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No se encontraron productos.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
