<?php
include 'AdminOrdersController.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$controller = new AdminOrdersController($pdo);
$orders = $controller->listOrders();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración de Pedidos</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Lista de Pedidos</h2>
    <a href="admin-user-list.php">Regresar</a>
    <?php if (!empty($orders)): ?>
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Producto</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id_pedido']) ?></td>
                    <td><?= htmlspecialchars($order['fecha_pedido']) ?></td>
                    <td><?= htmlspecialchars($order['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($order['nombre_producto']) ?></td>
                    <td class="total">$<?= number_format($order['total'], 2) ?></td>
                    <td>
                        <a href="admin-orders.php?action=view&id=<?= $order['id_pedido'] ?>">Ver Detalles</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay ordenes para mostrar.</p>
    <?php endif; ?>
</body>
</html>