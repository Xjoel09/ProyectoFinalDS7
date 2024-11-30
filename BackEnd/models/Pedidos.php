<?php
class Pedido {
    private $id_pedido;
    private $fecha_pedido;
    private $estado;
    private $total;

    // Constructor
    public function __construct($fecha_pedido, $estado, $total, $id_pedido = null) {
        $this->id_pedido = $id_pedido;
        $this->fecha_pedido = $fecha_pedido;
        $this->estado = $estado;
        $this->total = $total;
    }

    // Getters y Setters
    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function getFechaPedido() {
        return $this->fecha_pedido;
    }

    public function setFechaPedido($fecha_pedido) {
        $this->fecha_pedido = $fecha_pedido;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    // Guardar pedido
    public function save($pdo) {
        if ($this->id_pedido) {
            $stmt = $pdo->prepare("UPDATE Pedido SET fecha_pedido = ?, estado = ?, total = ? WHERE id_pedido = ?");
            return $stmt->execute([$this->fecha_pedido, $this->estado, $this->total, $this->id_pedido]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Pedido (fecha_pedido, estado, total) VALUES (?, ?, ?)");
            $result = $stmt->execute([$this->fecha_pedido, $this->estado, $this->total]);
            if ($result) {
                $this->id_pedido = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
