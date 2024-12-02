<?php
require_once __DIR__ . '/../../../BackEnd/abstract/AbstractModel.php';
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';
require_once __DIR__ . '/../../../BackEnd/models/UserModel.php';
require_once 'AdminUserController.php';

try {
    $adminUserController = new AdminUserController($pdo);
    $adminUserController->handleRequest();
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    // Redirect to error page
    header('Location: admin-error.php');
    exit();
}