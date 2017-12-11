<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<div>
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Unidad Educativa Colegio</td>
            </tr>
            <tr>
                <td><b>"San Gabriel Arcángel"</b></td>
            </tr>
        </tbody>
    </table>
</div>
<br />
<div style="width: 100%; text-align: center;">
    <h4>Libro de Ventas: <?= $nameOfTheMonth . ', ' . $year ?></h4>
</div>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">Factura</th>
                <th style="text-align: center;">Fecha</th>
                <th style="text-align: center;">C.I./RIF</th>
                <th style="text-align: center;">Cliente</th>
                <th style="text-align: center;">Dirección</th>
                <th style="text-align: center;">Teléfono</th>
                <th style="text-align: center;">Sub-total</th>
                <th style="text-align: center;">IVA 0%</th>
                <th style="text-align: center;">Total</th>
                <th style="text-align: center;">Anulada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td style="text-align: center;"><?= h($venta->bill_number) ?></td>
                    <td style="text-align: center;"><?= h($venta->date_and_time->format('d-m-Y')) ?></td>
                    <td style="text-align: center;"><?= h($venta->identification) ?></td>
                    <td style="text-align: center;"><?= h($venta->client) ?></td>
                    <td style="text-align: center;"><?= h($venta->fiscal_address) ?></td>
                    <td style="text-align: center;"><?= h($venta->tax_phone) ?></td>
                    <td style="text-align: right;"><?= h(number_format($venta->amount, 2, ",", ".")) ?></td>
                    <td style="text-align: right;">0,00</td>
                    <td style="text-align: right;"><?= h(number_format($venta->amount, 2, ",", ".")) ?></td>
                    <td style="text-align: center;">
                        <?php
                            if ($venta->annulled== false)
                            {
                                echo "No";
                            }    
                            else
                            {
                                echo "Sí";
                            }
                        ?></td>
                </tr>                    
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Totales: </th>
                <th style="text-align: right;"><?= number_format($totalAmount, 2, ",", ".") ?></th>
                <th style="text-align: right;">0,00</th>
                <th style="text-align: right;"><?= number_format($totalAmount, 2, ",", ".") ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>  
</div>
<br />
<br />
<div style="font-size: 20px;">
    <table style="width:100%">
        <tbody>
            <tr>
                <td style="width:75%;">&nbsp;</td>
                <td style="width:15%;">Sub-total facturas efectivas:</td>
                <td style="width:10%; text-align: right;"><?= number_format($effectiveAmount, 2, ",", ".") ?></td>
            </tr>
            <tr>
                <td style="width:75%;">&nbsp;</td>
                <td style="width:15%;">Sub-total facturas anuladas:</td>
                <td style="width:10%; text-align: right;"><?= number_format($amountCanceled, 2, ",", ".") ?></td>
            </tr>
            <tr>
                <td style="width:75%;">&nbsp;</td>
                <td style="width:15%;">Total general facturas:</td>
                <td style="width:10%; text-align: right;"><?= number_format($totalAmount, 2, ",", ".") ?></td>
            </tr>
        </tbody>
    </table>
</div>