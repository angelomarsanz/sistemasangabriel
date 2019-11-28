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
	<br />
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

			<div id='contadores' style="font-size: 12px; line-height: 14px;">	
			
				<p><b>Resumen pagos fiscales:</b></p>
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
									<?php foreach ($totalesFiscales as $fiscal):								
										if ($fiscal->moneda == "$"): ?>
											<tr><td><?= $fiscal->formaPago ?></td><td><?= number_format($fiscal->monto, 2, ",", ".") ?></td>
										<?php elseif ($fiscal->moneda == "Bs."): ?>
											<td><?= number_format($fiscal->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($fiscal->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td><b>Totales</b></td>
										<td><b><?= number_format($totalGeneralFiscales['$'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralFiscales['€'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralFiscales['Bs.'], 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<p><b>Resumen anticipos:</b></p>
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
										<?php if ($anticipo->moneda == "$"): ?>
											<tr><td><?= $anticipo->formaPago ?></td><td><?= number_format($anticipo->monto, 2, ",", ".") ?></td>
										<?php elseif ($anticipo->moneda == "Bs."): ?>
											<td><?= number_format($anticipo->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($anticipo->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td><b>Totales</b></td>
										<td><b><?= number_format($totalGeneralAnticipos['$'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralAnticipos['€'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralAnticipos['Bs.'], 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<p><b>Resumen servicios educativos:</b></p>
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
										<?php if ($servicio->moneda == "$"): ?>
											<tr><td><?= $servicio->formaPago ?></td><td><?= number_format($servicio->monto, 2, ",", ".") ?></td>
										<?php elseif ($servicio->moneda == "Bs."): ?>
											<td><?= number_format($servicio->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($servicio->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td><b>Totales</b></td>
										<td><b><?= number_format($totalGeneralServiciosEducativos['$'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralServiciosEducativos['€'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalGeneralServiciosEducativos['Bs.'], 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<p><b>Resumen otras operaciones:</b></p>
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
								<tfoot>
									<tr>	
										<td><b>Totales</b></td>
										<td><b><?= number_format($totalOtrasOperaciones, 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<p><b>Resumen Bancos:</b></p>
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
										<?php if ($receptor->moneda == "$"): ?>
											<tr><td><?= $receptor->banco ?></td><td><?= number_format($receptor->monto, 2, ",", ".") ?></td>
										<?php elseif ($receptor->moneda == "Bs."): ?>
											<td><?= number_format($receptor->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td><?= number_format($receptor->monto, 2, ",", ".") ?></td>
										<?php endif;
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td><b>Totales</b></td>
										<td><b><?= number_format($totalBancosReceptores['$'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalBancosReceptores['€'], 2, ",", ".") ?></b></td>
										<td><b><?= number_format($totalBancosReceptores['Bs.'], 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<br />
				
				<?php $contadorLinea = 0; ?>
						
				<?php if ($indicadorFiscales == 1): ?>
					<p><b>Detalle de pagos fiscales:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<?php 
						$contador = 0;
						$formaAnterior = "";						
						$totalDolar = 0;
						$totalEuro = 0;
						$totalBolivar = 0; ?>
						
						<?php foreach ($paymentsTurn as $pago): 
							if ($pago->fiscal = 1):
								if ($contador == 0): 
									$formaAnterior = $pago->payment_type; ?>
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
													<th></th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
								<?php endif; ?>	
								<?php if ($formaAnterior != $pago->payment_type): 
								$formaAnterior = $pago->payment_type; ?>
											</tbody>
											<tfoot>
												<tr>
													<td>Totales</td>
													<td></td>
													<td></td>
													<td></td>
													<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php $contadorLinea++; ?>
											</tfoot>
										</table>
									</div>
									<br />
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
																			
									<?php $totalDolar = 0;
									$totalEuro = 0;
									$totalBolivar = 0;
								endif; ?>
								<tr>
									<td style="width: 10%;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($pago->bank) ?></td>
									<td style="width: 10%;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td>Totales</td>
											<td></td>
											<td></td>
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorAnticipos == 1): ?>
					<p><b>Detalle de anticipos:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<?php 
						$contador = 0;
						$formaAnterior = "";						
						$totalDolar = 0;
						$totalEuro = 0;
						$totalBolivar = 0; ?>
						
						<?php foreach ($paymentsTurn as $pago): 
							if ($pago->bill->tipo_documento == "Recibo de anticipo"):
								if ($contador == 0): 
									$formaAnterior = $pago->payment_type; ?>
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
													<th></th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
								<?php endif; ?>	
								<?php if ($formaAnterior != $pago->payment_type): 
								$formaAnterior = $pago->payment_type; ?>
											</tbody>
											<tfoot>
												<tr>
													<td>Totales</td>
													<td></td>
													<td></td>
													<td></td>
													<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php $contadorLinea++; ?>
											</tfoot>
										</table>
									</div>
									<br />
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
																			
									<?php $totalDolar = 0;
									$totalEuro = 0;
									$totalBolivar = 0;
								endif; ?>
								<tr>
									<td style="width: 10%;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($pago->bank) ?></td>
									<td style="width: 10%;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td>Totales</td>
											<td></td>
											<td></td>
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorServiciosEducativos == 1): ?>
					<p><b>Detalle de servicios educativos:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<?php 
						$contador = 0;
						$formaAnterior = "";						
						$totalDolar = 0;
						$totalEuro = 0;
						$totalBolivar = 0; ?>
						
						<?php foreach ($paymentsTurn as $pago): 
							if ($pago->bill->tipo_documento == "Recibo de servicio educativo"):
								if ($contador == 0): 
									$formaAnterior = $pago->payment_type; ?>
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
													<th></th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
								<?php endif; ?>	
								<?php if ($formaAnterior != $pago->payment_type): 
								$formaAnterior = $pago->payment_type; ?>
											</tbody>
											<tfoot>
												<tr>
													<td>Totales</td>
													<td></td>
													<td></td>
													<td></td>
													<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php $contadorLinea++; ?>
											</tfoot>
										</table>
									</div>
									<br />
									<p><b><?= $pago->payment_type ?></b></p>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 10%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Dólar</th>
													<th scope="col" style="width: 10%;">Euro</th>
													<th scope="col" style="width: 10%;">Bolívar</th>
													<th scope="col" style="width: 10%;">Bco emisor</th>
													<th scope="col" style="width: 10%;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
												</tr>
												<?php $contadorLinea++; ?>
											</thead>
											<tbody>
																			
									<?php $totalDolar = 0;
									$totalEuro = 0;
									$totalBolivar = 0;
								endif; ?>
								<tr>
									<td style="width: 10%;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td>0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td>0,00</td><td>0,00</td><td style="width: 10%;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($pago->bank) ?></td>
									<td style="width: 10%;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td>Totales</td>
											<td></td>
											<td></td>
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorSobrantes == 1): ?> 
					<p><b>Detalle de sobrantes:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($sobrantes as $sobrante): ?>																		                       
								<tr>
									<td style="width: 10%;"><?= $sobrante->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $sobrante->bill_number ?></td>
									<td style="width: 10%;"><?= $sobrante->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorReintegros == 1): ?>
					<p><b>Detalle de reintegros:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?> 	
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($reintegros as $reintegro): ?>								
								<tr>
									<td style="width: 10%;"><?= $reintegro->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $reintegro->bill_number ?></td>
									<td style="width: 10%;"><?= $reintegro->control_number ?></td>
									<td style="width: 10%;"><?= $reintegro->parentsandguardian->family ?></td>							
									<?php $totalDolar += $reintegro->amount_paid; ?>
									<td style="width: 10%;"><?= number_format($reintegro->amount_paid, 2, ",", ".") ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorCompensadas == 1): ?>
					<p><b>Detalle de facturas compensadas:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($facturasCompensadas as $factura): ?> 								
								<tr>
									<td style="width: 10%;"><?= $factura->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $factura->bill_number ?></td>
									<td style="width: 10%;"><?= $factura->control_number ?></td>
									<td style="width: 10%;"><?= $factura->parentsandguardian->family ?></td>							
									<?php $totalDolar += $factura->saldo_compensado_dolar; ?>
									<td style="width: 10%;"><?= number_format($factura->saldo_compensado_dolar, 2, ",", ".") ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
							
				<?php if ($indicadorBancos == 1): ?>
					<p><b>Detalle de bancos receptores:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<?php 
						$contador = 0;
						$bancoAnterior = "";						
						$totalDolar = 0;
						$totalEuro = 0;
						$totalBolivar = 0; ?>
						
						<?php foreach ($recibidoBancos as $banco): ?>
							<?php if ($contador == 0): 
								$bancoAnterior = $banco->banco_receptor; ?>
								<p><b>Banco <?= $banco->banco_receptor ?></b></p>
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 10%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura</th>
												<th scope="col" style="width: 10%;">Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
												<th></th>
											</tr>
											<?php $contadorLinea++; ?>
										</thead>
										<tbody>
							<?php endif; ?>	
							<?php if ($bancoAnterior != $banco->banco_receptor): 
							$bancoAnterior = $banco->banco_receptor; ?>
										</tbody>
										<tfoot>
											<tr>
												<td>Totales</td>
												<td></td>
												<td></td>
												<td></td>
												<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
												<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
												<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<?php $contadorLinea++; ?>
										</tfoot>
									</table>
								</div>
								<br />
								<p><b>Banco <?= $banco->banco_receptor ?></b></p>
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col" style="width: 10%;">Fecha y hora</th>
												<th scope="col" style="width: 10%;">Factura</th>
												<th scope="col" style="width: 10%;">Control</th>
												<th scope="col" style="width: 10%;">Familia</th>
												<th scope="col" style="width: 10%;">Dólar</th>
												<th scope="col" style="width: 10%;">Euro</th>
												<th scope="col" style="width: 10%;">Bolívar</th>
												<th scope="col" style="width: 10%;">Bco emisor</th>
												<th scope="col" style="width: 10%;">Bco receptor</th>
												<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
											</tr>
											<?php $contadorLinea++; ?>
										</thead>
										<tbody>
																		
								<?php $totalDolar = 0;
								$totalEuro = 0;
								$totalBolivar = 0;
							endif; ?>
							<tr>
								<td style="width: 10%;"><?= $banco->created->format('d-m-Y H:i:s') ?></td>
								<td style="width: 10%;"><?= $banco->bill->bill_number ?></td>
								<td style="width: 10%;"><?= $banco->bill->control_number ?></td>
								<td style="width: 10%;"><?= h($banco->name_family) ?></td>									
								<?php if ($banco->moneda == "$"): 
									$totalDolar += $banco->amount; ?>
									<td style="width: 10%;"><?= number_format($banco->amount, 2, ",", ".") ?></td><td>0,00</td><td>0,00</td>
								<?php elseif ($banco->moneda == "€"): 
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
											
							<?php $contadorLinea++; 
							$contador++; 
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td>Totales</td>
											<td></td>
											<td></td>
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorNotasCredito == 1): ?>
					<p><b>Detalle de notas de crédito:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($notasContables as $nota): 
								if ($nota->tipo_documento == "Nota de crédito"): ?>
									<tr>
										<td style="width: 10%;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%;"><?= $nota->bill_number ?></td>
										<td style="width: 10%;"><?= $nota->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorNotasDebito == 1): ?>
					<p><b>Detalle de notas de débito:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($notasContables as $nota): 
								if ($notas->tipo_documento == "Nota de débito"): ?>
									<tr>
										<td style="width: 10%;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%;"><?= $nota->bill_number ?></td>
										<td style="width: 10%;"><?= $nota->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorFacturasRecibo == 1): ?>
					<p><b>Detalle de facturas correspondientes a anticipos:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>
							<?php foreach ($facturasRecibo as $recibo): ?> 	
								<tr>
									<td style="width: 10%;"><?= $recibo->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $recibo->bill_number ?></td>
									<td style="width: 10%;"><?= $recibo->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorAnuladas == 1): ?>
					<p><b>Detalle de facturas anuladas:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($anuladas as $anulada): ?>
								<tr>
									<td style="width: 10%;"><?= $anulada->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $anulada->bill_number ?></td>
									<td style="width: 10%;"><?= $anulada->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ($indicadorRecibosAnulados == 1): ?>
					<p><b>Detalle de recibos anulados:</b></p>
					<?php $contadorLinea++; ?>
					
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php $totalDolar = 0;
							$totalEuro = 0;
							$totalBolivar = 0;
							$contadorRegistros = 0; ?>	
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 10%;">Fecha y hora</th>
											<th scope="col" style="width: 10%;">Factura</th>
											<th scope="col" style="width: 10%;">Control</th>
											<th scope="col" style="width: 10%;">Familia</th>
											<th scope="col" style="width: 10%;">Dólar</th>
											<th scope="col" style="width: 10%;">Euro</th>
											<th scope="col" style="width: 10%;">Bolívar</th>
											<th scope="col" style="width: 10%;">Bco emisor</th>
											<th scope="col" style="width: 10%;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($recibosAnulados as $anulado): ?>
								<tr>
									<td style="width: 10%;"><?= $anulado->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%;"><?= $anulado->bill_number ?></td>
									<td style="width: 10%;"><?= $anulado->control_number ?></td>
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
											<td></td>
											<td><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
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