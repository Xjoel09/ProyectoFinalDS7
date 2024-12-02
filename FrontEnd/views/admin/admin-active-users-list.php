<?php
include 'AdminActiveUsersController.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$controller = new AdminActiveUsersController($pdo);
$activeUsers = $controller->listActiveUsers();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios Activos</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Usuarios Activos</h2>
    <a href="admin-user-list.php">Regresar</a>
    <?php if (!empty($activeUsers)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Total de Pedidos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activeUsers as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['codusuario']) ?></td>
                    <td><?= htmlspecialchars($user['usuario']) ?></td>
                    <td><?= htmlspecialchars($user['nombre']) ?></td>
                    <td><?= htmlspecialchars($user['apellido']) ?></td>
                    <td><?= htmlspecialchars($user['direccion']) ?></td>
                    <td><?= htmlspecialchars($user['telefono']) ?></td>
                    <td><?= htmlspecialchars($user['total_pedidos']) ?></td>
                    <td>
                        <a href="admin-active-users.php?action=history&id=<?= $user['codusuario'] ?>">Ver Historial</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay usuarios para mostrar.</p>
    <?php endif; ?>
</body>
</html>