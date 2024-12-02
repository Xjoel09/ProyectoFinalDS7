<?php
include 'AdminUserController.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$controller = new AdminUserController($pdo);
$users = $controller->listUsers();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administración de Usuarios</title>
    <style>
        .success { color: green; }
        .error { color: red; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Administración de Usuarios</h2>
    <a href="admin-active-users-list.php">Ir a Usuarios Activos</a>
    <a href="admin-orders-list.php">Ir a Pedidos</a> 
    <?php if (isset($_SESSION['message'])): ?>
        <div class="<?= $_SESSION['message_type'] ?>">
            <?= $_SESSION['message'] ?>
        </div>
        <?php 
        unset($_SESSION['message']);
        unset($_SESSION['message_type']); 
        ?>
    <?php endif; ?>


    <?php if (!empty($users)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['codusuario']) ?></td>
                    <td><?= htmlspecialchars($user['usuario']) ?></td>
                    <td><?= htmlspecialchars($user['nombre']) ?></td>
                    <td><?= htmlspecialchars($user['apellido']) ?></td>
                    <td><?= htmlspecialchars($user['direccion']) ?></td>
                    <td><?= htmlspecialchars($user['telefono']) ?></td>
                    <td>
                        <a href="admin-users.php?action=update&id=<?= $user['codusuario'] ?>">Editar</a> | 
                        <a href="admin-users.php?action=delete&id=<?= $user['codusuario'] ?>" 
                           onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
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