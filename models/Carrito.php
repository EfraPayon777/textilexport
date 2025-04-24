<?php
require_once __DIR__ . '/../config/Database.php';

class Carrito {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    // Crear carrito para cliente
    public function crearCarrito($cliente_id) {
        $conn = $this->db->conectar();
        $query = "INSERT INTO carritos (cliente_id) VALUES (?)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$cliente_id]);
    }

    // Agregar producto al carrito
    public function agregarProducto($carrito_id, $producto_id, $cantidad) {
        $conn = $this->db->conectar();
        $query = "INSERT INTO detalle_carrito (carrito_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$carrito_id, $producto_id, $cantidad]);
    }

    // Obtener carrito activo del cliente
    public function obtenerCarritoActivo($cliente_id) {
        $conn = $this->db->conectar();
        $query = "SELECT * FROM carritos WHERE cliente_id = ? ORDER BY creado_en DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([$cliente_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("Carrito activo para cliente $cliente_id: " . print_r($result, true));     
        return $result;
    }

    // Obtener detalles del carrito
    public function obtenerDetalles($carrito_id) {
        $conn = $this->db->conectar();
        $query = "SELECT p.*, dc.cantidad 
                FROM detalle_carrito dc 
                JOIN productos p ON dc.producto_id = p.id 
                WHERE dc.carrito_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$carrito_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminarProducto($carrito_id, $producto_id) {

        $conn = $this->db->conectar();
        $query = "DELETE FROM detalle_carrito 
                 WHERE carrito_id = ? 
                 AND producto_id = ?";
        $stmt = $conn->prepare($query);
    
        return $stmt->execute([$carrito_id, $producto_id]);
    
    }

    public function vaciarCarrito($carrito_id) {
        $conn = $this->db->conectar();
        $query = "DELETE FROM detalle_carrito WHERE carrito_id = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$carrito_id]);
    }
}
?>