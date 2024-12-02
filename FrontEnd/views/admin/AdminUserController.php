<?php
require_once __DIR__ . '/../../../BackEnd/abstract/AbstractModel.php';
require_once __DIR__ . '/../../../BackEnd/models/UserModel.php';
class AdminUserController {
    private UserModel $userModel;
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
    }

    public function handleRequest() {
        // Start session and check admin authentication
        session_start();
        if (!$this->isAdminAuthenticated()) {
            $this->redirectToLogin();
        }

        $action = $_GET['action'] ?? $_POST['action'] ?? 'list';

        switch($action) {
            case 'update':
                $this->updateUser();
                break;
            case 'delete':
                $this->deleteUser();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                $this->listUsers();
        }
    }

    public function updateUser() {

        $user = [
            'codusuario' => '',
            'usuario' => '',
            'nombre' => '',
            'apellido' => '',
            'direccion' => '',
            'telefono' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['codusuario'];
            $result = $this->userModel->updateUser($id, $_POST);
            $this->redirectWithMessage($result, 'Usuario actualizado exitosamente', 'error al actualizar usuario');
        } else {
             // Prepare edit form
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $user = $this->userModel->getUserById($id);
            
            // Debug: Check if user is found
            if ($user === null) {
                error_log("No user found with ID: $id");
                // Redirect or show error
                header('Location: admin-users.php?error=user_not_found');
                exit();
            }
        } else {
            // If no ID is provided, set $user to null or an empty array
            $user = null;
            error_log("No user ID provided");
        }
        
        // Use __DIR__ to get the absolute path
        require __DIR__ . '/admin-user-edit.php';
        }
    }

    public function deleteUser() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $result = $this->userModel->deleteUser($id);
            $this->redirectWithMessage($result, 'Usuario eliminado exitosamente', 'Error al eliminar usuario');
        }
    }

    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        return $users;
        require 'views/admin/admin-user-list.php';
    }

    public function isAdminAuthenticated() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    public function redirectToLogin() {
        header('Location: http://localhost/ProyectoFinalDS7/FrontEnd/views/auth/login.php');
        exit();
    }

    public function redirectWithMessage(bool $result, string $successMessage, string $errorMessage) {
        $_SESSION['message'] = $result ? $successMessage : $errorMessage;
        $_SESSION['message_type'] = $result ? 'success' : 'error';
        header('Location: admin-user-list.php');
        exit();
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = [];

        // Redirect to login page
        header('Location: http://localhost/ProyectoFinalDS7/FrontEnd/views/auth/login.php');
        exit();
    }
}