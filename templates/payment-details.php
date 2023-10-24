<div>
    <h3>Detalles de Pago</h3>
    <p>Por favor, ingresa los detalles de tu tarjeta de crédito o debito:</p>
    <table id="agilpay-app">
        <tr>
            <th>
                <label for="agilpay_card_number">Número de Tarjeta:</label>
            </th>
            <td>
                <input type="text" id="agilpay_card_number" name="agilpay_card_number" placeholder="XXXX-XXXX-XXXX-XXXX" required style="width:100%"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="agilpay_card_expiry">Fecha de Expiración:</label>
            </th>
            <td>
                <input type="text" id="agilpay_card_expiry" name="agilpay_card_expiry" placeholder="MM/AA" required style="width:100%"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="agilpay_card_cvv">CVV:</label>
            </th>
            <td>
                <input type="text" id="agilpay_card_cvv" name="agilpay_card_cvv" placeholder="000" max="999" min="0" required style="width:100%"/>
            </td>
        </tr>
    </table>
</div>