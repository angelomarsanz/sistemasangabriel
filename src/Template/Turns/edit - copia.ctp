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
    .noVerImpreso
    {
      display:none
    }
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
            <div class="row">
                <div class="col-md-12">
                    <h3 id="Turno" value=<?= $turn->id ?>><b>Cerrar Turno: <?= $turn->turn ?></b></h3>
                    <h4>Fecha: <?= $turn->start_date->format('d-m-Y') ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
					<h5>Turno no cerrado</h5>
                </div>
            </div>
			<div id='factura-control' class='row noVerImpreso'>
				<div class="col-md-3">
					<p>Por favor introduzca el Nro. de control de la factura <b><?= $lastNumber ?></b></p>	
					<?= $this->Form->input('control_number', ['label' => 'Nro. Control:']) ?>
					<button id="verificar" class="btn btn-success">Verificar si se saltó el número de control</button>
				</div>
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
										<th scope="col" style="width: 25%; text-align: center;">Forma de pago</th>
										<th scope="col" style="width: 25%; text-align: center;">Dólar</th>
										<th scope="col" style="width: 25%; text-align: center;">Euros</th>
										<th scope="col" style="width: 25%; text-align: center;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesFiscales as $fiscal):								
										if ($fiscal->moneda == "$"): ?>
											<tr><td style="text-align: center;"><?= $fiscal->formaPago ?></td><td style="text-align: center;"><?= number_format($fiscal->monto, 2, ",", ".") ?></td>
										<?php elseif ($fiscal->moneda == "Bs."): ?>
											<td style="text-align: center;"><?= number_format($fiscal->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td style="text-align: center;"><?= number_format($fiscal->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td style="text-align: center;"><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralFiscales['$'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralFiscales['€'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralFiscales['Bs.'], 2, ",", ".") ?></b></td>
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
										<th scope="col" style="width: 25%; text-align: center;">Forma de pago</th>
										<th scope="col" style="width: 25%; text-align: center;">Dólar</th>
										<th scope="col" style="width: 25%; text-align: center;">Euros</th>
										<th scope="col" style="width: 25%; text-align: center;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesAnticipos as $anticipo): ?>
										<?php if ($anticipo->moneda == "$"): ?>
											<tr><td style="text-align: center;"><?= $anticipo->formaPago ?></td><td style="text-align: center;"><?= number_format($anticipo->monto, 2, ",", ".") ?></td>
										<?php elseif ($anticipo->moneda == "Bs."): ?>
											<td style="text-align: center;"><?= number_format($anticipo->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td style="text-align: center;"><?= number_format($anticipo->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td style="text-align: center;"><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralAnticipos['$'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralAnticipos['€'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralAnticipos['Bs.'], 2, ",", ".") ?></b></td>
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
										<th scope="col" style="width: 25%; text-align: center;">Forma de pago</th>
										<th scope="col" style="width: 25%; text-align: center;">Dólar</th>
										<th scope="col" style="width: 25%; text-align: center;">Euros</th>
										<th scope="col" style="width: 25%; text-align: center;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($totalesServiciosEducativos as $servicio): ?>
										<?php if ($servicio->moneda == "$"): ?>
											<tr><td style="text-align: center;"><?= $servicio->formaPago ?></td><td style="text-align: center;"><?= number_format($servicio->monto, 2, ",", ".") ?></td>
										<?php elseif ($servicio->moneda == "Bs."): ?>
											<td style="text-align: center;"><?= number_format($servicio->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td style="text-align: center;"><?= number_format($servicio->monto, 2, ",", ".") ?></td>
										<?php endif; 
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td style="text-align: center;"><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralServiciosEducativos['$'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralServiciosEducativos['€'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralServiciosEducativos['Bs.'], 2, ",", ".") ?></b></td>
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
										<th scope="col" style="width: 25%; text-align: center;">Operación</th>
										<th scope="col" style="width: 25%; text-align: center;">Monto $</th>
									</tr>
								</thead>
								<tbody>
									<tr>	
										<td style="text-align: center;">Sobrantes</td>
										<td style="text-align: center;"><?= number_format($totalSobrantes, 2, ",", ".") ?></td>
									</tr>
									<tr>	
										<td style="text-align: center;">Reintegros</td>
										<td style="text-align: center;"><?= number_format($totalReintegros, 2, ",", ".") ?></td>
									</tr>
									<tr>	
										<td style="text-align: center;">Facturas compensadas</td>
										<td style="text-align: center;"><?= number_format($totalFacturasCompensadas, 2, ",", ".") ?></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>	
										<td style="text-align: center;"><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($totalOtrasOperaciones, 2, ",", ".") ?></b></td>
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
										<th scope="col" style="width: 25%; text-align: center;">Forma de pago</th>
										<th scope="col" style="width: 25%; text-align: center;">Dólar</th>
										<th scope="col" style="width: 25%; text-align: center;">Euros</th>
										<th scope="col" style="width: 25%; text-align: center;">Bolívares</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bancosReceptores as $receptor): ?>
										<?php if ($receptor->moneda == "$"): ?>
											<tr><td style="text-align: center;"><?= $receptor->banco ?></td><td style="text-align: center;"><?= number_format($receptor->monto, 2, ",", ".") ?></td>
										<?php elseif ($receptor->moneda == "Bs."): ?>
											<td style="text-align: center;"><?= number_format($receptor->monto, 2, ",", ".") ?></td></tr>
										<?php else: ?>
											<td style="text-align: center;"><?= number_format($receptor->monto, 2, ",", ".") ?></td>
										<?php endif;
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>	
										<td style="text-align: center;"><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($totalBancosReceptores['$'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalBancosReceptores['€'], 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalBancosReceptores['Bs.'], 2, ",", ".") ?></b></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
													<td style="text-align: center;">Totales</td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
									<td style="width: 10%; text-align: center;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%; text-align: center;"><?= h($pago->bank) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
													<td style="text-align: center;">Totales</td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
									<td style="width: 10%; text-align: center;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%; text-align: center;"><?= h($pago->bank) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
													<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
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
													<td style="text-align: center;">Totales</td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
													<td style="text-align: center;"></td>
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
													<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
													<th scope="col" style="width: 10%; text-align: center;">Factura</th>
													<th scope="col" style="width: 10%; text-align: center;">Control</th>
													<th scope="col" style="width: 10%; text-align: center;">Familia</th>
													<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
													<th scope="col" style="width: 10%; text-align: center;">Euro</th>
													<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
													<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
									<td style="width: 10%; text-align: center;"><?= $pago->created->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $pago->bill->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->name_family) ?></td>									
									<?php if ($pago->moneda == "$"): 
										$totalDolar += $pago->amount; ?>
										<td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td>
									<?php elseif ($pago->moneda == "€"): 
										$totalEuro += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td>
									<?php else: 
										$totalBolivar += $pago->amount; ?>
										<td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($pago->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%; text-align: center;"><?= h($pago->bank) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->banco_receptor) ?></td>
									<td style="width: 10%; text-align: center;"><?= h($pago->serial) ?></td>
								</tr>
												
								<?php $contadorLinea++; 
								$contador++; 
							endif;
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($sobrantes as $sobrante): ?>																		                       
								<tr>
									<td style="width: 10%; text-align: center;"><?= $sobrante->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $sobrante->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $sobrante->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $sobrante->parentsandguardian->family ?></td>							
									<?php $totalDolar += $sobrante->amount_paid; ?>
									<td style="width: 10%; text-align: center;"><?= number_format($sobrante->amount_paid, 2, ",", ".") ?></td>
									<td style="text-align: center;">0,00</td>
									<td style="text-align: center;">0,00</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($reintegros as $reintegro): ?>								
								<tr>
									<td style="width: 10%; text-align: center;"><?= $reintegro->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $reintegro->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $reintegro->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $reintegro->parentsandguardian->family ?></td>							
									<?php $totalDolar += $reintegro->amount_paid; ?>
									<td style="width: 10%; text-align: center;"><?= number_format($reintegro->amount_paid, 2, ",", ".") ?></td>
									<td style="text-align: center;">0,00</td>
									<td style="text-align: center;">0,00</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($facturasCompensadas as $factura): ?> 								
								<tr>
									<td style="width: 10%; text-align: center;"><?= $factura->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $factura->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $factura->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $factura->parentsandguardian->family ?></td>							
									<?php $totalDolar += $factura->saldo_compensado_dolar; ?>
									<td style="width: 10%; text-align: center;"><?= number_format($factura->saldo_compensado_dolar, 2, ",", ".") ?></td>
									<td style="text-align: center;">0,00</td>
									<td style="text-align: center;">0,00</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
												<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
												<th scope="col" style="width: 10%; text-align: center;">Factura</th>
												<th scope="col" style="width: 10%; text-align: center;">Control</th>
												<th scope="col" style="width: 10%; text-align: center;">Familia</th>
												<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
												<th scope="col" style="width: 10%; text-align: center;">Euro</th>
												<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
												<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
												<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
												<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
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
												<td style="text-align: center;">Totales</td>
												<td style="text-align: center;"></td>
												<td style="text-align: center;"></td>
												<td style="text-align: center;"></td>
												<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
												<td style="text-align: center;"></td>
												<td style="text-align: center;"></td>
												<td style="text-align: center;"></td>
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
												<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
												<th scope="col" style="width: 10%; text-align: center;">Factura</th>
												<th scope="col" style="width: 10%; text-align: center;">Control</th>
												<th scope="col" style="width: 10%; text-align: center;">Familia</th>
												<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
												<th scope="col" style="width: 10%; text-align: center;">Euro</th>
												<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
												<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
												<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
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
								<td style="width: 10%; text-align: center;"><?= $banco->created->format('d-m-Y H:i:s') ?></td>
								<td style="width: 10%; text-align: center;"><?= $banco->bill->bill_number ?></td>
								<td style="width: 10%; text-align: center;"><?= $banco->bill->control_number ?></td>
								<td style="width: 10%; text-align: center;"><?= h($banco->name_family) ?></td>									
								<?php if ($banco->moneda == "$"): 
									$totalDolar += $banco->amount; ?>
									<td style="width: 10%; text-align: center;"><?= number_format($banco->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td>
								<?php elseif ($banco->moneda == "€"): 
									$totalEuro += $banco->amount; ?>
									<td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($banco->amount, 2, ",", ".") ?></td><td style="text-align: center;">0,00</td>
								<?php else: 
									$totalBolivar += $banco->amount; ?>
									<td style="text-align: center;">0,00</td><td style="text-align: center;">0,00</td><td style="width: 10%; text-align: center;"><?= number_format($banco->amount, 2, ",", ".") ?></td>
								<?php endif; ?>
								<td style="width: 10%; text-align: center;"><?= h($banco->bank) ?></td>
								<td style="width: 10%; text-align: center;"><?= h($banco->banco_receptor) ?></td>
								<td style="width: 10%; text-align: center;"><?= h($banco->serial) ?></td>
							</tr>
											
							<?php $contadorLinea++; 
							$contador++; 
						endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($notasContables as $nota): 
								if ($nota->tipo_documento == "Nota de crédito"): ?>
									<tr>
										<td style="width: 10%; text-align: center;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->bill_number ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->control_number ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->parentsandguardian->family ?></td>
										<td style="text-align: center;">0,00</td>
										<td style="text-align: center;">0,00</td>										
										<?php $totalBolivar += $nota->amount_paid; ?>
										<td style="width: 10%; text-align: center;"><?= number_format($nota->amount_paid, 2, ",", ".") ?></td>
										<td style="width: 10%; text-align: center;">N/A</td>
										<td style="width: 10%; text-align: center;">N/A</td>
										<td style="width: 10%; text-align: center;">N/A</td>
									</tr> 
									<?php $contadorLinea++;
									$contadorRegistros++;
								endif; 
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($notasContables as $nota): 
								if ($notas->tipo_documento == "Nota de débito"): ?>
									<tr>
										<td style="width: 10%; text-align: center;"><?= $nota->date_and_time->format('d-m-Y H:i:s') ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->bill_number ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->control_number ?></td>
										<td style="width: 10%; text-align: center;"><?= $nota->parentsandguardian->family ?></td>
										<td style="text-align: center;">0,00</td>
										<td style="text-align: center;">0,00</td>										
										<?php $totalBolivar += $nota->amount_paid; ?>
										<td style="width: 10%; text-align: center;"><?= number_format($nota->amount_paid, 2, ",", ".") ?></td>
										<td style="width: 10%; text-align: center;">N/A</td>
										<td style="width: 10%; text-align: center;">N/A</td>
										<td style="width: 10%; text-align: center;">N/A</td>
									</tr> 
									<?php $contadorLinea++;
									$contadorRegistros++;
								endif; 
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>
							<?php foreach ($facturasRecibo as $recibo): ?> 	
								<tr>
									<td style="width: 10%; text-align: center;"><?= $recibo->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $recibo->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $recibo->control_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $recibo->parentsandguardian->family ?></td>
									<td style="text-align: center;">0,00</td>
									<td style="text-align: center;">0,00</td>										
									<?php $totalBolivar += $recibo->amount_paid; ?>
									<td style="width: 10%; text-align: center;"><?= number_format($recibo->amount_paid, 2, ",", ".") ?></td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($anuladas as $anulada): ?>
								<tr>
									<td style="width: 10%; text-align: center;"><?= $anulada->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $anulada->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $anulada->control_number ?></td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
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
											<th scope="col" style="width: 10%; text-align: center;">Fecha y hora</th>
											<th scope="col" style="width: 10%; text-align: center;">Factura</th>
											<th scope="col" style="width: 10%; text-align: center;">Control</th>
											<th scope="col" style="width: 10%; text-align: center;">Familia</th>
											<th scope="col" style="width: 10%; text-align: center;">Dólar</th>
											<th scope="col" style="width: 10%; text-align: center;">Euro</th>
											<th scope="col" style="width: 10%; text-align: center;">Bolívar</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco emisor</th>
											<th scope="col" style="width: 10%; text-align: center;">Bco receptor</th>
											<th scope="col" style="width: 10%; text-align: center;">Tarjeta o serial</th>
										</tr>
										<?php $contadorLinea++; ?>
									</thead>
									<tbody>										
							<?php foreach ($recibosAnulados as $anulado): ?>
								<tr>
									<td style="width: 10%; text-align: center;"><?= $anulado->date_and_time->format('d-m-Y H:i:s') ?></td>
									<td style="width: 10%; text-align: center;"><?= $anulado->bill_number ?></td>
									<td style="width: 10%; text-align: center;"><?= $anulado->control_number ?></td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
									<td style="width: 10%; text-align: center;">N/A</td>
								</tr> 
								<?php $contadorLinea++;
								$contadorRegistros++;								
							endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="text-align: center;">Totales</td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"><?= number_format($totalDolar, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalEuro, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($totalBolivar, 2, ",", ".") ?></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
											<td style="text-align: center;"></td>
										</tr>
										<?php $contadorLinea++; ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="row noVerImpreso">
					<div class="col-md-12">
						<?= $this->Form->create($turn) ?>
							<fieldset>
							</fieldset>
							<?= $this->Form->button(__('Cerrar turno'), ['id' => 'cerrar-turno', 'class' =>'btn btn-success']) ?>
						<?= $this->Form->end() ?>
						<br />
						<br />
					</div>
				</div>
				
			</div>	
        </div>
    </div>            
</div>   
<script>

    var paymentsTurn = new Array(); 

    $(document).ready(function() 
    {
		if ('<?= $lastNumber ?>' == 0)
		{
			$('#factura-control').addClass('noverScreen');
		}
		else
		{
			$('#contadores').addClass('noverScreen');
			$('#cerrar-turno').addClass('noverScreen');
		}
		$('#verificar').click(function(e) 
        {
			if ($('#control-number').val() == '<?= $lastControl ?>')
			{
				alert('Felicidades ! Los números de control están correctos, puede continuar con el cierre de turno')
				$('#factura-control').addClass('noverScreen');
				$('#contadores').removeClass('noverScreen');
				$('#cerrar-turno').removeClass('noverScreen');
			}
			else
			{
				$.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "editControl"]); ?>', {turn : '<?= $turn->id ?>'});
			}
		});

    });
        
</script>