<table>
    <tr>
        <th>ID Pedido</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Total</th>
    </tr>
    <?php foreach ($pedidos as $pedido): ?>
    <tr>
        <td><?= $pedido['id'] ?></td> 
        <td><?= $pedido['fecha'] ?></td> 
        <td><?= $pedido['estado'] ?></td> 
        <td><?= $pedido['total'] ?></td> 
    </tr>
    <?php endforeach; ?>
</table>