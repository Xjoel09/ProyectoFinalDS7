<?php
class OrderModel extends AbstractModel {
    protected string $table = 'Pedidos';

    // Get all orders with user and product details
    public function getAllOrders(): array {
        $sql = "SELECT 
                    p.id_pedido, 
                    p.fecha_pedido, 
                    p.total, 
                    u.usuario AS nombre_usuario,
                    pr.nombre_producto
                FROM {$this->table} p
                JOIN Users u ON p.codusuario = u.codusuario
                JOIN Productos pr ON p.id_producto = pr.id_productos
                ORDER BY p.fecha_pedido DESC";
        return $this->fetchQuery($sql);
    }

    // Get order details by ID
    public function getOrderById(int $id): ?array {
        $sql = "SELECT 
                    p.id_pedido, 
                    p.fecha_pedido, 
                    p.total, 
                    u.codusuario,
                    u.usuario AS nombre_usuario,
                    u.nombre,
                    u.apellido,
                    pr.nombre_producto,
                    pr.precio_venta
                FROM {$this->table} p
                JOIN Users u ON p.codusuario = u.codusuario
                JOIN Productos pr ON p.id_producto = pr.id_productos
                WHERE p.id_pedido = ?";
        $results = $this->fetchQuery($sql, [$id]);
        return $results[0] ?? null;
    }
}