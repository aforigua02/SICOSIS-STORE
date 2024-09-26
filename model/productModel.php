<?php
class ProductModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los productos con sus tipos
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
                c.nombre_categoria,
                GROUP_CONCAT(tp.nombre_tipo_producto) AS tipos_productos
            FROM productos p
            JOIN categorias c ON p.id_categoria = c.id_categoria
            LEFT JOIN productos_tipos pt ON p.id_producto = pt.id_producto
            LEFT JOIN tipos_productos tp ON pt.id_tipo_producto = tp.id_tipo_producto
            GROUP BY p.id_producto
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
        
        $stmt->execute();
        return $this->pdo->lastInsertId(); // Devolver el ID del nuevo producto
    }

    // Añadir un tipo a un producto
    public function addProductType($id_producto, $id_tipo_producto) {
        $stmt = $this->pdo->prepare("INSERT INTO productos_tipos (id_producto, id_tipo_producto) VALUES (:id_producto, :id_tipo_producto)");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':id_tipo_producto', $id_tipo_producto);
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

    // Eliminar los tipos de productos de un producto
    public function removeProductTypes($id_producto) {
        $stmt = $this->pdo->prepare("DELETE FROM productos_tipos WHERE id_producto = :id_producto");
        $stmt->bindParam(':id_producto', $id_producto);
        return $stmt->execute();
    }

    // Eliminar un producto
    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id_producto = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
