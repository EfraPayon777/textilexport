<?php include __DIR__ . '/../../partials/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Registro de Ventas</h2>

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
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?= $venta['id'] ?></td>
                    <td><?= htmlspecialchars($venta['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($venta['cliente_email']) ?></td>
                    <td><?= $venta['fecha'] ?></td>
                    <td>$<?= number_format($venta['total'], 2) ?></td>
                    <td>
                        <a href="index.php?action=ver-comprobante&id=<?= $venta['id'] ?>" 
                           class="btn btn-primary btn-sm" target="_blank">
                           <i class="bi bi-file-earmark-pdf"></i> Ver Comprobante
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>