<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Agregar Nueva Categoría</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>

    <form method="POST" action="?action=crear-categoria">
        <div class="mb-3">
            <label class="form-label">Nombre de la categoría:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>