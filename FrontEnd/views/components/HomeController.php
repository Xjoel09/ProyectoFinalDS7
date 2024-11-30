<?php
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

require_once __DIR__ . '/../../../BackEnd/models/Productos.php';

class ProductoController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para listar productos
    public function listarProductos() {
        $stmt = $this->pdo->query("SELECT * FROM Productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para guardar un producto
    public function guardarProducto($nombre, $descripcion, $precio_Venta) {
        $producto = new Producto($nombre, $descripcion, $precio_Venta);
        return $producto->save($this->pdo);
    }
}
?>
