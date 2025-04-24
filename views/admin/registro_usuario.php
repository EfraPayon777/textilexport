<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Registrar Nuevo Usuario</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>

    <form method="POST" action="?action=registrar-usuario">
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Rol:</label>
            <select name="rol" class="form-select" required>
                <option value="admin">Administrador</option>
                <option value="empleado">Empleado</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="?action=gestion-usuarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>