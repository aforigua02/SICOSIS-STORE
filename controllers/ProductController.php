<?php
include_once __DIR__ . '/../model/ProductModel.php';

class ProductController {
    private $productModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // 
        $this->productModel = new ProductModel($pdo);
    }

    // Mostrar todos los productos
    public function showAllProducts() {
        return $this->productModel->getAllProducts();
    }

    public function getProductById($id) {
        $query = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo producto y vincular sus tipos
    public function createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color, $tipos_productos) {
        $this->pdo->beginTransaction();

        try {
            // Crear el producto
            $productId = $this->productModel->createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color);

            // Asignar los tipos de productos
            if (!empty($tipos_productos)) {
                foreach ($tipos_productos as $tipo_producto_id) {
                    $this->productModel->addProductType($productId, $tipo_producto_id);
                }
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    // Editar un producto y sus tipos
    public function editProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color, $tipos_productos) {
        $this->pdo->beginTransaction();

        try {
            // Actualizar el producto
            $this->productModel->updateProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color);

            // Eliminar los tipos actuales y agregar los nuevos
            $this->productModel->removeProductTypes($id);
            if (!empty($tipos_productos)) {
                foreach ($tipos_productos as $tipo_producto_id) {
                    $this->productModel->addProductType($id, $tipo_producto_id);
                }
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }


    // Eliminar un producto y sus tipos
    public function deleteProduct($id) {
        $this->pdo->beginTransaction();

        try {
            // Eliminar las asignaciones de tipos de productos
            $this->productModel->removeProductTypes($id);

            // Eliminar el producto
            $this->productModel->deleteProduct($id);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // En ProductController.php
}
