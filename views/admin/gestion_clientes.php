<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Clientes</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente['id'] ?></td>
                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                    <td>
                        <?php if ($cliente['habilitado']): ?>
                            <span class="badge bg-success">Habilitado</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inhabilitado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?action=editar-cliente&id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="?action=cambiar-estado-cliente&id=<?= $cliente['id'] ?>&habilitado=<?= $cliente['habilitado'] ? 0 : 1 ?>" 
                           class="btn btn-<?= $cliente['habilitado'] ? 'danger' : 'success' ?> btn-sm">
                           <i class="bi bi-<?= $cliente['habilitado'] ? 'x-circle' : 'check-circle' ?>"></i> 
                           <?= $cliente['habilitado'] ? 'Inhabilitar' : 'Habilitar' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>