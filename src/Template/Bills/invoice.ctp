<style>
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
</style>
<?php if ($accountService == 0): ?>
	<?php if ($bill->fiscal == 1): ?>
		<br />
		<br />
		<div style="font-size: 13px; line-height: 15px;">
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
						<td style='width:80%;'>Dirección: <spam style="font-size: 9px; line-height: 11px;"><?= $bill->fiscal_address ?></spam></td>
						<?php if($numeroFacturaAfectada > 0): ?>
							<td style='width:20%; text-align: right;'><spam style="font-size: 9px; line-height: 11px;"><?= "Factura afectada: Nro. " . $numeroFacturaAfectada . " Control " . $controlFacturaAfectada ?></spam></td>
						<?php else: ?>
							<td style='width:20%;'></td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div>
			<table style="width:100%; font-size: 13px; line-height: 15px;">
				<thead>
					<tr>
						<th style="width:10%; text-align:left;">Código</th>
						<th style="width:70%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
		<hr>
		<div style="width:100%;">
			<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
			<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
				<p>Cajero: <?= $usuarioResponsable ?></p>
			</div>
			<div id="total" style="font-size: 13px; line-height: 15px;">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;"><b>Sub-total:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount), 2, ",", ".") ?></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>IVA 0%:</b></td>
						<td style="width: 50%;"><b></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.S:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
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
		<div style="font-size: 13px; line-height: 15px;">
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
						<td style='width:80%;'>Dirección: <spam style="font-size: 9px; line-height: 11px;"><?= $bill->fiscal_address ?></spam></td>
						<?php if($numeroFacturaAfectada > 0): ?>
							<td style='width:20%; text-align: right;'><spam style="font-size: 9px; line-height: 11px;"><?= "Factura afectada: Nro. " . $numeroFacturaAfectada . " Control " . $controlFacturaAfectada ?></spam></td>
						<?php else: ?>
							<td style='width:20%;'></td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<div>
			<table style="width:100%; font-size: 13px; line-height: 15px;">
				<thead>
					<tr>
						<th style="width:10%; text-align:left;">Código</th>
						<th style="width:70%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
		<hr>
		<div style="width:100%;">
			<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
			<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
				<p>Cajero: <?= $current_user['first_name'] . " " . $current_user['surname'] ?></p>
			</div>
			<div id="total" style="font-size: 13px; line-height: 15px;">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;"><b>Sub-total:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount), 2, ",", ".") ?></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>IVA 0%:</b></td>
						<td style="width: 50%;"><b></b></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.S:</b></td>
						<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
					</tr>
				</table>
			</div>
		</div>
	<?php else: ?>
		<div>
			<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
			<h4>Rif J-07573084-4</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo Nro. <?= $bill->bill_number ?> por Bs.S <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.S <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $current_user['first_name'] . " " . $current_user['surname'] ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.S:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div>
			<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
			<h4>Rif J-07573084-4</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo Nro. <?= $bill->bill_number ?> por Bs.S <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.S <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $current_user['first_name'] . " " . $current_user['surname'] ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.S:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php if ($indicadorAnticipo == 1): ?>
		<div>
			<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
			<h4>Rif J-07573084-4</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo Nro. <?= $bill->bill_number ?> por Bs.S <?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.S <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $current_user['first_name'] . " " . $current_user['surname'] ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount - $accountService), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.S:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div>
			<h3>U.E. "Colegio San Gabriel Arcángel", C.A.</h3>
			<h4>Rif J-07573084-4</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo Nro. <?= $bill->bill_number ?> por Bs.S <?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.S <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.S</th>
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
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
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
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $current_user['first_name'] . " " . $current_user['surname'] ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $bill->amount - $accountService), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.S:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<br />
		<br />
		<br />
		<br />
	<?php endif; ?>
	<div class="saltopagina">
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h3 style="text-align: right;">Recibo Nro. <?= $bill->bill_number . '-2' ?></h3>
		<h2 style="text-align: center;">Por Bs.S <?= number_format($accountService, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs.S <b><?= number_format($accountService, 2, ",", ".") ?></b>
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