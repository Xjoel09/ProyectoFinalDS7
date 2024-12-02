<?php
include 'AdminActiveUsersController.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$controller = new AdminActiveUsersController($pdo);
$orderHistory = $controller->userOrderHistory();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historial de Pedidos del Usuario</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Historial de Pedidos</h2>

    <?php if (empty($orderHistory)): ?>
        <p>No hay pedidos para este usuario.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderHistory as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id_pedido']) ?></td>
                        <td><?= htmlspecialchars($order['fecha_pedido']) ?></td>
                        <td><?= htmlspecialchars($order['nombre_producto']) ?></td>
                        <td>$<?= number_format($order['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="admin-active-users-list.php">Volver a usuarios activos</a>
</body>
</html>