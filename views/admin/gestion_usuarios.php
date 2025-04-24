<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Usuarios</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>

    <a href="?action=registro-usuario" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Nuevo Usuario
    </a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= ucfirst($usuario['rol']) ?></td>
                    <td>
                        <a href="?action=editar-usuario&id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="?action=eliminar-usuario&id=<?= $usuario['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar este usuario?')">
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