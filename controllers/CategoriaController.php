<?php
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController {
    private $categoria;

    public function __construct() {
        $this->categoria = new Categoria();
    }

    // Mostrar formulario de creación
    public function mostrarFormulario() {
        require_once __DIR__ . '/../views/admin/agregar_categoria.php';
    }

    public function crearCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            if (!empty($nombre)) {
                $this->categoria->crear($nombre);
                $_SESSION['exito'] = "Categoría creada exitosamente";
            } else {
                $_SESSION['error'] = "El nombre no puede estar vacío";
            }
            header("Location: ?action=gestion-categorias");
            exit();
        }
    }
}
?>