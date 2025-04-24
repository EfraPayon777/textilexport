<?php
// Verifica si la sesión no está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario ha iniciado sesión
$isLoggedIn = isset($_SESSION['usuario']);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="?action=ver-productos">TextilExport</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> 
                <?php if (isset($_SESSION['cliente'])): ?>
                    <!-- Botón para ver el carrito -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success me-2" href="?action=ver-carrito">
                            <i class="bi bi-cart"></i> Carrito
                        </a>
                    </li>
                    <!-- Botón para cerrar sesión -->
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="?action=logout-cliente">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Botón para iniciar sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="?action=login">Login</a>
                    </li>
                    <!-- Botón para registrarse -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="?action=registro-cliente">
                            Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>