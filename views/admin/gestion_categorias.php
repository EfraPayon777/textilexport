<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Categorías</h2>
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Botón para agregar nueva categoría -->
    <a href="?action=agregar-categoria" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Nueva Categoría
    </a>

    <!-- Tabla de categorías -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                    <td>
                        <a href="?action=editar-categoria&id=<?= $categoria['id'] ?>" 
                           class="btn btn-warning btn-sm">
                           <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="?action=eliminar-categoria&id=<?= $categoria['id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('¿Eliminar esta categoría?')">
                           <i class="bi bi-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>