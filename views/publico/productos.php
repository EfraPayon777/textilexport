<?php
if (isset($_SESSION['exito'])): ?>
    <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
    <?php unset($_SESSION['exito']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php
// Admin/empleado logueado
if (isset($_SESSION['usuario'])) { 

    include __DIR__ . '/../../partials/admin-header.php';

} else { // Cliente o público

    include __DIR__ . '/../../partials/header-publico.php';

}

//Obtener productos
$producto = new Producto();

if (isset($_GET['busqueda']) && !empty(trim($_GET['busqueda']))) {
    $productos = $producto->buscarProductos($_GET['busqueda']);
} else {
    $productos = $producto->obtenerTodos();
}

?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Nuestros Productos</h1>

    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar productos..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach($productos as $p): ?>
    <div class="col">
        <div class="card h-100 shadow">
            <div class="card-img-top-container" style="height: 200px; overflow: hidden;"> 
                <img src="../assets/img/productos/<?= $p['imagen'] ?>" 
                     class="card-img-top product-image" 
                     alt="<?= $p['nombre'] ?>" 
                     style="width: 100%; height: 100%; object-fit: contain;"> 
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $p['nombre'] ?></h5>
                <p class="card-text text-truncate" style="max-height: 60px; overflow: hidden;">
                    <?= htmlspecialchars($p['descripcion']) ?>
                </p>
                <p class="card-text">
                    <strong>Existencias:</strong> <?= $p['existencias'] ?>
                </p>
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary">$<?= number_format($p['precio'], 2) ?></span>
                        <?php if ($p['existencias'] > 0): ?>
                            <form method="POST" action="?action=agregar-carrito">
                                <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                                <div class="input-group">
                                    <input type="number" name="cantidad" value="1" min="1" max="<?= $p['existencias'] ?>" class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Añadir
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <span class="text-danger">Sin existencias</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>