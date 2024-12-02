<?php
session_start();
require_once __DIR__ . '/../../../BackEnd/models/Productos.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

class ProductoController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Listar productos en el carrito
    public function listarCarrito() {
        return $_SESSION['carrito'] ?? [];
    }

    // Limpiar el carrito
    public function limpiarCarrito() {
        unset($_SESSION['carrito']); // Elimina el carrito de la sesión
    }

    // Agregar un producto al carrito
    public function agregarAlCarrito($id_producto) {
        // Consulta el producto por su id
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id_productos = ?");
        $stmt->execute([$id_producto]);
        $producto = $stmt->fetch();

        if ($producto) {
            // Verificar si el producto ya está en el carrito
            if (isset($_SESSION['carrito'])) {
                $existe = false;
                foreach ($_SESSION['carrito'] as &$item) {
                    // Compara el id_producto que es único
                    if ($item['id_producto'] == $producto['id_productos']) {
                        // Si existe, solo incrementa el precio (no agrega el producto de nuevo)
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
            } else {
                // Si no existe el carrito en la sesión, lo creamos con el primer producto
                $_SESSION['carrito'] = [
                    [
                        'id_producto' => $producto['id_productos'],
                        'nombre_producto' => $producto['nombre_producto'],
                        'precio_venta' => $producto['precio_venta'],
                        'descripcion' => $producto['descripcion']
                    ]
                ];
            }
        }
    }
}
