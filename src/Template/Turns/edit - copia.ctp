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
            <div class="row">
                <div class="col-md-12">
                    <h3 id="Turno" value=<?= $turn->id ?>><b>Cerrar Turno: <?= $turn->turn ?></b></h3>
                    <h4>Fecha: <?= $turn->start_date->format('d-m-Y') ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
                </div>
            </div>
			<div id='factura-control' class='row'>
				<div class="col-md-3">
					<p>Por favor introduzca el Nro. de control de la factura <b><?= $lastNumber ?></b></p>	
					<?= $this->Form->input('control_number', ['label' => 'Nro. Control:']) ?>
					<button id="verificar" class="btn btn-success">Verificar si se saltó el número de control</button>
				</div>
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
										<td><?= number_format($totalGeneralFiscal['$'], 2, ",", ".") ?></td>
										<td><?= number_format($totalGeneralFiscal['€'], 2, ",", ".") ?></td> ?></td>
										<td><?= number_format($totalGeneralFiscal['Bs.'], 2, ",", ".") ?></td> ?></td>
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
					<h3><b>Detalle de los pagos fiscales:</b></h3>
				<?php else: ?>
					<h3 class="saltopagina"><b>Detalle de los pagos fiscales:</b></h3>
					<?php $contadorLinea++;
				endif; ?>
				
				<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<?php $paymentType = "";						
						$totalDolarFiscal = 0;
						$totalEuroFiscal = 0;
						$totalBolivarFiscal = 0;
						foreach ($paymentsTurn as $paymentsTurns): 
							if ($paymentsTurns->fiscal == 1):
								if ($contadorLinea > 50 ): 
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
													<td><?= number_format($totalDolarFiscal, 2, ",", ".") ?></td>
													<td><?= number_format($totalEuroFiscal, 2, ",", ".") ?></td>
													<td><?= number_format($totalBolivarFiscal, 2, ",", ".") ?></td>
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
										<?php $totalDolarFiscal = 0;
										$totalEuroFiscal = 0;
										$totalBolivarFiscal = 0;
									endif; 
									$paymentType = $paymentsTurns->payment_type;
								endif ?>                         
								<tr>
									<td style="width: 25%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
									<td style="width: 10%;"><?= $paymentsTurns->bill_number ./. $paymentsTurns->bill->bill_number ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
									
									<?php if ($paymentsTurns->moneda == "$": 
										$totalDolarFiscal += $paymentsTurns->amount; ?>
										<td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td></td><td></td>
									<?php elseif ($paymentsTurns->moneda == "€": 
										$totalEuroFiscal += $paymentsTurns->amount; ?>
										<td></td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td><td></td>
									<?php else: 
										$totalBolivarFiscal += $paymentsTurns->amount; ?>
										<td></td><td></td><td style="width: 10%;"><?= number_format($paymentsTurns->amount, 2, ",", ".") ?></td>
									<?php endif; ?>
									<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->banco_receptor) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
								</tr> 
								<?php $contadorLinea++ ?>
							<?php endif;
						endforeach; ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<?= $this->Form->create() ?>
							<fieldset>
								<?php
									echo $this->Form->input('totales_fiscales', ['type' => 'hidden', 'value' => $totalesFiscales]);
									echo $this->Form->input('total_general_fiscal', ['type' => 'hidden', 'value' => $totalGeneralFiscal]);
									echo $this->Form->input('totales_anticipos', ['type' => 'hidden', 'value' => $totalesAnticipos]);
									echo $this->Form->input('total_general_anticipos', ['type' => 'hidden', 'value' => $totalGeneralAnticipos]);
									echo $this->Form->input('totales_servicios_educativos', ['type' => 'hidden', 'value' => $totalesServiciosEducativos]);
									echo $this->Form->input('total_general_servicios_educativos', ['type' => 'hidden', 'value' => $totalGeneralServiciosEducativos ]);
									echo $this->Form->input('total_totales', ['type' => 'hidden', 'value' => $totalTotales]);
									echo $this->Form->input('total_sobrantes', ['type' => 'hidden', 'value' => $totalSobrantes]);
									echo $this->Form->input('total_reintegros', ['type' => 'hidden', 'value' => $totalReintegros]);
									echo $this->Form->input('total_facturas_compensadas', ['type' => 'hidden', 'value' => $totalFacturasCompensadas]);
									echo $this->Form->input('bancos_receptores', ['type' => 'hidden', 'value' => $bancosReceptores]);
									echo $this->Form->input('total_bancos_receptores', ['type' => 'hidden', 'value' => $totalBancosReceptores]);
								?>								
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