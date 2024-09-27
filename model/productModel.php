<?php
class ProductModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los productos con sus tipos
    public function getAllProducts() {
    $query = $this->pdo->prepare('CALL GetAllProducts()');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
    }



    // Crear un nuevo producto
    public function createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        // Llamada al procedimiento almacenado
        $query = "CALL CreateProduct(:nombre, :descripcion, :precio, :cantidad, :url_imagen, :id_categoria, :talla, :color)";
        $stmt = $this->pdo->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':url_imagen', $url_imagen);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':color', $color);
        
        $stmt->execute();
    
        // Obtener el ID del nuevo producto
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['new_product_id'];
    }
    

    // Añadir un tipo a un producto
    public function addProductType($id_producto, $id_tipo_producto, $id_categoria) {
        // Llamada al procedimiento almacenado
        $query = "CALL AddProductType(:id_producto, :id_tipo_producto, :id_categoria)";
        $stmt = $this->pdo->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':id_tipo_producto', $id_tipo_producto);
        $stmt->bindParam(':id_categoria', $id_categoria);
        
        return $stmt->execute(); // Ejecutar la consulta
    }
    
    

    // Actualizar un producto
    public function updateProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        // Llamada al procedimiento almacenado
        $query = "CALL UpdateProduct(:id, :nombre, :descripcion, :precio, :cantidad, :url_imagen, :id_categoria, :talla, :color)";
        $stmt = $this->pdo->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':url_imagen', $url_imagen);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':color', $color);
        
        return $stmt->execute(); // Ejecutar la consulta
    }
    

    // Eliminar los tipos de productos de un producto
    public function removeProductTypes($id_producto) {
        // Llamada al procedimiento almacenado
        $query = "CALL RemoveProductTypes(:id_producto)";
        $stmt = $this->pdo->prepare($query);    
        // Vincular los parámetros
        $stmt->bindParam(':id_producto', $id_producto);    
        return $stmt->execute(); // Ejecutar la consulta
    }
    

    // Eliminar un producto
    public function deleteProduct($id) {
        // Llamada al procedimiento almacenado
        $query = "CALL DeleteProduct(:id)";
        $stmt = $this->pdo->prepare($query);
    
        // Vincular el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute(); // Ejecutar la consulta
    }    
}
