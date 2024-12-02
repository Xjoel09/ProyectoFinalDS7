<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Pedido</title>
    <style>
        .detail-section { margin-bottom: 20px; }
        .detail-label { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Detalles del Pedido #<?= htmlspecialchars($order['id_pedido']) ?></h2>

    <div class="detail-section">
        <h3>Información del Pedido</h3>
        <p><span class="detail-label">Fecha:</span> <?= htmlspecialchars($order['fecha_pedido']) ?></p>
        <p><span class="detail-label">Total:</span> $<?= number_format($order['total'], 2) ?></p>
    </div>

    <div class="detail-section">
        <h3>Información del Usuario</h3>
        <p><span class="detail-label">Nombre:</span> <?= htmlspecialchars($order['nombre'] . ' ' . $order['apellido']) ?></p>
        <p><span class="detail-label">Usuario:</span> <?= htmlspecialchars($order['nombre_usuario']) ?></p>
    </div>

    <div class="detail-section">
        <h3>Producto</h3>
        <p><span class="detail-label">Nombre:</span> <?= htmlspecialchars($order['nombre_producto']) ?></p>
        <p><span class="detail-label">Precio:</span> $<?= number_format($order['precio_venta'], 2) ?></p>
    </div>

    <a href="admin-orders-list.php">Volver a la lista de pedidos</a>
</body>
</html>