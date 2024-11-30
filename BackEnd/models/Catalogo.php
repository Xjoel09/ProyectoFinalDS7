<?php
class Catalogo {
    private $id_catalogo;
    private $nombre_catalogo;
    private $descripcion;

    // Constructor
    public function __construct($nombre_catalogo, $descripcion, $id_catalogo = null) {
        $this->id_catalogo = $id_catalogo;
        $this->nombre_catalogo = $nombre_catalogo;
        $this->descripcion = $descripcion;
    }

    // Getters y Setters
    public function getIdCatalogo() {
        return $this->id_catalogo;
    }

    public function getNombreCatalogo() {
        return $this->nombre_catalogo;
    }

    public function setNombreCatalogo($nombre_catalogo) {
        $this->nombre_catalogo = $nombre_catalogo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Guardar catálogo
    public function save($pdo) {
        if ($this->id_catalogo) {
            $stmt = $pdo->prepare("UPDATE Catalogo SET nombre_catalogo = ?, descripcion = ? WHERE id_catalogo = ?");
            return $stmt->execute([$this->nombre_catalogo, $this->descripcion, $this->id_catalogo]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Catalogo (nombre_catalogo, descripcion) VALUES (?, ?)");
            $result = $stmt->execute([$this->nombre_catalogo, $this->descripcion]);
            if ($result) {
                $this->id_catalogo = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
