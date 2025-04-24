<?php include __DIR__ . '/../../partials/header-publico.php'; ?>

<div class="container mt-4">
    <h2>Tu Carrito de Compras</h2>
    
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($productos)): ?>
        <div class="alert alert-info">Tu carrito está vacío</div>
    <?php else: ?>
        <div class="mb-4">
            <a href="index.php?action=vaciar-carrito" 
               class="btn btn-danger"
               onclick="return confirm('¿Vaciar todo el carrito?')">
                <i class="bi bi-trash"></i> Vaciar Carrito
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($productos as $producto): ?>
                    <?php 
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <!-- Boton para eliminar producto -->
                            <form method="POST" action="index.php?action=eliminar-producto-carrito" style="display:inline;">
                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    <td>$<?= number_format($total, 2) ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <!-- Seccion de pago -->
        <form method="POST" action="index.php?action=procesar-compra" target="_blank">
            <div class="border p-4 mb-4">
                <h4 class="mb-3">Datos de Pago</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Número de Tarjeta</label>
                        <input type="text" class="form-control" name="tarjeta" required pattern="\d{16}" maxlength="16" placeholder="Ej: 1234567812345678" title="Debe contener exactamente 16 dígitos numéricos">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" name="cvv" required pattern="\d{3}" maxlength="3" placeholder="Ej: 123" title="Debe contener exactamente 3 dígitos numéricos">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?action=productos" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Seguir Comprando
                </a>
                
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-credit-card"></i> Realizar Pago
                </button>
            </div>
        </form>

        <form id="vaciarCarritoForm" method="POST" action="index.php?action=vaciar-carrito" style="display: none;">
        </form>

        <script>
            document.querySelector('form[action="index.php?action=procesar-compra"]').addEventListener('submit', function(event) {
                setTimeout(function() {
                    document.getElementById('vaciarCarritoForm').submit();
                }, 1000); 
            });
        </script>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
