<?php
require_once __DIR__ . '/../config/Database.php';

class Cliente {
    private $db;
    private $table = 'clientes';

    public function __construct() {
        $this->db = new Database();
    }

    public function registrar($datos) {
        $conn = $this->db->conectar();
        
        // Verifica si el email ya existe
        if($this->emailExiste($datos['email'])) {
            return false;
        }
        
        $query = "INSERT INTO $this->table 
                  (nombre, email, password, direccion, telefono)
                  VALUES (:nombre, :email, :password, :direccion, :telefono)";
        
        $stmt = $conn->prepare($query);
        
        $hash = password_hash($datos['password'], PASSWORD_DEFAULT);
        
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':email' => $datos['email'],
            ':password' => $hash,
            ':direccion' => $datos['direccion'],
            ':telefono' => $datos['telefono']
        ]);
    }

    private function emailExiste($email) {
        $conn = $this->db->conectar();
        $query = "SELECT id FROM $this->table WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function login($email, $password) {
        $conn = $this->db->conectar();
        $query = "SELECT id, nombre, email, password, habilitado 
                  FROM clientes 
                  WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && $cliente['habilitado'] == 1 && password_verify($password, $cliente['password'])) {
            unset($cliente['password']);
            return $cliente;
        }
    
        return false;
    
    }
     //Cambiar estado habilitado/inhabilitado
    public function cambiarEstado($id, $habilitado) {
        $conn = $this->db->conectar();
        $query = "UPDATE clientes SET habilitado = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$habilitado, $id]);
    }

    //Obtiene todos los clientes
    public function obtenerTodos() {
        $conn = $this->db->conectar();
        return $conn->query("SELECT * FROM $this->table")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
        $conn = $this->db->conectar();
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function actualizar($id, $nombre, $email, $direccion, $telefono) {
        $conn = $this->db->conectar();
        $query = "UPDATE clientes SET 
                    nombre = ?, 
                    email = ?, 
                    direccion = ?, 
                    telefono = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$nombre, $email, $direccion, $telefono, $id]);
    }
    public function find($where, $format = null)
{
    return $this->session()->query(\ModelHelper::class::mapToModel(\User::class, $where))->first();
}

}
?>