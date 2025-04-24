<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Productos</h2>
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Formulario para nuevo producto -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="?action=agregar-producto" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-12">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                    </div>
                    <div class="col-12">
                        <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Seleccionar categoría</option>
                            <?php foreach($categorias as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="existencias" class="form-control" placeholder="Existencias" min="0" required>
                    </div>
                    <div class="col-12">
                        <input type="file" name="imagen" class="form-control" accept="image/png, image/jpeg" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Guardar Producto</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de productos -->
    <h3>Productos Existentes</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= htmlspecialchars($producto['codigo']) ?></td>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td><?= htmlspecialchars($producto['categoria']) ?></td>
                    <td><?= htmlspecialchars($producto['precio']) ?></td>
                    <td><?= htmlspecialchars($producto['existencias']) ?></td>
                    <td>
                        <a href="?action=editar-producto&id=<?= $producto['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="?action=eliminar-producto&id=<?= $producto['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?')">
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