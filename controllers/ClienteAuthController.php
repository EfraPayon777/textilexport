<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteAuthController {
    private $cliente;

    public function __construct() {
        $this->cliente = new Cliente();
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cliente = $this->cliente->login($email, $password);

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
                $error = "Credenciales incorrectas";
                require_once __DIR__ . '/../views/auth/login.php';
            }

        } else {
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['cliente']); 
        session_destroy();
        header("Location: index.php?action=productos");
        exit();
    }
}