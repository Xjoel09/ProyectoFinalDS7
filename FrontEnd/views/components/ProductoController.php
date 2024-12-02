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
    public function agregarAlCarrito($id_producto, $cantidad) {
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
                    // Si el producto ya está en el carrito, incrementa la cantidad y el precio total
                    $item['cantidad'] += $cantidad;
                    $item['precio_venta'] += $producto['precio_venta'] * $cantidad;
                    $existe = true;
                    break;
                }
            }

            // Si no existe en el carrito, agregarlo como nuevo
            if (!$existe) {
                $_SESSION['carrito'][] = [
                    'id_producto' => $producto['id_productos'],
                    'nombre_producto' => $producto['nombre_producto'],
                    'precio_venta' => $producto['precio_venta'] * $cantidad,
                    'descripcion' => $producto['descripcion'],
                    'cantidad' => $cantidad
                ];
            }
        }
    }

    // Actualizar la cantidad de un producto en el carrito
    public function actualizarCantidadCarrito($id_producto, $nueva_cantidad) {
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['id_producto'] == $id_producto) {
                    // Actualiza la cantidad y recalcula el precio total del producto
                    $item['cantidad'] = $nueva_cantidad;
                    $item['precio_venta'] = $item['precio_venta'] / $item['cantidad'] * $nueva_cantidad;
                    break;
                }
            }
        }
    }

    // Calcular el precio total del carrito
    public function calcularTotalCarrito() {
        $total = 0;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio_venta'];
            }
        }
        return $total;
    }

    // Verificar disponibilidad del producto antes de agregar al carrito
    public function verificarDisponibilidad($id_producto, $cantidad) {
        $stmt = $this->pdo->prepare("SELECT stock FROM productos WHERE id_productos = ?");
        $stmt->execute([$id_producto]);
        $producto = $stmt->fetch();

        if ($producto && $producto['stock'] >= $cantidad) {
            return true; // Hay suficiente stock
        }

        return false; // No hay stock suficiente
    }

    // Generar un pedido (vacía el carrito y guarda la compra)
    public function generarPedido($id_usuario) {
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            $this->pdo->beginTransaction();

            try {
                // Insertar el pedido en la tabla de pedidos
                $stmt = $this->pdo->prepare("INSERT INTO pedidos (id_usuario, fecha_pedido, total) VALUES (?, NOW(), ?)");
                $total = $this->calcularTotalCarrito();
                $stmt->execute([$id_usuario, $total]);
                $id_pedido = $this->pdo->lastInsertId();

                // Insertar los detalles del pedido
                foreach ($_SESSION['carrito'] as $item) {
                    $stmt = $this->pdo->prepare(
                        "INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)"
                    );
                    $stmt->execute([$id_pedido, $item['id_producto'], $item['cantidad'], $item['precio_venta']]);

                    // Actualizar el stock del producto
                    $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id_productos = ?");
                    $stmt->execute([$item['cantidad'], $item['id_producto']]);
                }

                // Limpiar el carrito después de generar el pedido
                $this->limpiarCarrito();

                $this->pdo->commit();
                return $id_pedido; // Retornar el ID del pedido generado
            } catch (Exception $e) {
                $this->pdo->rollBack();
                throw $e;
            }
        }

        return null; // Retorna null si el carrito está vacío
    }
}

