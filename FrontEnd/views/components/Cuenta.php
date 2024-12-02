<?php
ob_start(); // Esto es parar evitar salidas antes de iniciar la sesion; "Buffer de salida"
session_start();

require_once __DIR__ . '/../../../BackEnd/models/user.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

// Verificacion de la sesion
if (!isset($_SESSION['codusuario'])) {
    ob_end_clean(); // Limpiar cualquier salida
    header('Location: ../auth/login.php');
    exit();
}

class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerUsuario($usuarioId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE codusuario = ?");
            $stmt->execute([$usuarioId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }
}

// Iniciar variables para evitar errores
$user = null;
$error_message = '';

try {
    // Instancia del controlador
    $controller = new UserController($pdo);
    
    // Llamado del usuario actual desde la tabla
    $usuarioId = $_SESSION['codusuario'];
    
    // Esto es para obtener los datos de usuario desde el controlador
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



