<table>
    <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
    <tr>
        <td><?= $producto['nombre'] ?></td>
        <td><?= $producto['precio'] ?></td>
        <td>
            <a href="?action=editar-producto&id=<?= $producto['id'] ?>">Editar</a>
            <a href="?action=eliminar-producto&id=<?= $producto['id'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
