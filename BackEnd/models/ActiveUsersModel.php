<?php
class ActiveUsersModel extends AbstractModel {
    protected string $table = 'Users';

    // Get active users (those who have made orders)
    public function getActiveUsers(): array {
        $sql = "SELECT DISTINCT 
                    u.codusuario, 
                    u.usuario, 
                    u.nombre, 
                    u.apellido, 
                    u.direccion, 
                    u.telefono,
                    COUNT(p.id_pedido) AS total_pedidos
                FROM {$this->table} u
                JOIN Pedidos p ON u.codusuario = p.codusuario
                GROUP BY 
                    u.codusuario, 
                    u.usuario, 
                    u.nombre, 
                    u.apellido, 
                    u.direccion, 
                    u.telefono
                ORDER BY total_pedidos DESC";
        return $this->fetchQuery($sql);
    }

    // Get user's order history
    public function getUserOrderHistory(int $userId): array {
        $sql = "SELECT 
                    p.id_pedido, 
                    p.fecha_pedido, 
                    p.total,
                    pr.nombre_producto
                FROM Pedidos p
                JOIN Productos pr ON p.id_producto = pr.id_productos
                WHERE p.codusuario = ?
                ORDER BY p.fecha_pedido DESC";
        return $this->fetchQuery($sql, [$userId]);
    }
}