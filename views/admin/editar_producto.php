<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Editar Producto</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <form method="POST" action="?action=actualizar-producto" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" 
                   value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Categoría:</label>
            <select name="categoria_id" class="form-select" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>" 
                        <?= $c['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" 
                   value="<?= $producto['precio'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Existencias:</label>
            <input type="number" name="existencias" class="form-control" 
                   value="<?= $producto['existencias'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Imagen Actual:</label>
            <?php if ($producto['imagen']): ?>
                <img src="../assets/img/productos/<?= $producto['imagen'] ?>" 
                     class="img-thumbnail d-block mb-2" style="max-width: 200px;">
            <?php endif; ?>
            <input type="file" name="imagen" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="?action=gestion-productos" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>