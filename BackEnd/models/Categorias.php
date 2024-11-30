<?php
class Categoria {
    private $id_categoria;
    private $nombre_categoria;
    private $descripcion;

    // Constructor
    public function __construct($nombre_categoria, $descripcion, $id_categoria = null) {
        $this->id_categoria = $id_categoria;
        $this->nombre_categoria = $nombre_categoria;
        $this->descripcion = $descripcion;
    }

    // Getters y Setters
    public function getIdCategoria() {
        return $this->id_categoria;
    }

    public function getNombreCategoria() {
        return $this->nombre_categoria;
    }

    public function setNombreCategoria($nombre_categoria) {
        $this->nombre_categoria = $nombre_categoria;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Guardar categoría
    public function save($pdo) {
        if ($this->id_categoria) {
            $stmt = $pdo->prepare("UPDATE Categoria SET nombre_categoria = ?, descripcion = ? WHERE id_categoria = ?");
            return $stmt->execute([$this->nombre_categoria, $this->descripcion, $this->id_categoria]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Categoria (nombre_categoria, descripcion) VALUES (?, ?)");
            $result = $stmt->execute([$this->nombre_categoria, $this->descripcion]);
            if ($result) {
                $this->id_categoria = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
