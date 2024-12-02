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
    public function agregarProducto($producto) {
        // Verificar si el producto ya está en el carrito
        if (isset($_SESSION['carrito'])) {
            $existe = false;
            foreach ($_SESSION['carrito'] as &$item) {
                // Compara el id_producto que es único
                if ($item['id_producto'] == $producto['id_producto']) {
                    $item['precio_venta'] += $producto['precio_venta']; // Incrementa el precio total
                    $existe = true;
                    break;
                }
            }

            // Si no existe, lo agregamos al carrito
            if (!$existe) {
                $_SESSION['carrito'][] = $producto;
            }
        } else {
            // Si no existe el carrito en la sesión, lo creamos con el primer producto
            $_SESSION['carrito'] = [$producto];
        }
    }
}

$controller = new ProductoController($pdo);

// Agregar el producto al carrito si se envía la solicitud de agregar
if (isset($_POST['agregar_producto'])) {
    $producto = [
        'id_producto' => $_POST['id_producto'],  // Identificador único del producto
        'nombre_producto' => $_POST['nombre_producto'],
        'precio_venta' => $_POST['precio_venta'],
        'descripcion' => $_POST['descripcion']
    ];

    $controller->agregarProducto($producto);
    header("Location: /ProyectoFinalDS7/index.php?url=home");
    // Redirige al carrito después de agregar el producto
    exit();
}

// Limpiar el carrito si el usuario hace clic en el enlace
if (isset($_POST['limpiar_carrito'])) {
    $controller->limpiarCarrito();
    header("Location: /ProyectoFinalDS7/index.php?url=carrito");
    // Redirige al carrito después de limpiarlo
    exit();
}

$carrito = $controller->listarCarrito();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../../assets/css/carrito.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
        <!--<a href="/ProyectoFinal/index.php?url=home">Ir Home</a>-->
        </nav>
    </header>
    <main>
        <div class="container-cart">
            <?php if (empty($carrito)): ?>
                <p>El carrito está vacío.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($carrito as $producto): ?>
                        <li>
                            <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                            <p class="price">$<?php echo number_format($producto['precio_venta'], 2); ?></p>
                            <p>Descripción: <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Formulario para limpiar el carrito -->
            <form method="POST">
                <button type="submit" name="limpiar_carrito">Limpiar Carrito</button>
            </form>
        </div>
    </main>
</body>
</html>

<style>
    /* Estilo global para el body */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    padding: 0 20px;
    margin: 0;
}

/* Estilo para el header */
header {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 20px 0;
}

header h1 {
    font-size: 2.5rem;
    margin: 0;
}

/* Contenedor principal del carrito */
.container-cart {
    margin-top: 30px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Mensaje cuando el carrito está vacío */
.container-cart p {
    font-size: 1.2rem;
    color: #e74c3c;
    text-align: center;
}

/* Estilo para la lista de productos en el carrito */
.container-cart ul {
    list-style-type: none;
    padding: 0;
}

.container-cart li {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
}

.container-cart li:last-child {
    border-bottom: none;
}

/* Títulos de los productos */
.container-cart h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

/* Precio de cada producto */
.price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #e74c3c;
}

/* Descripción del producto */
.container-cart p {
    font-size: 1rem;
    color: #666;
}

/* Estilo para el formulario de limpiar carrito */
form {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

form button {
    padding: 10px 15px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #c0392b;
}

</style>