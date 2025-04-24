<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../utils/validaciones.php';

class ClienteController {
    private $cliente;

    public function __construct() {
        $this->cliente = new Cliente();
    }

    public function mostrarRegistro() {
        require_once __DIR__ . '/../views/auth/registro-cliente.php';
    }

    public function registrarCliente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'direccion' => trim($_POST['direccion']),
                'telefono' => trim($_POST['telefono'])
            ];

            $errores = [];

            if (!isText($datos['nombre'])) {
                $errores[] = "El nombre no es válido. Solo se permiten letras y espacios.";
            }

            if (!isPhone($datos['telefono'])) {
                $errores[] = "El teléfono debe tener el formato correcto (por ejemplo: 7000-0000).";
            }

            if (!isMail($datos['email'])) {
                $errores[] = "El correo electrónico no es válido.";
            }

            if (empty($datos['password'])) {
                $errores[] = "La contraseña no puede estar vacía.";
            }

            if (empty($errores)) {
                if ($this->cliente->registrar($datos)) {
                    $cliente = $this->cliente->login($datos['email'], $datos['password']);
                    if ($cliente) {
                        // Crear carrito
                        $carrito = new Carrito();
                        $carrito->crearCarrito($cliente['id']);
                    }

                    header('Location: ?action=login-cliente&registro=exito');
                    exit();
                } else {
                    $error = "El email ya está registrado";
                    require_once __DIR__ . '/../views/auth/registro-cliente.php';
                }
            } else {
                // Enviar errores a la vista
                $error = implode("<br>", $errores);
                require_once __DIR__ . '/../views/auth/registro-cliente.php';
            }
        }
    }
}
