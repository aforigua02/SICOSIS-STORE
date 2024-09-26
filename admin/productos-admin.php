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
        // Pasar los campos del formulario y los tipos de productos seleccionados
        $productController->createProduct(
            $_POST['nombre'], 
            $_POST['descripcion'], 
            $_POST['precio'], 
            $_POST['cantidad'], 
            $_POST['url_imagen'], 
            $_POST['id_categoria'],
            $_POST['talla'], 
            $_POST['color'],
            $_POST['tipos_productos'] // Tipos seleccionados
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
            $_POST['talla'],  
            $_POST['color'],
            $_POST['tipos_productos'] // Tipos seleccionados
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Sicosis_Store/public/styles.css">
</head>
<body>
    
    <div class="container-fluid mt-1 producto-container">
        <h1 class="text-center titulo-dashboard">Administración Sicosis</h1>
        <div class="row contenedor-formulario">
            <div class="col-md-9">
                <div class="card p-4 mt-4">
                    <h2 class="tituloCrud">Agregar / Actualizar Producto</h2>
                    <form class="mt-4 formularioProductos" action="productos-admin.php" method="POST">
                        <input type="hidden" name="id" value="">
                        <!-- Campos de producto -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <input type="text" name="nombre" class="form-control inputform" placeholder="Nombre del producto" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" name="precio" class="form-control inputform" placeholder="Precio" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="talla" class="form-label">Talla</label>
                                <input type="text" name="talla" class="form-control inputform" placeholder="Talla" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control inputform" placeholder="Descripción" required></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cantidad" class="form-label">Cantidad disponible</label>
                                <input type="number" name="cantidad" class="form-control inputform" placeholder="Cantidad disponible" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" name="color" class="form-control inputform" placeholder="Color" required>
                            </div>
                        </div>

                        <!-- Campo para la URL de la imagen -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="url_imagen" class="form-label">URL de la imagen</label>
                                <input type="text" name="url_imagen" class="form-control inputform" placeholder="URL de la imagen" required>
                            </div>
                            <!-- Tipos de productos (selección única, como categoría) -->
                            <div class="col-md-6 mb-3">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select name="id_categoria" class="form-select inputform" required>
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
                        <!-- Tipos de productos -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipos_productos" class="form-label ">Tipos de Productos</label>
                                <select name="tipos_productos[]" class="form-select inputform"required> <!-- Cambiado a múltiple -->
                                    <?php
                                    // Obtener todos los tipos de productos
                                    $stmt = $pdo->prepare("SELECT id_tipo_producto, nombre_tipo_producto FROM tipos_productos");
                                    $stmt->execute();
                                    $tipos_productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($tipos_productos as $tipo) {
                                        echo "<option value='{$tipo['id_tipo_producto']}'>{$tipo['nombre_tipo_producto']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="btn-group-producto mt-3">
                                <button type="submit" name="create" class="btn btn-primary">Crear Producto</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="contenedorTablaproductos">
        <h2 class="mt-5 listaProductos">Lista de Productos</h2>
        <?php if (!empty($productos)): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Talla</th>
                    <th>Color</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Tipos de Producto</th>
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
                    <td><?php echo $producto['talla']; ?></td>
                    <td><?php echo $producto['color']; ?></td>
                    <td><img src="<?php echo $producto['url_imagen']; ?>" alt="Imagen" style="width:100px;"></td>
                    <td><?php echo $producto['nombre_categoria']; ?></td>
                    <td><?php echo $producto['tipos_productos']; ?></td>
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
