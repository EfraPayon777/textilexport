<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - TextilExport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/estilo.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TextilExport Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?action=admin-productos">Productos</a>
                    </li>
                    <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=gestion-categorias">Categorías</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=gestion-usuarios">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=gestion-clientes">Clientes</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=registro-ventas">Registro de Ventas</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <?= $_SESSION['usuario']['email'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?action=logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="?action=dashboard">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=admin-productos">
                                Gestión de Productos
                            </a>
                        </li>
                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=gestion-categorias">
                                    Gestión de Categorías
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=gestion-usuarios">
                                    Gestión de Usuarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?action=gestion-clientes">
                                    Gestión de Clientes
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=registro-ventas">
                                Registro de Ventas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">