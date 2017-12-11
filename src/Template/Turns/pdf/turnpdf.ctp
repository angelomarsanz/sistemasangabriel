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
.saltopagina
{
    display:block; 
    page-break-before:always;
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
    <h4>Cierre del turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
</div>
<b>Efectivo:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">Efectivo al inicio del turno</th>
                <th style="text-align: center;">Pagos recibidos en efectivo</th>
                <th style="text-align: center;">Total efectivo registrado en el sistema</th>
                <th style="text-align: center;">Efectivo en caja</th>
                <th style="text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->initial_cash, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->cash_received, 2, ",", ".")  ?></td>
                <td style="text-align: right;"><?= number_format(($turn->initial_cash + $turn->cash_received), 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_cash, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format((($turn->initial_cash + $turn->cash_received) - $turn->real_cash), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Tarjeta de débito:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Pagos registrados en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->debit_card_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_debit_card_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->debit_card_amount - $turn->real_debit_card_amount), 2, ",", ".")  ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Tarjeta de Crédito:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Pagos registrados en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->credit_card_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_credit_card_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->credit_card_amount - $turn->real_credit_card_amount), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Transferencias:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Registradas en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->transfer_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_transfer_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->transfer_amount - $turn->real_transfer_amount), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Depósitos:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Registrados en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->deposit_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_deposit_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->deposit_amount - $turn->real_deposit_amount), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Cheques:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Registrados en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->check_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_check_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->check_amount - $turn->real_check_amount), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<b>Retenciones:</b>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Registradas en el sistema</th>
                <th style="width: 33%; text-align: center;">En caja</th>
                <th style="width: 33%; text-align: center;">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->retention_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->real_retention_amount, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format(($turn->retention_amount - $turn->real_retention_amount), 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<br />
<h4><b>Totales:</b></h4>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 34%; text-align: center;">Total registrado en el sistema</th>
                <th style="width: 33%; text-align: center;">Total en caja</th>
                <th style="width: 33%; text-align: center;">Total diferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: right;"><?= number_format($turn->total_system, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->total_box, 2, ",", ".") ?></td>
                <td style="text-align: right;"><?= number_format($turn->total_difference, 2, ",", ".") ?></td>
            </tr>                    
        </tbody>
    </table>  
</div>
<div class="saltopagina">
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
        <h4>Cierre del turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
    </div>
    <div>
        <h3><b>Detalle de los pagos fiscales:</b></h3>
        <?php 
        $paymentType = " ";
        $totalType = 0;
        $grandTotal = 0;
        foreach ($paymentsTurn as $paymentsTurns): 
            if ($paymentsTurns->fiscal == 1):
                if ($paymentType == " "):
                    $paymentType = $paymentsTurns->payment_type; ?>
                    <h4><b>Pagos en: <?= $paymentType ?></b></h4> 
                    <div style="font-size: 20px;">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%;">Fecha y hora</th>
                                    <th scope="col" style="width: 10%;">Factura</th>
                                    <th scope="col" style="width: 10%;">Nro. Control</th>
                                    <th scope="col" style="width: 10%;">Familia</th>
                                    <th scope="col" style="width: 10%;">Monto Bs.</th>
                                    <th scope="col" style="width: 10%;">Banco</th>
                                    <th scope="col" style="width: 10%;">Tarjeta o serial</th>
                                </tr>
                            </thead>
                            <tbody id="payments-turn">
                <?php
                elseif ($paymentType != $paymentsTurns->payment_type): ?>
                            </tbody>
                        </table>
                    </div>
                    <p style="border-top: 1px solid #c2c2d6;"></p> 
                    <p style="text-align: right; "><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
                    <br />
                    <?php $paymentType = $paymentsTurns->payment_type; ?>
                    <h4><b>Pagos en: <?= $paymentType ?></b></h4> 
                    <div style="font-size: 20px;">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%;">Fecha y hora</th>
                                    <th scope="col" style="width: 10%;">Factura</th>
                                    <th scope="col" style="width: 10%;">Nro. Control</th>
                                    <th scope="col" style="width: 10%;">Familia</th>
                                    <th scope="col" style="width: 10%;">Monto Bs.</th>
                                    <th scope="col" style="width: 10%;">Banco</th>
                                    <th scope="col" style="width: 10%;">Tarjeta o serial</th>
                                </tr>
                            </thead>
                            <tbody id="payments-turn">
                    <?php 
                    $totalType = 0; 
                endif; 
                $totalType = $totalType + $paymentsTurns->amount;
                $grandTotal = $grandTotal + $paymentsTurns->amount; ?>                            
                <tr id=<?= $paymentsTurns->id ?>>
                    <td style="width: 15%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
                    <td style="width: 10%;"><?= h($paymentsTurns->bill_number) ?></td>
                    <td style="width: 10%;"><?= h($paymentsTurns->bill_id) ?></td>
                    <td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
                    <td style="width: 10%;"><?= h(number_format($paymentsTurns->amount, 2, ",", ".")) ?></td>
                    <td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
                    <td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
                </tr>
            <?php
            endif;
        endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p style="border-top: 1px solid #c2c2d6;"></p> 
                <p style="text-align: right;"><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
                <h4 style="text-align: right;"><b>Total General Bs. <?= (number_format($grandTotal, 2, ",", ".")) ?></b></h4>
    </div>
</div>
<?php if ($receipt == 1): ?>
    <div class="saltopagina">
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
            <h4>Cierre del turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
        </div>
        <div>
            <h3><b>Detalle de los pagos no fiscales:</b></h3>
            <?php 
            $paymentType = " ";
            $totalType = 0;
            $grandTotal = 0;
            foreach ($paymentsTurn as $paymentsTurns): 
                if ($paymentsTurns->fiscal == 0):
                    if ($paymentType == " "):
                        $paymentType = $paymentsTurns->payment_type; ?>
                        <h4><b>Pagos en: <?= $paymentType ?></b></h4> 
                        <div style="font-size: 20px;">
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                    <th scope="col" style="width: 15%;">Fecha y hora</th>
                                    <th scope="col" style="width: 10%;">Factura</th>
                                    <th scope="col" style="width: 10%;">Nro. Control</th>
                                    <th scope="col" style="width: 10%;">Familia</th>
                                    <th scope="col" style="width: 10%;">Monto Bs.</th>
                                    <th scope="col" style="width: 10%;">Banco</th>
                                    <th scope="col" style="width: 10%;">Tarjeta o serial</th>
                                    </tr>
                                </thead>
                                <tbody id="payments-turn">
                    <?php
                    elseif ($paymentType != $paymentsTurns->payment_type): ?>
                                </tbody>
                            </table>
                        </div>
                        <p style="border-top: 1px solid #c2c2d6;"></p> 
                        <p style="text-align: right; "><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
                        <br />
                        <?php $paymentType = $paymentsTurns->payment_type; ?>
                        <h4><b>Pagos en: <?= $paymentType ?></b></h4> 
                        <div style="font-size: 20px;">
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                    <th scope="col" style="width: 15%;">Fecha y hora</th>
                                    <th scope="col" style="width: 10%;">Factura</th>
                                    <th scope="col" style="width: 10%;">Nro. Control</th>
                                    <th scope="col" style="width: 10%;">Familia</th>
                                    <th scope="col" style="width: 10%;">Monto Bs.</th>
                                    <th scope="col" style="width: 10%;">Banco</th>
                                    <th scope="col" style="width: 10%;">Tarjeta o serial</th>
                                    </tr>
                                </thead>
                                <tbody id="payments-turn">
                        <?php 
                        $totalType = 0; 
                    endif; 
                    $totalType = $totalType + $paymentsTurns->amount;
                    $grandTotal = $grandTotal + $paymentsTurns->amount; ?>                            
                    <tr id=<?= $paymentsTurns->id ?>>
                        <td style="width: 15%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
                        <td style="width: 10%;"><?= h($paymentsTurns->bill_number) ?></td>
                        <td style="width: 10%;"><?= h($paymentsTurns->bill_id) ?></td>
                        <td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
                        <td style="width: 10%;"><?= h(number_format($paymentsTurns->amount, 2, ",", ".")) ?></td>
                        <td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
                        <td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
                    </tr>
                <?php
                endif;
            endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p style="border-top: 1px solid #c2c2d6;"></p> 
                    <p style="text-align: right;"><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
                    <h4 style="text-align: right;"><b>Total General Bs. <?= (number_format($grandTotal, 2, ",", ".")) ?></b></h4>
        </div>
    </div>
<?php endif; ?>