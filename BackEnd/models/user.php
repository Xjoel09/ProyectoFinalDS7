<?php
class User {
    private $codusuario;
    private $usuario;
    private $contrasena;
    private $nombre;
    private $apellido;
    private $direccion;
    private $telefono;

    // Constructor
    public function __construct($usuario, $contrasena, $nombre, $apellido, $direccion, $telefono, $codusuario = null) {
        $this->codusuario = $codusuario;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

    // Getters and Setters
    public function getCodusuario() {
        return $this->codusuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    // Save method (example)
    public function save($pdo) {
        if ($this->codusuario) {
            $stmt = $pdo->prepare("UPDATE Users SET usuario = ?, contrasena = ?, nombre = ?, apellido = ?, direccion = ?, telefono = ? WHERE codusuario = ?");
            return $stmt->execute([$this->usuario, $this->contrasena, $this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->codusuario]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Users (usuario, contrasena, nombre, apellido, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$this->usuario, $this->contrasena, $this->nombre, $this->apellido, $this->direccion, $this->telefono]);
            if ($result) {
                $this->codusuario = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
