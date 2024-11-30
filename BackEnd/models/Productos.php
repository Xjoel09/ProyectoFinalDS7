<?php
class Producto {
    private $id_producto;
    private $nombre_producto;
    private $descripcion;
    private $precio;

    // Constructor
    public function __construct($nombre_producto, $descripcion, $precio, $id_producto = null) {
        $this->id_producto = $id_producto;
        $this->nombre_producto = $nombre_producto;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    // Getters y Setters
    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getNombreProducto() {
        return $this->nombre_producto;
    }

    public function setNombreProducto($nombre_producto) {
        $this->nombre_producto = $nombre_producto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    // Guardar producto
    public function save($pdo) {
        if ($this->id_producto) {
            $stmt = $pdo->prepare("UPDATE Productos SET nombre_producto = ?, descripcion = ?, precio = ? WHERE id_producto = ?");
            return $stmt->execute([$this->nombre_producto, $this->descripcion, $this->precio, $this->id_producto]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Productos (nombre_producto, descripcion, precio) VALUES (?, ?, ?)");
            $result = $stmt->execute([$this->nombre_producto, $this->descripcion, $this->precio]);
            if ($result) {
                $this->id_producto = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
