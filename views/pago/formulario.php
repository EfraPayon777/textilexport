<form method="POST">
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
    </div>
    <div>
        <label>Dirección:</label>
        <input type="text" name="direccion" required>
    </div>
    <div>
        <label>Método de Pago:</label>
        <select name="metodo_pago" required>
            <option value="tarjeta">Tarjeta de Crédito</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>
    <button type="submit">Pagar</button>
</form>
