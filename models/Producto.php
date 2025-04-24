<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $db;
    private $table = 'productos';

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerTodos() {
        $conn = $this->db->conectar();
        $query = "SELECT p.*, c.nombre as categoria 
                  FROM $this->table p
                  LEFT JOIN categorias c ON p.categoria_id = c.id";
        return $conn->query($query)->fetchAll();
    }

    public function obtenerPorId($id) {

        $conn = $this->db->conectar();
        $query = "SELECT * FROM productos WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]); 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos, $imagen) {
        $conn = $this->db->conectar();
        
        try {
            $conn->beginTransaction();
            $rutaImagen = $this->subirImagen($imagen);
            //Insertar productso
            $query = "INSERT INTO productos 
                      (nombre, descripcion, imagen, categoria_id, precio, existencias) 
                      VALUES (:nombre, :descripcion, :imagen, :categoria_id, :precio, :existencias)";
            
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':imagen' => $rutaImagen,
                ':categoria_id' => $datos['categoria_id'],
                ':precio' => $datos['precio'],
                ':existencias' => $datos['existencias']
            ]);
            
            //Obtiene el id recién insertado
            $id = $conn->lastInsertId();
            
            //Genera código basado en el ID
            $codigo = 'PROD' . str_pad($id, 5, '0', STR_PAD_LEFT);
            
            //Actualizar el código en la base de datos
            $queryUpdate = "UPDATE productos SET codigo = :codigo WHERE id = :id";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->execute([':codigo' => $codigo, ':id' => $id]);
            
            $conn->commit();
            return true;
            
        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
    
    private function subirImagen($imagen) {
        if ($imagen['error'] === UPLOAD_ERR_OK) {
            $directorio = __DIR__ . '/../../assets/img/productos/';
        
            if (!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }
            
            $nombreArchivo = uniqid() . '-' . basename($imagen['name']);
            $rutaCompleta = $directorio . $nombreArchivo;
            
            if (!move_uploaded_file($imagen['tmp_name'], $rutaCompleta)) {
                throw new Exception("Error al subir la imagen");
            }
            
            return $nombreArchivo;
        }
        //Si no se sube imagen
        return null; 
    }
    
    private function obtenerProximoId() {
        $conn = $this->db->conectar();

        $stmt = $conn->query("SELECT AUTO_INCREMENT 
                              FROM information_schema.TABLES 
                              WHERE TABLE_SCHEMA = DATABASE() 
                              AND TABLE_NAME = 'productos'");
        return $stmt->fetchColumn(); 
    }

    private function obtenerUltimoId() {
        $conn = $this->db->conectar();
        return $conn->query("SELECT MAX(id) FROM productos")->fetchColumn();
    }

    public function actualizar($id, $datos, $imagen = null) {
        $conn = $this->db->conectar();

        if ($imagen) {
            $rutaImagen = $this->subirImagen($imagen);
            $query = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, 
                      imagen = :imagen, categoria_id = :categoria_id, precio = :precio, 
                      existencias = :existencias WHERE id = :id";
            $params = [
                ':imagen' => $rutaImagen,
                ':id' => $id,
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':categoria_id' => $datos['categoria_id'],
                ':precio' => $datos['precio'],
                ':existencias' => $datos['existencias']
            ];
        } else {
            $query = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, 
                      categoria_id = :categoria_id, precio = :precio, 
                      existencias = :existencias WHERE id = :id";
            $params = [
                ':id' => $id,
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':categoria_id' => $datos['categoria_id'],
                ':precio' => $datos['precio'],
                ':existencias' => $datos['existencias']
            ];
        }
    
        $stmt = $conn->prepare($query);   
        return $stmt->execute($params);
    }
    
    public function eliminar($id) {
        $conn = $this->db->conectar();
        $query = "DELETE FROM productos WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    } 

    public function obtenerTotal() {
        $conn = $this->db->conectar();
        $query = "SELECT COUNT(id) as total FROM productos";
        $stmt = $conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    } 

    public function buscarProductos($termino) {
        $conn = $this->db->conectar();
        $query = "SELECT p.*, c.nombre as categoria 
                  FROM $this->table p
                  LEFT JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.nombre LIKE :busqueda";
        $stmt = $conn->prepare($query);
        $busqueda = '%' . $termino . '%';
        $stmt->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
}
?>