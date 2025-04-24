<?php

class Venta {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function crearVenta($cliente_id, $detalles) {
        $conn = $this->db->conectar();

        try {
            $conn->beginTransaction();
            $query = "INSERT INTO ventas (cliente_id, total) VALUES (?, ?)";
            $total = array_reduce($detalles, function($sum, $item) {
                return $sum + ($item['precio'] * $item['cantidad']);
            }, 0);

            $stmt = $conn->prepare($query);
            $stmt->execute([$cliente_id, $total]);
            $venta_id = $conn->lastInsertId();

            $queryDetalle = "INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio_unitario) 
                             VALUES (?, ?, ?, ?)";
            foreach ($detalles as $item) {
                $stmtDetalle = $conn->prepare($queryDetalle);
                $stmtDetalle->execute([
                    $venta_id,
                    $item['id'],
                    $item['cantidad'],
                    $item['precio']
                ]);
                 // Actualizar las existencias del producto
            $queryActualizarExistencias = "UPDATE productos SET existencias = existencias - :cantidad WHERE id = :producto_id";
            $stmtActualizar = $conn->prepare($queryActualizarExistencias);
            $stmtActualizar->execute([
                ':cantidad' => $item['cantidad'],
                ':producto_id' => $item['id']
            ]);
            }

            $conn->commit();
            return $venta_id;

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function obtenerTodasLasVentas() {
        $conn = $this->db->conectar();
        $query = "SELECT v.id, v.fecha, v.total, c.nombre AS cliente_nombre, c.email AS cliente_email
                  FROM ventas v
                  JOIN clientes c ON v.cliente_id = c.id
                  ORDER BY v.fecha DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVentaPorId($ventaId) {
        $conn = $this->db->conectar();
        $query = "SELECT v.id, v.fecha, v.total, c.nombre AS cliente_nombre, c.email AS cliente_email
                  FROM ventas v
                  JOIN clientes c ON v.cliente_id = c.id
                  WHERE v.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$ventaId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     //Obtener el total de ventas del mes actual
     public function obtenerVentasMes() {
        $conn = $this->db->conectar();
        $query = "SELECT COALESCE(SUM(total), 0) as ventas_mes 
                  FROM ventas 
                  WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                  AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $stmt = $conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['ventas_mes'];
    }

    //Obtener el total acumulado de todas las ventas
    public function obtenerTotalVentas() {
        $conn = $this->db->conectar();
        $query = "SELECT COALESCE(SUM(total), 0) as total_ventas FROM ventas";
        $stmt = $conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_ventas'];
    }

    //Obtener el número total de ventas realizadas
    public function obtenerNumeroVentas() {
        $conn = $this->db->conectar();
        $query = "SELECT COUNT(*) as numero_ventas FROM ventas";
        $stmt = $conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['numero_ventas'];
    }
    //Obtener productos de una venta
    public function obtenerProductosDeVenta($ventaId) {
        $conn = $this->db->conectar();
        $query = "SELECT p.nombre, p.precio, dv.cantidad
                  FROM detalle_venta dv
                  JOIN productos p ON dv.producto_id = p.id
                  WHERE dv.venta_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$ventaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}