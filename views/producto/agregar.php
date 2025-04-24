<?php include __DIR__ . '/../../partials/header-publico.php'; ?>

<div class="container mt-5">
    <h2>Agregar Nuevo Producto</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código:</label>
            <input type="text" class="form-control" name="codigo" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría:</label>
            <select class="form-control" name="categoria_id" required>
                <option value="1">PruebaCategoria   1</option>
                <option value="2">PruebaCategoria 2</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="existencias" class="form-label">Existencias:</label>
            <input type="number" class="form-control" name="existencias" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen:</label>
            <input type="file" class="form-control" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>