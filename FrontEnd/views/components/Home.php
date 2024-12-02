<?php
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';
require_once __DIR__ . '/../../../BackEnd/models/Productos.php';
require_once __DIR__ . '/../../../FrontEnd/views/components/HomeController.php';

$controller = new ProductoController($pdo);

// Verifica si se recibe un producto para agregar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $controller->agregarAlCarrito($_POST['id_producto']);
}

$productos = $controller->listarProductos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="../../assets/css/home.css">
</head>
<body>
    <header>
        <h1>Tienda</h1>
        <nav>
            <a href="carrito.php">Ver Carrito</a>
        </nav>
    </header>
    <main>
        <div class="container-items">
            <?php foreach ($productos as $producto): ?>
                <div class="item">
                    <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p class="price">$<?php echo number_format($producto['precio_venta'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_productos']; ?>">
                        <button type="submit">Añadir al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
