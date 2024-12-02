<?php
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../BackEnd/models/user.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

$user = null;
$error_message = '';

if (!isset($_SESSION['codusuario'])) {
    $error_message = "Para ver los datos de su usuario debe iniciar sesión.";
} else {
    try {
        $controller = new UserController($pdo);
        $usuarioId = $_SESSION['codusuario'];
        $userData = $controller->obtenerUsuario($usuarioId);

        if ($userData) {
            $user = new User(
                $userData['usuario'], 
                $userData['contrasena'], 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['direccion'], 
                $userData['telefono'], 
                $userData['codusuario']
            );
        } else {
            $error_message = "Usuario no encontrado.";
        }
    } catch (Exception $e) {
        $error_message = "Error al cargar los datos del usuario.";
        error_log("Error: " . $e->getMessage());
    }
}
?>

<main>
    <section>
        <?php if ($error_message): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php elseif ($user): ?>
            <h1>Perfil de usuario</h1>
            <p><strong>Usuario:</strong> <?php echo htmlspecialchars($user->getUsuario()); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user->getNombre()); ?></p>
            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user->getApellido()); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($user->getDireccion()); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user->getTelefono()); ?></p>
        <?php endif; ?>
    </section>
</main>

<script>
function toggleEditForm() {
    var form = document.getElementById('editForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>



