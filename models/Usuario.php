<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $db;
    private $table = 'usuarios';

    public function __construct() {
        $this->db = new Database();
    }
    public function obtenerTodos() {
        $conn = $this->db->conectar();
        $stmt = $conn->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
        $conn = $this->db->conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function registrar($email, $password, $rol) {
        $conn = $this->db->conectar();
        $query = "INSERT INTO usuarios (email, password, rol) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$email, $hashed, $rol]);
    }
    public function actualizar($id, $email, $rol) {
        $conn = $this->db->conectar();
        $query = "UPDATE usuarios SET email = :email, rol = :rol WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':email' => $email, ':rol' => $rol, ':id' => $id]);
    }

    public function login($email, $password) {
        $conn = $this->db->conectar();
        
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            unset($usuario['password']); 
            return $usuario;
        }
        return false;
    }
    public function eliminar($id) {
        $conn = $this->db->conectar();
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>