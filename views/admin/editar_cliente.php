<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Editar Cliente</h2>
    
    <form method="POST" action="?action=actualizar-cliente">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
        
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" 
                   value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($cliente['email']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Dirección:</label>
            <textarea name="direccion" class="form-control" required><?= htmlspecialchars($cliente['direccion']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" 
                   value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="?action=gestion-clientes" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>