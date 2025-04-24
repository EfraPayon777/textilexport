<?php
require_once __DIR__ . '/../models/Producto.php';  
require_once __DIR__ . '/../models/Categoria.php'; 
require_once __DIR__ . '/../models/Usuario.php'; 
require_once __DIR__ . '/../models/Cliente.php';

class AdminController {
    private $producto;
    private $categoria;
    private $usuario;
    public function __construct() {
        $this->producto = new Producto();
        $this->categoria = new Categoria();
        $this->usuario = new Usuario();
    }

    public function dashboard() {
        $this->verificarSesion();
    
        //Obtener datos para el dashboard
        $totalProductos = $this->producto->obtenerTotal();
    
        $ventaModel = new Venta();
        //Total de ventas del mes actual
        $ventasMes = $ventaModel->obtenerVentasMes(); 
        //Total acumulado de todas las ventas
        $totalVentas = $ventaModel->obtenerTotalVentas(); 
        //Número total de ventas realizadas
        $numeroVentas = $ventaModel->obtenerNumeroVentas(); 
    
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    //GESTIÓN DE PRODUCTOS
    public function gestionProductos() {
        $this->verificarSesion();
        $productos = $this->producto->obtenerTodos();
        $categorias = $this->categoria->obtenerTodas();
        require_once __DIR__ . '/../views/admin/productos.php';
    }

    //GESTIÓN DE CATEGORÍAS
    public function gestionCategorias() {
        $this->verificarSesion();
        $categorias = (new Categoria())->obtenerTodas();
        require_once __DIR__ . '/../views/admin/gestion_categorias.php';
    }

    //GESTIÓN DE USUARIOS
    public function gestionUsuarios() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
        
        $usuarios = $this->usuario->obtenerTodos();
        require_once __DIR__ . '/../views/admin/gestion_usuarios.php';
    }

