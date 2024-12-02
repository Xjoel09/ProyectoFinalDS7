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

    // Método para agregar un producto al carrito
    public function agregarAlCarrito($id_producto) {
        // Iniciar la sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Asegurarse de que el id_producto es un número entero
        $id_producto = intval($id_producto);

        // Verificar si el id_producto es un número válido y mayor a 0
        if ($id_producto > 0) {
            // Inicializar el carrito si no existe
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            // Buscar el producto por ID
            $stmt = $this->pdo->prepare("SELECT * FROM Productos WHERE id_productos = ?");
            $stmt->execute([$id_producto]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                // Agregar el producto al carrito
                $_SESSION['carrito'][] = $producto;
            } else {
                // Si no se encuentra el producto
                echo "Producto no encontrado.";
            }
        } else {
            // Si el id_producto no es válido
            echo "ID de producto inválido.";
        }
    }
}
?>