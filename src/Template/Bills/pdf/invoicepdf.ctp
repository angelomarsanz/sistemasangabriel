<style>
    body
    {
        font-size: 30px;
    }
    .alignRight
    {
    	text-align: right;
    }
    hr
    {
    	color: #47476b;
    }
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
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
</style>
<?php if ($accountService == 0): ?>
<br />
<br />
<br />
<br />
<br />
<div style="font-size: 25px; line-height: 25px;">
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Cliente: <?= $bill->client ?></td>
                <td style="text-align: right;"><b>Factura Nro. <?= $bill->bill_number ?></b></td>
            </tr>
            <tr>
                <td>C.I./RIF: <?= $bill->identification ?></td>
                <td style="text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
            </tr>
            <tr>
                <td>Teléfono: <?= $bill->tax_phone ?></td>
                <td style="text-align: right;"><?= $bill->school_year ?></td>
            </tr>
            <tr>
                <td>Dirección: <spam style="font-size: 20px;"><?= $bill->fiscal_address ?></spam></td>
            </tr>
        </tbody>
    </table>
</div>
<hr size="3" />
<div>
    <table style="width:100%; font-size: 25px; line-height: 25px;">
        <thead>
            <tr>
                <th style="width:10%; text-align:left;">Código</th>
                <th style="width:70%; text-align:left;">Descripción</th>
                <th style="width:20%; text-align:right;">Precio Bs.F</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 0;
            foreach ($vConcepts as $vConcept): ?>
                <tr>
                    <td><?= h($vConcept['accountingCode']) ?></td>
                    <td><?= h($vConcept['invoiceLine']) ?></td>
                    <td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
                </tr>
                
            <?php
            $counter++;
            endforeach; ?>
        </tbody>
    </table>
</div>
<hr size="3" />
<div style="width:100%;">
    <div id="payments" style="font-size: 15px;  line-height: 15px;">
        <b>Formas de pago:</b>
        <table style="width:100%;">
            <tbody>
                <?php foreach ($aPayments as $aPayment): ?>
                    <tr>
                        <td><?= h($aPayment->payment_type) ?></td>
                        <td><?= h($aPayment->account_or_card) ?></td>
                        <td><?= h($aPayment->serial) ?></td>
                        <td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="emptyColumn">
    &nbsp;
    </div>
    <div id="total" style="font-size: 25px; line-height: 25px;">
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
                <td style="width: 50%;"><b>Total Bs.F:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
            </tr>
            <tr>
                <td style="width: 50%;"><b>Total Bs.S:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid/1000), 2, ",", ".") ?></b></td>
            </tr>
        </table>
    </div>
</div>
<?php
$countSubtraction = 16 - $counter;
for ($i = 1; $i <= $countSubtraction; $i++): ?>
    <br />
<?php
endfor; ?>
<div style="font-size: 25px; line-height: 25px;">
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Cliente: <?= $bill->client ?> </td>
                <td style="text-align: right;"><b>Factura Nro. <?= $bill->bill_number ?></b></td>
            </tr>
            <tr>
                <td>C.I./RIF: <?= $bill->identification ?></td>
                <td style="text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
            </tr>
            <tr>
                <td>Teléfono: <?= $bill->tax_phone ?></td>
                <td style="text-align: right;"><?= $bill->school_year ?></td>
            </tr>
            <tr>
                <td>Dirección: <spam style="font-size: 20px;"><?= $bill->fiscal_address ?></spam></td>
            </tr>
        </tbody>
    </table>
</div>
<hr size="3" />
<div>
    <table style="width:100%; font-size: 25px; line-height: 25px;">
        <thead>
            <tr>
                <th style="width:10%; text-align:left;">Código</th>
                <th style="width:70%; text-align:left;">Descripción</th>
                <th style="width:20%; text-align:right;">Precio Bs.F</th>
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
<hr size="3" />
<div style="width:100%;">
    <div id="payments" style="font-size: 15px;  line-height: 15px;">
        <b>Formas de pago:</b>
        <table style="width:100%;">
            <tbody>
                <?php foreach ($aPayments as $aPayment): ?>
                    <tr>
                        <td><?= h($aPayment->payment_type) ?></td>
                        <td><?= h($aPayment->account_or_card) ?></td>
                        <td><?= h($aPayment->serial) ?></td>
                        <td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="emptyColumn">
    &nbsp;
    </div>
    <div id="total" style="font-size: 25px; line-height: 25px;">
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
                <td style="width: 50%;"><b>Total Bs.F:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
            </tr>
            <tr>
                <td style="width: 50%;"><b>Total Bs.S:</b></td>
                <td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid/1000), 2, ",", ".") ?></b></td>
            </tr>
        </table>
    </div>
</div>
<?php else: ?>
<div>
    <h3 style="text-align: right;">Recibo Nro. <?= $bill->bill_number ?></h3>
    <h2 style="text-align: center;">Por Bs.F <?= number_format($accountService, 2, ",", ".") ?></h2>
	<h2 style="text-align: center;">Por Bs.S <?= number_format(($accountService/1000), 2, ",", ".") ?></h2>
    <br />
    <p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.F <b><?= number_format($accountService, 2, ",", ".") ?></b>
    por concepto de servicio educativo, correspondiente a lo(s) alumno(s):</p>
    <table style="width:100%;">
        <tbody>
            <?php foreach ($studentReceipt as $studentReceipts): ?>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;- <?= h($studentReceipts['studentName']) ?></td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>