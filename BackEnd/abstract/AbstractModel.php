<?php
abstract class AbstractModel {
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    protected function executeQuery(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log error or handle as needed
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    protected function fetchQuery(string $sql, array $params = []): array {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error or handle as needed
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
}