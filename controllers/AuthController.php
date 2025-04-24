<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Cliente.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo = $_POST['tipo'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            if ($tipo === 'cliente') {
                $clienteModel = new Cliente();
                $cliente = $clienteModel->login($email, $password);
  
                if ($cliente) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();             
                    }

                    $_SESSION['cliente'] = [
                        'id' => $cliente['id'],
                        'nombre' => $cliente['nombre'],
                        'email' => $cliente['email']
                    ];

                    header("Location: ?action=productos");
                    exit();
                } else {
                    $error = "Credenciales inválidas para cliente";
                }
            } else {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->login($email, $password);
                
                if ($usuario) {
                    session_start();
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'email' => $usuario['email'],
                        'rol' => $usuario['rol']
                    ];
                    header("Location: ?action=admin-productos");
                    exit();
                } else {
                    $error = "Credenciales inválidas para administrador";
                }
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }
}
?>