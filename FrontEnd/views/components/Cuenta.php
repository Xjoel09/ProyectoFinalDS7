<?php
session_start();
require_once '../../BackEnd/models/user.php';
require_once '../../BackEnd/config/conexion.php';


$pdo = new PDO("mysql:host=localhost;dbname=nombre_de_la_base_de_datos", "tu_usuario", "tu_contraseña");

// Obtener el codusuario del usuario actual
$usuarioId = $_SESSION['codusuario'];

// Obtener los datos del usuario
$stmt = $pdo->prepare("SELECT * FROM Users WHERE codusuario = ?");
$stmt->execute([$usuarioId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userData) {
    $user = new User($userData['usuario'], $userData['contrasena'], $userData['nombre'], $userData['apellido'], $userData['direccion'], $userData['telefono'], $userData['codusuario']);
} else {
    echo "Usuario no encontrado.";
}
?>

<main>
    <section>
        <h1>Perfil de Usuario</h1>
        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($user->getUsuario()); ?></p>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user->getNombre()); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user->getApellido()); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($user->getDireccion()); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user->getTelefono()); ?></p>
        
        <!-- Botón para editar datos -->
        <button id="editButton" onclick="toggleEditForm()">Editar Datos</button>

        <!-- Formulario de edición -->
        <div id="editForm" style="display:none;">
            <h2>Editar Datos</h2>
            <form method="POST" action="update_user.php"> <!-- Cambia la acción según tu lógica -->
                <input type="text" name="usuario" value="<?php echo htmlspecialchars($user->getUsuario()); ?>" required>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user->getNombre()); ?>" required>
                <input type="text" name="apellido" value="<?php echo htmlspecialchars($user->getApellido()); ?>" required>
                <input type="text" name="direccion" value="<?php echo htmlspecialchars($user->getDireccion()); ?>" required>
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($user->getTelefono()); ?>" required>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </section>
</main>

<script>
function toggleEditForm() {
    var form = document.getElementById('editForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>



