<?php
include_once '../model/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($pdo) {
        $this->productModel = new ProductModel($pdo);
    }

    // Mostrar todos los productos
    public function showAllProducts() {
        return $this->productModel->getAllProducts();
    }

    // Crear un nuevo producto
    public function createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        return $this->productModel->createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color);
    }

    // Editar un producto
    public function editProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        return $this->productModel->updateProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color);
    }

    // Eliminar un producto
    public function deleteProduct($id) {
        return $this->productModel->deleteProduct($id);
    }
}
