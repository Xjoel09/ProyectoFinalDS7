<?php
session_start();
require_once __DIR__ . '/../../../BackEnd/models/Productos.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

class ProductoController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Listar todos los productos disponibles
    public function listarProductos() {
        $stmt = $this->pdo->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar productos en el carrito
    public function listarCarrito() {
        return $_SESSION['carrito'] ?? [];
    }

    // Limpiar el carrito
    public function limpiarCarrito() {
        unset($_SESSION['carrito']); // Elimina el carrito de la sesión
    }

    // Eliminar un producto específico del carrito
    public function eliminarDelCarrito($id_producto) {
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $index => $item) {
                if ($item['id_producto'] == $id_producto) {
                    unset($_SESSION['carrito'][$index]); // Elimina el producto
                    // Reindexamos el array para evitar índices desordenados
                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                    break;
                }
            }
        }
    }

    // Agregar un producto al carrito
    public function agregarAlCarrito($id_producto) {
        // Consulta el producto por su id
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id_productos = ?");
        $stmt->execute([$id_producto]);
        $producto = $stmt->fetch();

        if ($producto) {
            // Verificar si el carrito existe
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            $existe = false;

            // Verificar si el producto ya está en el carrito
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['id_producto'] == $producto['id_productos']) {
                    // Si existe, solo incrementa el precio
                    $item['precio_venta'] += $producto['precio_venta'];
                    $existe = true;
                    break;
                }
            }

            // Si no existe, lo agregamos al carrito
            if (!$existe) {
                $_SESSION['carrito'][] = [
                    'id_producto' => $producto['id_productos'],
                    'nombre_producto' => $producto['nombre_producto'],
                    'precio_venta' => $producto['precio_venta'],
                    'descripcion' => $producto['descripcion']
                ];
            }
        }
    }
}
