<?php
class UserModel extends AbstractModel {
    protected string $table = 'Users';

    // Update user method
    public function updateUser(int $id, array $data): bool {
        // If password is provided, update it. Otherwise, keep existing.
        if (!empty($data['contrasena'])) {
            $sql = "UPDATE {$this->table} SET 
                    usuario = ?, 
                    contrasena = ?, 
                    nombre = ?, 
                    apellido = ?, 
                    direccion = ?, 
                    telefono = ? 
                    WHERE codusuario = ?";
            return $this->executeQuery($sql, [
                $data['usuario'], 
                $data['contrasena'],//password_hash($data['contrasena'], PASSWORD_DEFAULT), 
                $data['nombre'], 
                $data['apellido'],
                $data['direccion'],
                $data['telefono'],
                $id
            ]);
        } else {
            $sql = "UPDATE {$this->table} SET 
                    usuario = ?, 
                    nombre = ?, 
                    apellido = ?, 
                    direccion = ?, 
                    telefono = ? 
                    WHERE codusuario = ?";
            return $this->executeQuery($sql, [
                $data['usuario'], 
                $data['nombre'], 
                $data['apellido'],
                $data['direccion'],
                $data['telefono'],
                $id
            ]);
        }
    }

    // Delete user method
    public function deleteUser(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE codusuario = ?";
        return $this->executeQuery($sql, [$id]);
    }

    // Get all users method (for admin view)
    public function getAllUsers(): array {
        $sql = "SELECT codusuario, usuario, nombre, apellido, direccion, telefono FROM {$this->table}";
        $results = $this->fetchQuery($sql);

        if (empty($results)) {
            error_log("No users found in database");
        }
        
        return $results;
    }

    // Get single user by ID
    public function getUserById(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE codusuario = ?";
        $results = $this->fetchQuery($sql, [$id]);
         // Debug: Log results
    error_log("User fetch results for ID $id: " . print_r($results, true));
        return $results[0] ?? null;
    }
}