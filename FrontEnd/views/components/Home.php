<?php
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';
require_once __DIR__ . '/../../../BackEnd/models/Productos.php';
require_once __DIR__ . '/../../../FrontEnd/views/components/ProductoController.php';

// Inicia la sesión solo si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$controller = new ProductoController($pdo);

// Verifica si se recibe un producto para agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    if (isset($_SESSION['codusuario'])) {
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];

        if ($cantidad > 0) {
            $controller->agregarAlCarrito($id_producto, $cantidad, $_SESSION['codusuario']);
            $mensaje = "Producto añadido al carrito con éxito.";
        } else {
            $mensaje = "La cantidad debe ser al menos 1.";
        }
    } else {
        header('Location: /ProyectoFinalDS7/FrontEnd/views/auth/login.php');
        exit();
    }
}

// Lista los productos
$productos = $controller->listarProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Tienda</h1>
    </header>

    <?php if (isset($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <main>
        <div class="container-items">
            <?php foreach ($productos as $producto): ?>
                <div class="item">
                    <img src="/ruta/de/imagen.jpg" alt="Nombre del producto">
                    <div class="info-product">
                        <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                        <p class="price">$<?php echo number_format($producto['precio_venta'], 2); ?></p>
                        <form method="POST">
                            <input type="hidden" name="id_producto" value="<?php echo $producto['id_productos']; ?>">
                            <label for="cantidad-<?php echo $producto['id_productos']; ?>">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad-<?php echo $producto['id_productos']; ?>" value="1" min="1">
                            <button type="submit">🛍️ Añadir al carrito</button>
                        </form>
                        <button class="btn-description" 
                                data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" 
                                data-precio="<?php echo number_format($producto['precio_venta'], 2); ?>"
                                data-descripcion="<?php echo htmlspecialchars($producto['descripcion']); ?>"
                                data-imagen="/ruta/de/imagen.jpg">📖 Ver Descripción</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <img id="modal-image" src="" alt="Imagen del Producto" style="width: 100px; height: 100px; object-fit: cover;">
            <h2 id="modal-nombre"></h2>
            <p id="modal-precio"></p>
            <p id="modal-description"></p>
        </div>
    </div>

    <script>
        // Manejo del modal
        const modal = document.getElementById('modal');
        const modalDescription = document.getElementById('modal-description');
        const modalNombre = document.getElementById('modal-nombre');
        const modalPrecio = document.getElementById('modal-precio');
        const modalImage = document.getElementById('modal-image');
        const closeModal = document.querySelector('.close-btn');

        // Muestra la descripción del producto
        document.querySelectorAll('.btn-description').forEach(button => {
            button.addEventListener('click', () => {
                const nombre = button.getAttribute('data-nombre');
                const precio = button.getAttribute('data-precio');
                const descripcion = button.getAttribute('data-descripcion');
                const imagen = button.getAttribute('data-imagen');

                modalNombre.textContent = nombre;
                modalPrecio.textContent = '$' + precio;
                modalDescription.textContent = descripcion;
                modalImage.src = imagen;

                modal.style.display = 'block';
            });
        });

        // Cierra el modal al hacer clic en la "x"
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Cierra el modal al hacer clic fuera del contenido
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>


<style>
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
        border-radius: 8px;
        position: relative;
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 20px;
    }

    .close-btn:hover, .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


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