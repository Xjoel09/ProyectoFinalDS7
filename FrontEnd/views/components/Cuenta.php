<?php
// Asegurarse de que no haya salida antes de session_start()
ob_start();
session_start();

require_once __DIR__ . '/../../../BackEnd/models/user.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';

// Verificar sesión
if (!isset($_SESSION['codusuario'])) {
    ob_end_clean(); // Limpiar cualquier salida
    header('Location: ../login.php');
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

// Inicializar variables
$user = null;
$error_message = '';

try {
    // Crear instancia del controlador
    $controller = new UserController($pdo);
    
    // Obtener el codusuario del usuario actual
    $usuarioId = $_SESSION['codusuario'];
    
    // Obtener los datos del usuario usando el controlador
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
                <form method="POST" action="update_user.php">
                    <input type="hidden" name="codusuario" value="<?php echo htmlspecialchars($user->getCodUsuario()); ?>">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($user->getUsuario()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user->getNombre()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user->getApellido()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($user->getDireccion()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user->getTelefono()); ?>" required>
                    </div>
                    <button type="submit">Guardar Cambios</button>
                </form>
            </div>
        <?php endif; ?>
    </section>
</main>

<script>
function toggleEditForm() {
    var form = document.getElementById('editForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>



