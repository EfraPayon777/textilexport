<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Editar Categoría</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <form method="POST" action="?action=actualizar-categoria">
        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
        
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" 
                   value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="?action=gestion-categorias" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>