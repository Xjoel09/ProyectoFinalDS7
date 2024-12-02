<?php
include 'conexion.php';
abstract class AbstractUsuario implements IUsuario {
    protected $pdo;
    protected $id;
    protected $usuario;
    protected $nombre;
    protected $apellido;
    protected $direccion;
    protected $telefono;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    abstract public function getTipo(); // Retorna 'admin' o 'cliente'
    abstract public function getTabla();
    
    public function login($usuario, $password) {
        $query = "SELECT * FROM " . $this->getTabla() . 
                 " WHERE usuario = ? AND contrasena = ?";
        $stmt = $this->pdo->prepare($query);
    $stmt->execute([$usuario, $password/*password_hash($password, PASSWORD_DEFAULT)*/]);
        
        if($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->iniciarSesion($data);
            return true;
        }
        return false;
    }
    
    protected function iniciarSesion($data) {
        $_SESSION['usuario_id'] = $data['id'];
        $_SESSION['usuario_tipo'] = $this->getTipo();
        $_SESSION['usuario_nombre'] = $data['nombre'];
    }
    
    public function logout() {
        session_destroy();
    }
}