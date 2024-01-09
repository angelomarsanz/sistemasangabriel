<style>
@media screen
{
    .alignRight
    {
    	text-align: right;
    }
    hr
    {
    	color: #47476b;
		height: 1px;
		background-color: black;
		margin: 5px 0px 5px 0px;
    }
    #payments
    {
    	width: 25%;
    	float: left;
    }
    #emptyColumn
    {
    	width: 40%;
    	float: left;
    }
    #total
    {
    	width: 35%;
    	float: left;
    }
    .saltopagina
    {
        display:block;
        page-break-before:always;
    }
}
@media print
{
    .alignRight
    {
    	text-align: right;
    }
    hr
    {
    	color: #47476b;
		height: 1px;
		background-color: black;
		margin: 5px 0px 5px 0px;
    }
    #payments
    {
    	width: 25%;
    	float: left;
    }
    #emptyColumn
    {
    	width: 40%;
    	float: left;
    }
    #total
    {
    	width: 35%;
    	float: left;
    }
    .saltopagina
    {
        display:block;
        page-break-before:always;
    }
    .nover 
    {
      display:none
    }
}
</style>
<br />
<button class='nover btn btn-warning' onclick='imprimir()'>La factura Nro. <?= $bill->bill_number ?> ya se imprimió !</button>
<?php if ($accountService == 0): ?>
	<?php if ($bill->fiscal == 1): ?>
		<?php 
		$monto_divisas_bolivar = round($bill->monto_divisas * $bill->tasa_cambio, 2); 
		$monto_igtf_bolivar = round($bill->monto_igtf * $bill->tasa_cambio, 2); 
		?>
		<br />
		<br />
		<br />
		<br />
		<div style="font-size: 9px; line-height: 11px;">
			<?php if ($bill->annulled == 1): ?>
				<h1 style="text-align:center;">Anulada <?= $bill->date_annulled->format('d-m-Y') ?></h1>
			<?php endif; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<?php if ($bill->tipo_documento == "Nota de crédito"): ?>
							<td style="width:20%; text-align: right;"><b>Nota de crédito Nro. <?= $bill->bill_number ?></b></td>
						<?php elseif ($bill->tipo_documento == "Nota de débito"): ?>
							<td style="width:20%; text-align: right;"><b>Nota de débito Nro. <?= $bill->bill_number ?></b></td>
						<?php else: ?>
							<td style="width:20%; text-align: right;"><b>Factura Nro. <?= $bill->bill_number ?></b></td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<?php if($numeroFacturaAfectada > 0): ?>
							<td style='width:20%; text-align: right;'> <?= "Factura afectada: Nro. " . $numeroFacturaAfectada . " Control " . $controlFacturaAfectada ?></td>
						<?php else: ?>
							<td style='width:20%;'></td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
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
							<td>&nbsp;(E)</td>
						</tr>
					<?php
					$counter++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;">
			<div id="payments">				
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%; text-align:right;"><?= number_format($monto_igtf_bolivar, 2, ",", ".") ?></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $monto_igtf_bolivar, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<?php $countSubtraction = 30 - $counter; ?>
		<div style="font-size: 9px; line-height: 11px;">
			<?php for ($i = 1; $i <= $countSubtraction; $i++): ?>
				<br />
			<?php endfor; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:70%;'>Cliente: <?= $bill->client ?></td>
						<?php if ($bill->tipo_documento == "Nota de crédito"): ?>
							<td style="width:20%; text-align: right;"><b>Nota de crédito Nro. <?= $bill->bill_number ?></b></td>
						<?php elseif ($bill->tipo_documento == "Nota de débito"): ?>
							<td style="width:20%; text-align: right;"><b>Nota de débito Nro. <?= $bill->bill_number ?></b></td>
						<?php else: ?>
							<td style="width:20%; text-align: right;"><b>Factura Nro. <?= $bill->bill_number ?></b></td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<?php if($numeroFacturaAfectada > 0): ?>
							<td style='width:20%; text-align: right;'><?= "Factura afectada: Nro. " . $numeroFacturaAfectada . " Control " . $controlFacturaAfectada ?></td>
						<?php else: ?>
							<td style='width:20%;'></td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($vConcepts as $vConcept): ?>
						<tr>
							<td><?= h($vConcept['accountingCode']) ?></td>
							<td><?= h($vConcept['invoiceLine']) ?></td>
							<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							<td>&nbsp;(E)</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;"> 
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%; text-align:right;"><?= number_format($monto_igtf_bolivar, 2, ",", ".") ?></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $monto_igtf_bolivar, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
	<?php elseif ($indicadorAnticipo == 1): ?>
		<?php 
		$monto_divisas_bolivar = round($bill->monto_divisas * $bill->tasa_cambio, 2); 
		$monto_igtf_bolivar = round($bill->monto_igtf * $bill->tasa_cambio, 2); 
		?>
		<br />
		<br />
		<br />
		<br />
		<div style="font-size: 9px; line-height: 11px;">
			<?php if ($bill->annulled == 1): ?>
				<h1 style="text-align:center;">Recibo de Anticipo Anulado <?= $bill->date_annulled->format('d-m-Y') ?></h1>
			<?php endif; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Recibo de anticipo Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
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
							<td>&nbsp;(E)</td>
						</tr>
					<?php
					$counter++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;">
			<div id="payments">				
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<?php $countSubtraction = 30 - $counter; ?>
		<div style="font-size: 9px; line-height: 11px;">
			<?php for ($i = 1; $i <= $countSubtraction; $i++): ?>
				<br />
			<?php endfor; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Recibo de anticipo Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($vConcepts as $vConcept): ?>
						<tr>
							<td><?= h($vConcept['accountingCode']) ?></td>
							<td><?= h($vConcept['invoiceLine']) ?></td>
							<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							<td>&nbsp;(E)</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;"> 
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
	<?php elseif ($bill->tipo_documento == "Pedido"): ?>
		<?php 
		$monto_divisas_bolivar = round($bill->monto_divisas * $bill->tasa_cambio, 2); 
		$monto_igtf_bolivar = round($bill->monto_igtf * $bill->tasa_cambio, 2); 
		?>
		<br />
		<br />
		<br />
		<br />
		<div style="font-size: 9px; line-height: 11px;">
			<?php if ($bill->annulled == 1): ?>
				<h1 style="text-align:center;">Pedido Anulado <?= $bill->date_annulled->format('d-m-Y') ?></h1>
			<?php endif; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Pedido Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
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
							<td>&nbsp;(E)</td>
						</tr>
					<?php
					$counter++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;">
			<div id="payments">				
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<?php $countSubtraction = 30 - $counter; ?>
		<div style="font-size: 9px; line-height: 11px;">
			<?php for ($i = 1; $i <= $countSubtraction; $i++): ?>
				<br />
			<?php endfor; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Pedido Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($vConcepts as $vConcept): ?>
						<tr>
							<td><?= h($vConcept['accountingCode']) ?></td>
							<td><?= h($vConcept['invoiceLine']) ?></td>
							<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							<td>&nbsp;(E)</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;"> 
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
	<?php elseif ($bill->tipo_documento == "Recibo de seguro"): ?>
		<?php 
		$monto_divisas_bolivar = round($bill->monto_divisas * $bill->tasa_cambio, 2); 
		$monto_igtf_bolivar = round($bill->monto_igtf * $bill->tasa_cambio, 2); 
		?>
		<div>
			<h5><?= " Fecha: ".$bill->date_and_time->format('d-m-Y').", ".$bill->school_year ?></h5>
			<?php 
			if ($bill->annulled == 1): ?>
				<h3 style="text-align: center;">*** ANULADO ***</H3>
			<?php
			endif; ?> 
			<h3 style="text-align: right;">Recibo de Seguro Nro. <?= $bill->bill_number ?></h3>		
			<h2 style="text-align: center;">Por Bs. <?= number_format($bill->amount_paid, 2, ",", ".") ?>  (<?= number_format(round($bill->amount_paid/$bill->tasa_cambio, 2), 2, ",", ".") ?>  $)</h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b> Bs.</p>
			<p>Por concepto de seguro escolar, correspondiente a lo(s) alumno(s):</p>
			<table style="width:100%;">
				<tbody>
					<?php foreach ($vConcepts as $vConcept): ?>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;- <?= h($vConcept['invoiceLine']) ?></td>
							</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<br />
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<br />
			<br />
			<br />
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php if ($indicadorAnticipo == 1): ?>
		<?php 
		$monto_divisas_bolivar = round($bill->monto_divisas * $bill->tasa_cambio, 2); 
		$monto_igtf_bolivar = round($bill->monto_igtf * $bill->tasa_cambio, 2); 
		?>
		<br />
		<br />
		<br />
		<br />
		<div style="font-size: 9px; line-height: 11px;">
			<?php if ($bill->annulled == 1): ?>
				<h1 style="text-align:center;">Recibo de Anticipo Anulado <?= $bill->date_annulled->format('d-m-Y') ?></h1>
			<?php endif; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Recibo de anticipo Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
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
							<td>&nbsp;(E)</td>
						</tr>
					<?php
					$counter++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;">
			<div id="payments">				
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<?php $countSubtraction = 30 - $counter; ?>
		<div style="font-size: 9px; line-height: 11px;">
			<?php for ($i = 1; $i <= $countSubtraction; $i++): ?>
				<br />
			<?php endfor; ?>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $bill->client ?></td>
						<td style="width:20%; text-align: right;"><b>Recibo de anticipo Nro. <?= str_pad($bill->bill_number, 6, "0", STR_PAD_LEFT); ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $bill->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%; font-size: 7px; line-height: 9px;'>Dirección: <?= $bill->fiscal_address ?></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="font-size: 9px; line-height: 11px;">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:5%; text-align:left;">Código</th>
						<th style="width:75%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
						<th style="width:5%; text-align:left;"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($vConcepts as $vConcept): ?>
						<tr>
							<td><?= h($vConcept['accountingCode']) ?></td>
							<td><?= h($vConcept['invoiceLine']) ?></td>
							<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							<td>&nbsp;(E)</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div style="width:100%; font-size: 9px; line-height: 11px;"> 
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody class="nover">
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td><?= h($aPayment->payment_type) ?></td>
								<td><?= h($aPayment->bank) ?></td>
								<td><?= h($aPayment->bancoReceptor) ?></td>
								<td><?= h($aPayment->account_or_card) ?></td>
								<td><?= h($aPayment->serial) ?></td>
								<td><?= h($aPayment->moneda) ?></td>
								<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
								<td><?= $aPayment->comentario ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="emptyColumn">
				<p class="nover">Monto en divisas al cambio Bs.: <?= number_format($monto_divisas_bolivar, 2, ",", ".") ?></p>  
				<p class="nover">Tasa cambio BCV <?= number_format($bill->tasa_cambio, 2, ",", ".") ?></p>
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td>
						<td>&nbsp;(E)</td>
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
						<?php if ($bill->amount > 0): ?>
							<td>&nbsp;(E)</td>
						<?php else: ?>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="nover">
						<td style="width: 50%;">IGTF 3%:</td>
						<td style="width: 50%;"></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(round($bill->amount_paid + $bill->amount, 2), 2, ",", ".") ?></b></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="saltopagina">
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h3 style="text-align: right;">Recibo de Servicio Educativo Nro. <?= $bill->bill_number . '-2' ?></h3>
	<?php else: ?>
		<div>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h3 style="text-align: right;">Recibo de Servicio Educativo Nro. <?= $bill->bill_number ?></h3>		
	<?php endif; ?>	
		<h2 style="text-align: center;">Por Bs. <?= number_format($accountService + $bill->amount, 2, ",", ".") ?>  (<?= number_format(($accountService + $bill->amount_dollar)/$bill->tasa_cambio, 2, ",", ".") ?>  $)</h2>
		<br />
		<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($accountService, 2, ",", ".") ?></b>
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
		<br />
		<br />
		<div id="payments">
			Formas de pago:
			<table style="width:100%;">
				<tbody class="nover">
					<?php foreach ($aPayments as $aPayment): ?>
						<tr>
							<td><?= h($aPayment->payment_type) ?></td>
							<td><?= h($aPayment->bank) ?></td>
							<td><?= h($aPayment->bancoReceptor) ?></td>
							<td><?= h($aPayment->account_or_card) ?></td>
							<td><?= h($aPayment->serial) ?></td>
							<td><?= h($aPayment->moneda) ?></td>
							<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
							<td><?= $aPayment->comentario ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<br />
		<br />
		<br />
	</div>
