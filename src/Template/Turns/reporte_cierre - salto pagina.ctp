<?php
    use Cake\Routing\Router; 
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
@media print
{
	.saltopagina
	{
		display:block; 
		page-break-before:always;
	}
}
</style>
<div id="page-turn" class="container">
    <div class="row">
        <div class="col-md-12">
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
				<h4>Turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $cajero ?></h4>
			</div>
            <br />
			<div id='contadores'>
				<b>Resumen pagos fiscales:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th scope="col" style="width: 25%;">Forma de pago</th>
										<th scope="col" style="width: 25%;">Dólar</th>
										<th scope="col" style="width: 25%;">Euros</th>
										<th scope="col" style="width: 25%;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesFiscales as $fiscal): ?>
										<?php if ($fiscal['moneda'] == "$"): ?>
											<tr><td><?= $fiscal['formaPago'] ?></td><td><?= number_format($fiscal['monto'], 2, ",", ".") ?></td>
										<?php elseif ($fiscal['moneda'] == "Bs."): ?>
											<td><?= number_format($fiscal['monto'], 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($fiscal['monto'], 2, ",", ".") ?></td>
										<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td>Totales</td>
										<td><?= number_format($totalGeneralFiscales['$'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralFiscales['€'], 2, ",", ".") ?></td> ?></td>
										<td><?= number_format($totalGeneralFiscales['Bs.'], 2, ",", ".") ?></td> ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<b>Resumen anticipos:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th scope="col" style="width: 25%;">Forma de pago</th>
										<th scope="col" style="width: 25%;">Dólar</th>
										<th scope="col" style="width: 25%;">Euros</th>
										<th scope="col" style="width: 25%;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesAnticipos as $anticipo): ?>
										<?php if ($anticipo['moneda'] == "$"): ?>
											<tr><td><?= $anticipo['formaPago'] ?></td><td><?= number_format($anticipo['monto'], 2, ",", ".") ?></td>
										<?php elseif ($anticipo['moneda'] == "Bs."): ?>
											<td><?= number_format($anticipo['monto'], 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($anticipo['monto'], 2, ",", ".") ?></td>
										<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td>Totales</td>
										<td><?= number_format($totalGeneralAnticipos['$'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralAnticipos['€'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralAnticipos['Bs.'], 2, ",", ".") ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<b>Resumen servicios educativos:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th scope="col" style="width: 25%;">Forma de pago</th>
										<th scope="col" style="width: 25%;">Dólar</th>
										<th scope="col" style="width: 25%;">Euros</th>
										<th scope="col" style="width: 25%;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesServiciosEducativos as $servicio): ?>
										<?php if ($servicio['moneda'] == "$"): ?>
											<tr><td><?= $servicio['formaPago'] ?></td><td><?= number_format($servicio['monto'], 2, ",", ".") ?></td>
										<?php elseif ($servicio['moneda'] == "Bs."): ?>
											<td><?= number_format($servicio['monto'], 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($servicio['monto'], 2, ",", ".") ?></td>
										<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td>Totales</td>
										<td><?= number_format($totalGeneralServiciosEducativos['$'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralServiciosEducativos['€'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralServiciosEducativos['Bs.'], 2, ",", ".") ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<b>Resumen otras operaciones:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th scope="col" style="width: 25%;">Operación</th>
										<th scope="col" style="width: 25%;">Monto $</th>
									</tr>
								</thead>
								<tbody>
									<tr>	
										<td>Sobrantes</td>
										<td><?= number_format($totalSobrantes, 2, ",", ".") ?></td>
									</tr>
									<tr>	
										<td>Reintegros</td>
										<td><?= number_format($totalReintegros, 2, ",", ".") ?></td>
									</tr>
									<tr>	
										<td>Facturas compensadas</td>
										<td><?= number_format($totalFacturasCompensadas, 2, ",", ".") ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<b>Resumen Bancos:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th scope="col" style="width: 25%;">Banco</th>
										<th scope="col" style="width: 25%;">Dólar</th>
										<th scope="col" style="width: 25%;">Euros</th>
										<th scope="col" style="width: 25%;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bancosReceptores as $receptor): ?>
										<?php if ($receptor['moneda'] == "$"): ?>
											<tr><td><?= $receptor['banco'] ?></td><td><?= number_format($receptor['monto'], 2, ",", ".") ?></td>
										<?php elseif ($receptor['moneda'] == "Bs."): ?>
											<td><?= number_format($receptor['monto'], 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($receptor['monto'], 2, ",", ".") ?></td>
										<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td>Totales</td>
										<td><?= number_format($totalBancosReceptores['$'], 2, ",", ".") ?></td>
										<td><?= number_format($totalBancosReceptores['€'], 2, ",", ".") ?></td>
										<td><?= number_format($totalBancosReceptores['Bs.'], 2, ",", ".") ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<?php $contadorLinea = 0;
				if ($origen != 'edit'): ?>
					<h3 class="saltopagina"><b>Detalle de los pagos fiscales:</b></h3>
				<?php else: ?>
					<h3><b>Detalle de los pagos fiscales:</b></h3>
					<?php $contadorLinea++;
				endif; ?>
				
				<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<?php $paymentType = "";						
						$totalDolar = 0;
						$totalEuro = 0;
						$totalBolivar = 0;
						foreach ($paymentsTurn as $paymentsTurns): 
							if ($paymentsTurns->fiscal == 1):
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Pagos en <?= $paymentType ?></b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 
								if ($paymentType != $paymentsTurns->payment_type):
									if ($paymentType == ""): ?>
										<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>										
									<?php else: ?> 
											</tbody>
											<tfoot>
												<tr>
													<td>Totales</td>
													<td></td>
													<td></td>
													<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php $contadorLinea++ ?>
											</tfoot>
										</table>
										<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>	
										<?php $totalDolar = 0;
										$totalEuro = 0;
										$totalBolivar = 0;
									endif; 
									$paymentType = $paymentsTurns->payment_type;
								endif ?>                         
								<tr>
									<td style="width: 25%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
									<td style="width: 10%;"><?= $paymentsTurns->bill_number ./. $paymentsTurns->bill->control_number ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
									
									<?php if ($paymentsTurns->moneda == "$": 
										$totalDolar += $paymentsTurns->amount; ?>
										<td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td></td><td></td>
									<?php elseif ($paymentsTurns->moneda == "€": 
										$totalEuro += $paymentsTurns->amount; ?>
										<td></td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td></td>
									<?php else: 
										$totalBolivar += $paymentsTurns->amount; ?>
										<td></td><td></td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
								</tr> 
								<?php $contadorLinea++ ?>
							<?php endif;
						endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<td>Totales</td>
									<td></td>
									<td></td>
									<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
									<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
									<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php $contadorLinea++ ?>
							</tfoot>
						</table>
					</div>
				</div>
				
				<?php if ($indicadorAnticipos == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de anticipos:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de anticipos:</b></h3>
						<?php $contadorLinea++;
					endif; ?>
					
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $paymentType = "";						
							$totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							foreach ($paymentsTurn as $paymentsTurns): 
								if ($paymentsTurns->bill->tipo_documento == "Recibo de anticipo")
									if ($contadorLinea > 50 && $origen != "edit"): 
										$contadorLinea = 0; ?>
										<b class="saltopagina">Pagos en <?= $paymentType ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>				
									<?php endif; 
									if ($paymentType != $paymentsTurns->payment_type):
										if ($paymentType == ""): ?>
											<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
											<?php $contadorLinea++ ?>
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 20%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura/No Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Dólar</th>
														<th scope="col" style="width: 10%;">Euro</th>
														<th scope="col" style="width: 10%;">Bolívar</th>
														<th scope="col" style="width: 10%;">Bco emisor</th>
														<th scope="col" style="width: 10%;">Bco receptor</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
													<?php $contadorLinea++ ?>
												</thead>
												<tbody>										
										<?php else: ?> 
												</tbody>
												<tfoot>
													<tr>
														<td>Totales</td>
														<td></td>
														<td></td>
														<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
														<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
														<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<?php $contadorLinea++ ?>
												</tfoot>
											</table>
											<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
											<?php $contadorLinea++ ?>
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 20%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura/No Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Dólar</th>
														<th scope="col" style="width: 10%;">Euro</th>
														<th scope="col" style="width: 10%;">Bolívar</th>
														<th scope="col" style="width: 10%;">Bco emisor</th>
														<th scope="col" style="width: 10%;">Bco receptor</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
													<?php $contadorLinea++ ?>
												</thead>
												<tbody>	
											<?php $totalDolar = 0;
											$totalEuro = 0;
											$totalBolivar = 0;
										endif; 
										$paymentType = $paymentsTurns->payment_type;
									endif ?>                         
									<tr>
										<td style="width: 25%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
										<td style="width: 10%;"><?= $paymentsTurns->bill_number ./. $paymentsTurns->bill->control_number ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
										
										<?php if ($paymentsTurns->moneda == "$": 
											$totalDolar += $paymentsTurns->amount; ?>
											<td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
										<?php elseif ($paymentsTurns->moneda == "€": 
											$totalEuro += $paymentsTurns->amount; ?>
											<td>0,00</td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td>0,00</td>
										<?php else: 
											$totalBolivar += $paymentsTurns->amount; ?>
											<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td>
										<?php endif; ?>
										<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->banco_receptor) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
									</tr> 
									<?php $contadorLinea++ ?>
								<?php endif;
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorServiciosEducativos == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de servicios educativos:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de servicios educativos:</b></h3>
						<?php $contadorLinea++;
					endif; ?>
					
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $paymentType = "";						
							$totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							foreach ($paymentsTurn as $paymentsTurns): 
								if ($paymentsTurns->bill->tipo_documento == "Recibo de servicio educativo")
									if ($contadorLinea > 50 && $origen != "edit"): 
										$contadorLinea = 0; ?>
										<b class="saltopagina">Pagos en <?= $paymentType ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>				
									<?php endif; 
									if ($paymentType != $paymentsTurns->payment_type):
										if ($paymentType == ""): ?>
											<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
											<?php $contadorLinea++ ?>
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 20%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura/No Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Dólar</th>
														<th scope="col" style="width: 10%;">Euro</th>
														<th scope="col" style="width: 10%;">Bolívar</th>
														<th scope="col" style="width: 10%;">Bco emisor</th>
														<th scope="col" style="width: 10%;">Bco receptor</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
													<?php $contadorLinea++ ?>
												</thead>
												<tbody>										
										<?php else: ?> 
												</tbody>
												<tfoot>
													<tr>
														<td>Totales</td>
														<td></td>
														<td></td>
														<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
														<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
														<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<?php $contadorLinea++ ?>
												</tfoot>
											</table>
											<b>Pagos en <?= $paymentsTurns->payment_type ?></b>
											<?php $contadorLinea++ ?>
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 20%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura/No Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Dólar</th>
														<th scope="col" style="width: 10%;">Euro</th>
														<th scope="col" style="width: 10%;">Bolívar</th>
														<th scope="col" style="width: 10%;">Bco emisor</th>
														<th scope="col" style="width: 10%;">Bco receptor</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
													<?php $contadorLinea++ ?>
												</thead>
												<tbody>	
											<?php $totalDolar = 0;
											$totalEuro = 0;
											$totalBolivar = 0;
										endif; 
										$paymentType = $paymentsTurns->payment_type;
									endif ?>                         
									<tr>
										<td style="width: 25%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
										<td style="width: 10%;"><?= $paymentsTurns->bill_number ./. $paymentsTurns->bill->control_number ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
										
										<?php if ($paymentsTurns->moneda == "$": 
											$totalDolar += $paymentsTurns->amount; ?>
											<td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
										<?php elseif ($paymentsTurns->moneda == "€": 
											$totalEuro += $paymentsTurns->amount; ?>
											<td>0,00</td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td>0,00</td>
										<?php else: 
											$totalBolivar += $paymentsTurns->amount; ?>
											<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td>
										<?php endif; ?>
										<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->banco_receptor) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
									</tr> 
									<?php $contadorLinea++ ?>
								<?php endif;
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorSobrantes == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de sobrantes:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de sobrantes:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($sobrantes as $sobrante): 								
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de sobrantes:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $sobrante->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $sobrante->bill_number ./. $sobrante->control_number ?></td>
									<td style="width: 10%;"><?= $sobrante->parentsandguardian->family ?></td>							
									<?php $totalDolar += $sobrante->amount_paid; ?>
									<td style="width: 10%;"><?= number_format($sobrante->amount_paid, 2, ",", ".") ?></td>
									<td>0,00</td>
									<td>0,00</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorReintegros == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de reintegros:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de reintegros:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($reintegros as $reintegro): 								
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de reintegros:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $reintegro->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $reintegro->bill_number ./. $sobrante->control_number ?></td>
									<td style="width: 10%;"><?= $reintegro->parentsandguardian->family ?></td>							
									<?php $totalDolar += $reintegro->amount_paid; ?>
									<td style="width: 10%;"><?= number_format($sobrante->amount_paid, 2, ",", ".") ?></td>
									<td>0,00</td>
									<td>0,00</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorCompensadas == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de facturas compensadas:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de facturas compensadas:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($facturasCompensadas as $factura): 								
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de facturas compensadas:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $factura->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $factura->bill_number ./. $factura->control_number ?></td>
									<td style="width: 10%;"><?= $factura->parentsandguardian->family ?></td>							
									<?php $totalDolar += $factura->saldo_compensado; ?>
									<td style="width: 10%;"><?= number_format($factura->saldo_compensado, 2, ",", ".") ?></td>
									<td>0,00</td>
									<td>0,00</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorBancos == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de bancos receptores:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de bancos receptores:</b></h3>
						<?php $contadorLinea++;
					endif; ?>
					
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $banco = "";						
							$totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							foreach ($recibidoBancos as $banco): 
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Banco <?= $banco->banco_receptor ?></b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 
								if ($banco != $banco->banco_receptor):
									if ($banco == ""): ?>
										<b>Banco <?= $banco->banco_receptor ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>										
									<?php else: ?> 
											</tbody>
											<tfoot>
												<tr>
													<td>Totales</td>
													<td></td>
													<td></td>
													<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php $contadorLinea++ ?>
											</tfoot>
										</table>
										<b>Banco <?= $banco->banco_receptor ?></b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>	
										<?php $totalDolar = 0;
										$totalEuro = 0;
										$totalBolivar = 0;
									endif; 
									$banco = $banco->banco_receptor;
								endif ?>                         
								<tr>
									<td style="width: 25%;"><?= h($banco->created->format('d-m-Y H:i:s')) ?></td>
									<td style="width: 10%;"><?= $banco->bill->bill_number ./. $banco->bill->control_number ?></td>
									<td style="width: 10%;"><?= h($banco->name_family) ?></td>									
									<?php if ($banco->moneda == "$": 
										$totalDolar += $banco->amount; ?>
										<td style="width: 10%;"><?= number_format($banco->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
									<?php elseif ($banco->moneda == "€": 
										$totalEuro += $banco->amount; ?>
										<td>0,00</td><td style="width: 10%;"><?= number_format($banco->amount, 2, ",", ".") ?></td><td>0,00</td>
									<?php else: 
										$totalBolivar += $banco->amount; ?>
										<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($banco->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($banco->bank) ?></td>
									<td style="width: 10%;"><?= h($banco->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($banco->serial) ?></td>
								</tr> 
								<?php $contadorLinea++ ?>	
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorNotasCredito == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de notas de crédito:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de notas de crédito:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($notasContables as $nota): 
								if ($notas->tipo_documento == "Nota de crédito")
									if ($contadorLinea > 50 && $origen != "edit"): 
										$contadorLinea = 0; ?>
										<b class="saltopagina">Detalle de notas de crédito:</b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>				
									<?php endif; 	
									if ($contadorRegistros == 0): ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>										
									<?php endif; ?>									                       
									<tr>
										<td style="width: 25%;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%;"><?= $nota->bill_number ./. $factura->control_number ?></td>
										<td style="width: 10%;"><?= $nota->parentsandguardian->family ?></td>
										<td>0,00</td>
										<td>0,00</td>										
										<?php $totalBolivar += $nota->amount_paid; ?>
										<td style="width: 10%;"><?= number_format($nota->amount_paid, 2, ",", ".") ?></td>
										<td style="width: 10%;">N/A</td>
										<td style="width: 10%;">N/A</td>
										<td style="width: 10%;">N/A</td>
									</tr> 
									<?php $contadorLinea++;
									$contadorRegistros++;
								endif; 
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
					
				<?php if ($indicadorNotasDebito == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de notas de débito:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de notas de débito:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($notasContables as $nota): 
								if ($notas->tipo_documento == "Nota de débito")
									if ($contadorLinea > 50 && $origen != "edit"): 
										$contadorLinea = 0; ?>
										<b class="saltopagina">Detalle de notas de débito:</b>
										<?php $contadorLinea++ ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>				
									<?php endif; 	
									if ($contadorRegistros == 0): ?>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 20%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura/No Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++ ?>
											</thead>
											<tbody>										
									<?php endif; ?>									                       
									<tr>
										<td style="width: 25%;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%;"><?= $nota->bill_number ./. $factura->control_number ?></td>
										<td style="width: 10%;"><?= $nota->parentsandguardian->family ?></td>
										<td>0,00</td>
										<td>0,00</td>										
										<?php $totalBolivar += $nota->amount_paid; ?>
										<td style="width: 10%;"><?= number_format($nota->amount_paid, 2, ",", ".") ?></td>
										<td style="width: 10%;">N/A</td>
										<td style="width: 10%;">N/A</td>
										<td style="width: 10%;">N/A</td>
									</tr> 
									<?php $contadorLinea++;
									$contadorRegistros++;
								endif; 
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
					
				<?php if ($indicadorFacturasRecibo == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de facturas correspondientes a anticipos:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de facturas correspondientes a anticipos:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($facturasRecibo as $recibo): 	
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de facturas correspondientes a anticipos:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $recibo->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $recibo->bill_number ./. $recibo->control_number ?></td>
									<td style="width: 10%;"><?= $recibo->parentsandguardian->family ?></td>
									<td>0,00</td>
									<td>0,00</td>										
									<?php $totalBolivar += $recibo->amount_paid; ?>
									<td style="width: 10%;"><?= number_format($recibo->amount_paid, 2, ",", ".") ?></td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorAnuladas == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de facturas anuladas:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de facturas anuladas:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($anuladas as $anulada): 	
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de facturas anuladas:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $anulada->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $anulada->bill_number ./. $anulada->control_number ?></td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorRecibosAnulados == 1)
					if ($contadorLinea > 45 && $origen != 'edit'): ?>
						<h3 class="saltopagina"><b>Detalle de recibos anulados:</b></h3>
					<?php else: ?>
						<h3><b>Detalle de recibos anulados:</b></h3>
						<?php $contadorLinea++;
					endif; ?>			
					<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0;
							foreach ($recibosAnulados as $anulado): 	
								if ($contadorLinea > 50 && $origen != "edit"): 
									$contadorLinea = 0; ?>
									<b class="saltopagina">Detalle de recibos anulados:</b>
									<?php $contadorLinea++ ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>				
								<?php endif; 	
								if ($contadorRegistros == 0): ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 20%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura/No Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++ ?>
										</thead>
										<tbody>										
								<?php endif; ?>									                       
								<tr>
									<td style="width: 25%;"><?= $anulado->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $anulado->bill_number ./. $anulada->control_number ?></td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
									<td style="width: 10%;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td>Totales</td>
										<td></td>
										<td></td>
										<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
										<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
										<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php $contadorLinea++ ?>
								</tfoot>
							</table>
						</div>
					</div>
				<?php endif; ?>
			</div>
        </div>
    </div>            
</div>   
<script>
    $(document).ready(function() 
    {

    });
        
</script>