<?php
class Carrito {
    private $id_carrito;
    private $id_usuario; // Nuevo campo
    private $id_productos;
    private $nombre_producto;
    private $descripcion;
    private $precio_unitario;
    private $cantidad;
    private $total;

    // Constructor
    public function __construct($id_usuario, $id_productos, $nombre_producto, $descripcion, $precio_unitario, $cantidad = 1, $id_carrito = null) {
        $this->id_carrito = $id_carrito;
        $this->id_usuario = $id_usuario; // Asignar usuario
        $this->id_productos = $id_productos;
        $this->nombre_producto = $nombre_producto;
        $this->descripcion = $descripcion;
        $this->precio_unitario = $precio_unitario;
        $this->cantidad = $cantidad;
        $this->total = $precio_unitario * $cantidad;
    }

    // Métodos

    // Agregar producto al carrito
    public function addToCarrito($pdo) {
        $stmt = $pdo->prepare("INSERT INTO Carrito (id_usuario, id_productos, nombre_producto, descripcion, precio_unitario, cantidad, total) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->id_usuario,
            $this->id_productos,
            $this->nombre_producto,
            $this->descripcion,
            $this->precio_unitario,
            $this->cantidad,
            $this->total
        ]);
    }

    // Obtener el carrito de un usuario específico
    public static function getCarritoByUser($pdo, $id_usuario) {
        $stmt = $pdo->prepare("SELECT * FROM Carrito WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Otros métodos (actualizar, eliminar) también necesitan el id_usuario como parámetro si es necesario.
}
?>