<?php endif; ?>
<?php if ($indicadorSobrante == 1): ?>
	<br />
	<br />
	<div>
		<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
		<h4>Rif J-07573084-4</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;"><?= $bill->tipo_documento ?> Nro. <?= $bill->bill_number ?> por $ <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de $ <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
		como abono para pagar futuras cuotas.</p>
	</div>
<?php endif; ?>
<?php if ($indicadorReintegro == 1): ?>
	<br />
	<br />
	<div>
		<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
		<h4>Rif J-07573084-4</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;"><?= $bill->tipo_documento ?> Nro. <?= $bill->bill_number ?> por $ <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Hemos recibido del colegio San Gabriel Arcángel, C.A. la cantidad de $ <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b> por concepto de reintegro.</p>
		<br />
		<p><?= $bill->client ?></p>
		<p><?= $bill->identification ?></p>
		<p>Firma</p>
	</div>
<?php endif; ?>
<?php if ($indicadorCompra == 1): ?>
	<br />
	<br />
	<div>
		<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
		<h4>Rif J-07573084-4</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;"><?= $bill->tipo_documento ?> Nro. <?= $bill->bill_number ?> por <?= $monedaDocumento . ' ' . number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Por concepto de: </p>
			
		<?php foreach ($vConcepts as $vConcept): ?>
			<?= h($vConcept['invoiceLine']) ?><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if ($indicadorVueltoCompra == 1): ?>
	<br />
	<br />
	<div>
		<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
		<h4>Rif J-07573084-4</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;"><?= $bill->tipo_documento ?> Nro. <?= $bill->bill_number ?> por <?= $monedaDocumento . ' ' . number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Por concepto de: </p>
			
		<?php foreach ($vConcepts as $vConcept): ?>
			<?= h($vConcept['invoiceLine']) ?><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<br />
<br />
<button class='nover btn btn-success' onclick='imprimirPantalla()'>Imprimir</button>
<script>
    $(document).ready(function()
    {
		mensajeUsuario ="<?= $mensajeUsuario ?>";
		if (mensajeUsuario != "")
		{
			alert(mensajeUsuario);
		}
	});
</script>