<?php
include './FrontEnd/views/components/HomeController.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$controller = new ProductoController($pdo);
$productos = $controller->listarProductos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tienda</title>
    <!-- Incluir el archivo CSS -->
    <link rel="stylesheet" href="../../assets/css/home.css" />
</head>
<body>
    <header>
        <h1>Tienda</h1>
    </header>
    <main>
        <section>
            <div class="container-items">
                <?php if (empty($productos)): ?>
                    <p>No hay productos disponibles en este momento.</p>
                <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="item">
                            <figure>
                                <!-- Suponiendo que cada producto tiene una imagen -->
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" />
                            </figure>
                            <div class="info-product">
                                <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <p class="price">$<?php echo number_format($producto['precio_venta'], 2); ?></p>
                                <button>Añadir al carrito</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
