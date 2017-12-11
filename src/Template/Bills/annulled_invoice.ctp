<style>
#payments
{
	width: 25%;
	float: left;
}
#emptyColumn
{
	width: 50%;
	float: left;
}
#total
{
	width: 25%;
	float: left;
}
</style>
<div>
    <h3 style="width:100%; text-align: center;">Factura Anulada Nro. <?= $bill->bill_number ?></h3>
    <table style="width:100%">
        <tbody>
            <tr>
                <td style="width: 80%;">Cliente: <?= $bill->client ?></td>
                <td style="width: 20%;"><b>Factura Nro. <?= $bill->bill_number ?></b></td>
            </tr>
            <tr>
                <td style="width: 80%;">C.I./RIF: <?= $bill->identification ?></td>
                <td style="width: 20%;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
            </tr>
            <tr>
                <td style="width: 80%;">Teléfono: <?= $bill->tax_phone ?></td>
                <td style="width: 20%;">Año escolar 2016-2017</td>
            </tr>
            <tr>
                <td style="width: 80%;">Dirección: <?= $bill->fiscal_address ?></td>
            </tr>
        </tbody>
    </table>
</div>
<hr size="4" />
<div>
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:10%; text-align:left;">Código</th>
                <th style="width:70%; text-align:left;">Descripción</th>
                <th style="width:20%; text-align:right;">Precio total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vConcepts as $vConcept): ?>
                <tr>
                    <td><?= h($vConcept['accountingCode']) ?></td>
                    <td><?= h($vConcept['invoiceLine']) ?></td>
                    <td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<hr size="4" />
<div style="width:100%;">
    <div id="payments" style="font-size: 15px;">
        <b>Formas de pago:</b>
        <table style="width:100%;">
            <tbody>
                <?php foreach ($aPayments as $aPayment): ?>
                    <tr>
                        <td><?= h($aPayment->payment_type) ?></td>
                        <td><?= h($aPayment->account_or_card) ?></td>
                        <td><?= h($aPayment->serial) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="emptyColumn">
    &nbsp;
    </div>
    <div id="total">
        <table style="width:100%;">
            <tr>
                <td style="width: 50%;"><b>Sub-total:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
            </tr>
            <tr>
                <td style="width: 50%;"><b>IVA 0%:</b></td>
                <td style="width: 50%;"><b></b></td>
            </tr>
            <tr>
                <td style="width: 50%;"><b>Total:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
            </tr>
        </table>
    </div>
</div>