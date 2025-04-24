<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['email']) ?></h2>
    
    <div class="row mt-4">
        <!--Tarjeta de Productos-->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Productos en Inventario</h5>
                    <p class="card-text"><?= $totalProductos ?></p>
                    <a href="?action=admin-productos" class="text-white">Ver Productos</a>
                </div>
            </div>
        </div>
        
        <!--Tarjeta de Ventas del Mes-->
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Ventas del Mes</h5>
                    <p class="card-text">$<?= number_format($ventasMes, 2) ?></p>
                    <a href="?action=registro-ventas" class="text-white">Ver Ventas</a>
                </div>
            </div>
        </div>

        <!--Tarjeta de Total de Ventas-->
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Total de Ventas</h5>
                    <p class="card-text">$<?= number_format($totalVentas, 2) ?></p>
                    <a href="?action=registro-ventas" class="text-dark">Ver Detalles</a>
                </div>
            </div>
        </div>

        <!--Tarjeta de Número de Ventas-->
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Número de Ventas</h5>
                    <p class="card-text"><?= $numeroVentas ?></p>
                    <a href="?action=registro-ventas" class="text-white">Ver Detalles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>