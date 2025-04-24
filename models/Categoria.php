<?php
require_once __DIR__ . '/../config/Database.php';

class Categoria {
    private $db;
    private $table = 'categorias';

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerTodas() {
        $conn = $this->db->conectar();
        return $conn->query("SELECT * FROM $this->table")->fetchAll();
    }
    
    public function obtenerPorId($id) {
        $conn = $this->db->conectar();
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre) {
        $conn = $this->db->conectar();
        $query = "INSERT INTO $this->table (nombre) VALUES (:nombre)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':nombre' => $nombre]);
    }

    public function actualizar($id, $nombre) {
        $conn = $this->db->conectar();
        $query = "UPDATE $this->table SET nombre = :nombre WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':nombre' => $nombre, ':id' => $id]);
    }
    
    public function eliminar($id) {
        $conn = $this->db->conectar();
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>