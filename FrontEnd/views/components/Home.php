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
                    <<form method="POST">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_productos']; ?>">
                        <button type="submit">
                            🛍️ Añadir al carrito
                        </button>
                    </form>
                        <!-- Corazón fuera del botón, a un lado -->
                        <button class="heart-btn">
                                <i class="fas fa-heart"></i> <!-- Icono de corazón -->
                            </button>
                       
                </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
<style>
        /* Estilo para los botones de acción */
        .actions {
            display: flex;
            align-items: center;  /* Asegura que los botones estén alineados verticalmente */
            gap: 12px;  /* Espacio entre los botones */
            justify-content: flex-start; /* Asegura que los botones estén alineados a la izquierda */
        }

        .add-to-cart-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 15px;  /* Ajustado el padding */
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-to-cart-btn:hover {
            background-color: #45a049;
        }

        .heart-btn {
            background-color: transparent;
            border-color: black;
           margin-top: -60px;
           margin-left: 200px;
            cursor: pointer;
            font-size: 20px;
            color: red;
        }

        .heart-btn:hover {
            color: #cc0000;
        }

        /* Reseteo de márgenes y padding para todos los elementos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilo global para el body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding: 0 20px;
        }

        /* Header */
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

        /* Estilo para el contenedor de productos */
        .container-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            justify-items: center;
            margin-top: 30px;
        }

        /* Estilo individual para cada producto */
        .item {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            transition: transform 0.3s ease-in-out;
        }

        .item:hover {
            transform: scale(1.05);
        }

        .item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Información del producto */
        .info-product {
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .info-product h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .info-product p {
            font-size: 1rem;
            color: #666;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #e74c3c;
        }

        button {
            padding: 10px 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        /* Mensaje de productos vacíos */
        p {
            font-size: 1.2rem;
            color: #333;
            text-align: center;
            margin-top: 50px;
        }
    </style>