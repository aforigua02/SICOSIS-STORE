<?php
class ProductModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los productos
    public function getAllProducts() {
        $query = "
            SELECT 
                p.id_producto, 
                p.nombre_producto, 
                p.descripcion, 
                p.precio, 
                p.cantidad_disponible, 
                p.url_imagen, 
                p.talla, 
                p.color,
                c.nombre_categoria 
            FROM productos p
            JOIN categorias c ON p.id_categoria = c.id_categoria
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener un producto por ID
    public function getProductById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo producto
    public function createProduct($nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        $query = "INSERT INTO productos (nombre_producto, descripcion, precio, cantidad_disponible, url_imagen, id_categoria, talla, color) 
                  VALUES (:nombre, :descripcion, :precio, :cantidad, :url_imagen, :id_categoria, :talla, :color)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':url_imagen', $url_imagen);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':color', $color);
        
        return $stmt->execute();
    }
    
    // Actualizar un producto
    public function updateProduct($id, $nombre, $descripcion, $precio, $cantidad, $url_imagen, $id_categoria, $talla, $color) {
        $stmt = $this->pdo->prepare("UPDATE productos SET nombre_producto = :nombre, descripcion = :descripcion, precio = :precio, cantidad_disponible = :cantidad, url_imagen = :url_imagen, id_categoria = :id_categoria, talla = :talla, color = :color WHERE id_producto = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':url_imagen', $url_imagen);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':color', $color);
        return $stmt->execute();
    }

    // Eliminar un producto
    public function deleteProduct($id) {
        $query = "DELETE FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
