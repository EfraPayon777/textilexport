<?php include __DIR__ . '/../../partials/admin-header.php'; ?>
<div class="container mt-4">
    <h2>Editar Usuario</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="?action=actualizar-usuario">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol:</label>
            <select name="rol" class="form-select" required>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                <option value="empleado" <?= $usuario['rol'] === 'empleado' ? 'selected' : '' ?>>Empleado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="?action=gestion-usuarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>


<?php include __DIR__ . '/../../partials/footer.php'; ?>