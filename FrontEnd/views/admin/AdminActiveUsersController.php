<?php
require_once __DIR__ . '/../../../BackEnd/abstract/AbstractModel.php';
require_once __DIR__ . '/../../../BackEnd/models/ActiveUsersModel.php';
class AdminActiveUsersController {
    private ActiveUsersModel $activeUsersModel;
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->activeUsersModel = new ActiveUsersModel($pdo);
    }

    public function handleRequest() {
        session_start();
        if (!$this->isAdminAuthenticated()) {
            $this->redirectToLogin();
        }

        $action = $_GET['action'] ?? 'list';

        switch($action) {
            case 'history':
                $this->userOrderHistory();
                break;
            default:
                $this->listActiveUsers();
        }
    }

    public function listActiveUsers() {
        $activeUsers = $this->activeUsersModel->getActiveUsers();
        return $activeUsers;
        require 'views/admin/admin-active-users-list.php';
    }

    public function userOrderHistory() {
        $userId = $_GET['id'] ?? null;
        if ($userId) {
            $orderHistory = $this->activeUsersModel->getUserOrderHistory($userId);
            require __DIR__. '/admin-user-order-history.php';
        } else {
            // Redirect back to list if no ID provided
            header('Location: admin-active-users.php');
            exit();
        }
    }

    private function isAdminAuthenticated() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    private function redirectToLogin() {
        header('Location: http://localhost/ProyectoFinalDS7/FrontEnd/views/auth/login.php');
        exit();
    }
}