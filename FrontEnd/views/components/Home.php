<?php
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';
require_once __DIR__ . '/../../../BackEnd/models/Productos.php';
require_once __DIR__ . '/../../../FrontEnd/views/components/HomeController.php';

session_start();

$controller = new ProductoController($pdo);

// Verifica si se recibe un producto para agregar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
/*    if(isset($_SESSION['codusuario']) && $_SESSION['nombre'] && $_SESSION['apellido']) {
        $controller->agregarAlCarrito($_POST['id_producto']);
    }else {
        header('Location: /ProyectoFinal/FrontEnd/views/auth/login.php');
        exit();
    }
*/
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
    <link rel="stylesheet" href="/ProyectoFinal/FrontEnd/assets/css/home.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body>
    <header>
        <h1>Tienda</h1>
        <nav>
        <!--<a href="/ProyectoFinal/index.php?url=carrito">Ver carrito</a>-->

        </nav>
    </header>
    <main>
        <div class="container-items">
            <?php foreach ($productos as $producto): ?>
                <div class="item">
                <img src="/ruta/de/imagen.jpg" alt="Nombre del producto"> <!-- Imagen del producto -->
                <div class="info-product">
                    <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p class="price">$<?php echo number_format($producto['precio_venta'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_productos']; ?>">
                        <button type="submit">
                            <i class="fas fa-heart" style="color: red; margin-right: 5px;"></i>
                            Añadir al carrito
                        </button>
                    </form>
                </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
