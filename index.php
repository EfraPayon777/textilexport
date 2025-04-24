<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);
require_once __DIR__.'/controllers/AuthController.php';
require_once __DIR__.'/controllers/AdminController.php';
require_once __DIR__.'/controllers/ClienteController.php';
require_once __DIR__.'/controllers/ClienteAuthController.php';
require_once __DIR__.'/controllers/CategoriaController.php';
require_once __DIR__.'/controllers/ProductoController.php'; 
require_once __DIR__.'/controllers/CarritoController.php';

$action = $_GET['action'] ?? 'inicio';
$admin = new AdminController();
switch($action) {
    case 'login':
        $auth = new AuthController();   
        $auth->login();   
        break;
    case 'admin-productos':
        $admin = new AdminController();
        $admin->gestionProductos();
        break;
    case 'registro-cliente':
        $clienteController = new ClienteController();
        $clienteController->mostrarRegistro();
        break;
    case 'registrar-cliente':
        $clienteController = new ClienteController();
        $clienteController->registrarCliente();
        break;
    case 'registrar-empleado':
        $admin = new AdminController();
        $admin->registrarEmpleado();
        break;
    case 'logout-cliente':
        $clienteAuth = new ClienteAuthController();
        $clienteAuth->logout();
        break;
    case 'login-cliente':
        $clienteAuth = new ClienteAuthController();
        $clienteAuth->login();
        break;
    case 'productos':
        require_once __DIR__ . '/views/publico/productos.php';
        break;
    case 'agregar-producto':
        $productoController = new ProductoController();
        $productoController->agregar();
        break;
    case 'agregar-categoria':
        $catController = new CategoriaController();       
        $catController->mostrarFormulario();       
        break;             
    case 'crear-categoria':       
        $catController = new CategoriaController();      
        $catController->crearCategoria();       
        break;
    case 'editar-categoria':
        $admin = new AdminController();
        $admin->mostrarEditarCategoria();
        break;  
    case 'actualizar-categoria':
        $admin = new AdminController();
        $admin->actualizarCategoria();
        break;  
    case 'eliminar-categoria':
        $admin = new AdminController();
        $admin->eliminarCategoria();
        break;
    case 'gestion-categorias':
        $admin = new AdminController();
        $admin->gestionCategorias();
        break;
    case 'editar-producto':
        $admin = new AdminController();
        $admin->mostrarEditarProducto();
        break;

    case 'actualizar-producto':
        $admin = new AdminController();
        $admin->actualizarProducto();
        break;

    case 'registrar-usuario':
        $admin = new AdminController();
        $admin->registrarUsuario();
        break;   
    case 'registro-usuario':
        $admin = new AdminController();
        $admin->mostrarRegistroUsuario();
        break;
    case 'eliminar-producto':
        $admin = new AdminController();
        $admin->eliminarProducto();
        break;
    case 'gestion-usuarios':
        $admin = new AdminController();
        $admin->gestionUsuarios();
        break;
    case 'editar-usuario':
        $admin = new AdminController();
        $admin->mostrarEditarUsuario();
        break;
    case 'actualizar-usuario':
        $admin = new AdminController();
        $admin->actualizarUsuario();
        break;
    case 'eliminar-usuario':
        $admin = new AdminController();
        $admin->eliminarUsuario();
        break;
    case 'gestion-clientes':
        $admin->gestionClientes();
        break;
    case 'editar-cliente':
        $admin->mostrarEditarCliente();
        break;
    case 'actualizar-cliente':
        $admin->actualizarCliente();
        break;
    case 'cambiar-estado-cliente':
        $admin->cambiarEstadoCliente();
        break;
    case 'dashboard':
        $admin = new AdminController();
        $admin->dashboard();
        break;    
    case 'agregar-carrito':
        $carritoController = new CarritoController();
        $carritoController->agregarAlCarrito();
        break;
    case 'eliminar-producto-carrito':
        $carritoController = new CarritoController();
        $carritoController->eliminarProducto();
        break;
    case 'vaciar-carrito':
        $carritoController = new CarritoController();
        $carritoController->vaciarCarrito();
        break;
    case 'ver-carrito':
        $carritoController = new CarritoController();
        $carritoController->verCarrito();
        break;
        
    case 'procesar-compra':
        $carritoController = new CarritoController();
        $carritoController->procesarCompra();
        break;      
    case 'registro-ventas':
        $admin = new AdminController();
        $admin->verRegistroVentas();
        break;
    
    case 'ver-comprobante':
        $admin = new AdminController();
        $admin->verComprobante();
        break;
    default:
        require_once 'views/publico/productos.php';
        break;
}

?>