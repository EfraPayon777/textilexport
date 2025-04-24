<?php
if (session_status() === PHP_SESSION_NONE) {

    session_start();

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TextilExport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body class="bg-light">
    <?php include __DIR__ . '/navbar-publico.php'; ?> 
    <div class="container mt-4"> 