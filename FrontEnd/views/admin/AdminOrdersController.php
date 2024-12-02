<?php
require_once __DIR__ . '/../../../BackEnd/abstract/AbstractModel.php';
require_once __DIR__ . '/../../../BackEnd/models/OrderModel.php';
class AdminOrdersController {
    private OrderModel $orderModel;
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->orderModel = new OrderModel($pdo);
    }

    public function handleRequest() {
        session_start();
        if (!$this->isAdminAuthenticated()) {
            $this->redirectToLogin();
        }

        $action = $_GET['action'] ?? 'list';

        switch($action) {
            case 'view':
                $this->viewOrderDetails();
                break;
            default:
                $this->listOrders();
        }
    }

    public function listOrders() {
        $orders = $this->orderModel->getAllOrders();
        return $orders;
        require 'views/admin/admin-orders-list.php';
    }

    public function viewOrderDetails() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $order = $this->orderModel->getOrderById($id);
            require __DIR__ . '/admin-order-details.php';
        } else {
            // Redirect back to list if no ID provided
            header('Location: admin-orders.php');
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