

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
<body>
    <h2>Editar Usuario</h2>
    <form method="POST" action="admin-users.php?action=update">
        <input type="hidden" name="codusuario" value="<?= $user['codusuario']?? '' ?>">

        <div>
            <label>Usuario:</label>
            <input type="text" name="usuario" value="<?= htmlspecialchars($user['usuario']?? '') ?>" required>
        </div>

        <div>
            <label>Contraseña (dejar vacío para no cambiar):</label>
            <input type="password" name="contrasena">
        </div>

        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']?? '') ?>" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($user['apellido']?? '') ?>" required>
        </div>

        <div>
            <label>Dirección:</label>
            <input type="text" name="direccion" value="<?= htmlspecialchars($user['direccion']?? '') ?>" required>
        </div>

        <div>
            <label>Teléfono:</label>
            <input type="text" name="telefono" placeholder="telefono" value="<?= htmlspecialchars($user['telefono']?? '') ?>" required>
        </div>

        <button type="submit">Actualizar Usuario</button>
    </form>
   
    <a href="admin-user-list.php">Volver a la lista</a>
</body>
</html>