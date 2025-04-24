<?php include __DIR__ . '/../../partials/header-publico.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="POST" action="?action=login">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Usuario:</label>
                            <select class="form-select" name="tipo" required>
                                <option value="cliente">Cliente</option>
                                <option value="empleado">Empleado/Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

    <?= $_SESSION['error'] ?>

    <?php unset($_SESSION['error']); ?>

</div>

<?php endif; ?>
<?php include __DIR__ . '/../../partials/footer.php'; ?>