    public function mostrarRegistroUsuario() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
        require_once __DIR__ . '/../views/admin/registro_usuario.php';
    }

    public function registrarUsuario() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $rol = $_POST['rol'];
            
            $usuario = new Usuario();
            if ($usuario->registrar($email, $password, $rol)) {
                $_SESSION['exito'] = "Usuario registrado exitosamente";
            } else {
                $_SESSION['error'] = "Error: El email ya está registrado";
            }
            
            header("Location: ?action=gestion-usuarios");
            exit();
        }
    }

    public function mostrarEditarUsuario() {
        $this->verificarSesion();
        
        $usuario = (new Usuario())->obtenerPorId($_GET['id']);
        
        if (!$usuario) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: ?action=gestion-usuarios");
            exit();
        }
        
        require_once __DIR__ . '/../views/admin/editar_usuario.php';
    }

    public function actualizarUsuario() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];
            
            if ((new Usuario())->actualizar($id, $email, $rol)) {
                $_SESSION['exito'] = "Usuario actualizado correctamente";
            } else {
                $_SESSION['error'] = "Error al actualizar usuario";
            }
            
            header("Location: ?action=gestion-usuarios");
            exit();
        }
    }

    public function eliminarUsuario() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
        
        if ((new Usuario())->eliminar($_GET['id'])) {
            $_SESSION['exito'] = "Usuario eliminado correctamente";
        } else {
            $_SESSION['error'] = "Error al eliminar usuario";
        }
        
        header("Location: ?action=gestion-usuarios");
        exit();
    }

    // VERIFICACIONES
    private function verificarSesion() {
       
        if (session_status() === PHP_SESSION_NONE) {

            session_start(); // Solo inicia si no existe
    
        }
        if (!isset($_SESSION['usuario'])) {

            header('Location: ../index.php');
    
            exit();
    
        }
    
         // Acciones permitidas para empleados
    $accionesPermitidas = [
        'dashboard',
        'admin-productos', 
        'ventas',
        'editar-producto',    
        'actualizar-producto',
        'eliminar-producto',
        'registro-ventas',
        'ver-comprobante'
    ];

    if ($_SESSION['usuario']['rol'] === 'empleado' 
        && !in_array($_GET['action'] ?? '', $accionesPermitidas)) {
        header('Location: ?action=admin-productos');
        exit();
    }
    }

    private function verificarRolAdministrador() {
        if ($_SESSION['usuario']['rol'] !== 'admin') {

            $_SESSION['error'] = "Acceso restringido a administradores";
    
            header("Location: ?action=dashboard");
    
            exit();
    
        }
         
    }

    // MÉTODOS PARA PRODUCTOS Y CATEGORÍAS
    public function mostrarEditarCategoria() {
        $this->verificarSesion();
        $categoria = (new Categoria())->obtenerPorId($_GET['id']);
        if (!$categoria) {
            $_SESSION['error'] = "Categoría no encontrada";
            header("Location: ?action=gestion-categorias");
            exit();
        }
        require_once __DIR__ . '/../views/admin/editar_categoria.php';
    }
    
    public function actualizarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            
            if (!empty($nombre)) {
                (new Categoria())->actualizar($id, $nombre);
                $_SESSION['exito'] = "Categoría actualizada correctamente";
            } else {
                $_SESSION['error'] = "El nombre no puede estar vacío";
            }
            
            header("Location: ?action=gestion-categorias");
            exit();
        }
    }
    
    public function eliminarCategoria() {
        $this->verificarSesion();
        
        if ((new Categoria())->eliminar($_GET['id'])) {
            $_SESSION['exito'] = "Categoría eliminada correctamente";
        } else {
            $_SESSION['error'] = "Error al eliminar la categoría";
        }
        
        header("Location: ?action=gestion-categorias");
        exit();
    }

    public function mostrarEditarProducto() {
        $this->verificarSesion();
        
        $producto = (new Producto())->obtenerPorId($_GET['id']);
        
        if (!$producto) {
            $_SESSION['error'] = "Producto no encontrado";
            header("Location: ?action=admin-productos");
            exit();
        }
        
        $categorias = (new Categoria())->obtenerTodas();
        
        require_once __DIR__ . '/../views/admin/editar_producto.php';
    }

    public function actualizarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $datos = [
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'categoria_id' => $_POST['categoria_id'],
                'precio' => $_POST['precio'],
                'existencias' => $_POST['existencias']
            ];
            
            $imagen = $_FILES['imagen']['size'] > 0 ? $_FILES['imagen'] : null;
            
            if ((new Producto())->actualizar($id, $datos, $imagen)) {
                $_SESSION['exito'] = "Producto actualizado";
            } else {
                $_SESSION['error'] = "Error al actualizar";
            }
            
            header("Location: ?action=admin-productos");
            exit();
        }
    }
    
    public function eliminarProducto() {
        $this->verificarSesion();
        
        if ((new Producto())->eliminar($_GET['id'])) {
            $_SESSION['exito'] = "Producto eliminado correctamente";
        } else {
            $_SESSION['error'] = "Error al eliminar el producto";
        }
        
        header("Location: ?action=admin-productos");
        exit();
    }
    public function ventas() {

        $this->verificarSesion();
        $ventas = (new Venta())->obtenerTodas();
        require_once __DIR__ . '/../views/admin/ventas.php';
    }
    
    
    public function nuevaVenta() {
    
        $this->verificarSesion();
        $clientes = (new Cliente())->obtenerTodos();
        $productos = (new Producto())->obtenerTodos();
        require_once __DIR__ . '/../views/admin/nueva_venta.php';
    }
    public function gestionClientes() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
        $clienteModel = new Cliente(); 
        $clientes = $clienteModel->obtenerTodos();
        require_once __DIR__ . '/../views/admin/gestion_clientes.php';
    
    }
    
    
    public function eliminarCliente() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
    
        if ((new Cliente())->eliminar($_GET['id'])) {
            $_SESSION['exito'] = "Cliente eliminado";
        } else {
            $_SESSION['error'] = "Error al eliminar cliente";
        }
    
        header("Location: ?action=gestion-clientes");
        exit();
    }
    public function mostrarEditarCliente() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
        
        $cliente = (new Cliente())->obtenerPorId($_GET['id']);
        
        if (!$cliente) {
            $_SESSION['error'] = "Cliente no encontrado";
            header("Location: ?action=gestion-clientes");
            exit();
        }
        
        require_once __DIR__ . '/../views/admin/editar_cliente.php';
    }
    public function actualizarCliente() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            
            $cliente = new Cliente();
            if ($cliente->actualizar($id, $nombre, $email, $direccion, $telefono)) {
                $_SESSION['exito'] = "Cliente actualizado correctamente";
            } else {
                $_SESSION['error'] = "Error al actualizar el cliente";
            }
            
            header("Location: ?action=gestion-clientes");
            exit();
        }
    }
    public function cambiarEstadoCliente() {
        $this->verificarSesion();
        $this->verificarRolAdministrador();
    
        if (isset($_GET['id']) && isset($_GET['habilitado'])) {
            $id = $_GET['id'];
            $habilitado = $_GET['habilitado'];
    
            $cliente = new Cliente();
            if ($cliente->cambiarEstado($id, $habilitado)) {
                $_SESSION['exito'] = "Estado del cliente actualizado correctamente";
            } else {
                $_SESSION['error'] = "Error al cambiar el estado del cliente";
            }
        } else {
            $_SESSION['error'] = "Parámetros inválidos";
        }
    
        header("Location: ?action=gestion-clientes");
        exit();
    }
    public function verRegistroVentas() {
        //Verifica que el usuario esté autenticado
        $this->verificarSesion();
       
    
        $ventaModel = new Venta();
        //Método para obtener todas las ventas
        $ventas = $ventaModel->obtenerTodasLasVentas(); 
    
        require_once __DIR__ . '/../views/admin/registro_ventas.php';
    }
    public function verComprobante() {
        //Verifica que el usuario esté autenticado como administrador
        $this->verificarSesion(); 
    
        if (isset($_GET['id'])) {
            $ventaId = $_GET['id'];
    
            $ventaModel = new Venta();
            $venta = $ventaModel->obtenerVentaPorId($ventaId);
            $productos = $ventaModel->obtenerProductosDeVenta($ventaId);
    
            if ($venta && $productos) {
                $carritoController = new CarritoController();
                $carritoController->generarPDF($ventaId, $productos, [
                    'nombre' => $venta['cliente_nombre'],
                    'email' => $venta['cliente_email'],
                    'fecha' => $venta['fecha']
                ]);
            } else {
                $_SESSION['error'] = "Venta no encontrada o sin productos.";
                header("Location: ?action=registro-ventas");
                exit();
            }
        } else {
            $_SESSION['error'] = "ID de venta no proporcionado.";
            header("Location: ?action=registro-ventas");
            exit();
        }
    }
}
?>