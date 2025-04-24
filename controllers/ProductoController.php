<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $producto;

    public function __construct() {
        $this->producto = new Producto();
    }

    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $datos = [
                    'nombre' => $_POST['nombre'],
                    'descripcion' => $_POST['descripcion'],
                    'categoria_id' => $_POST['categoria_id'],
                    'precio' => $_POST['precio'],
                    'existencias' => $_POST['existencias']
                ];
                
                $imagen = $_FILES['imagen'];
                
                if ($this->producto->crear($datos, $imagen)) {
                    $_SESSION['exito'] = "Producto agregado correctamente";
                }
                
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error de base de datos: " . $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
            }
            
            header("Location: ?action=admin-productos");
            exit();
        }
    }
    public function verProductos() {
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : null;
    
        if ($busqueda) {
            $productos = $this->producto->buscarProductos($busqueda);
        } else {
            $productos = $this->producto->listarProductos();
        }
    
        include 'views/publico/productos.php';
    }
    
}
?>