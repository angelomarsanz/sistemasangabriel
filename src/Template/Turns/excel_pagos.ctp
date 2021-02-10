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
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<br />
			<br />
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
			<div>				
				<h3><b>Pagos recibidos:</b></h3>
				<div style="font-size: 12px; line-height: 14px;">
					<br />
					<div class="row">
						<div class="col-md-12">
							<table name="excel_pagos" id="excel-pagos" class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center">Nro</th>
										<th style="text-align: center">Fecha</th>
										<th style="text-align: center">Factura</th>
										<th style="text-align: center">Control</th>
										<th style="text-align: center;">Tipo documento</th>
										<th style="text-align: center">Familia</th>
										<th style="text-align: center">Tasa $</th>
										<th style="text-align: center">Tasa €</th>
										<th style="text-align: center">Monto total factura Bs.</th>
										<th style="text-align: center">Efectivo $</th>
										<th style="text-align: center">Efectivo €</th>
										<th style="text-align: center">Efectivo Bs.</th>
										<th style="text-align: center">Zelle $</th>
										<th style="text-align: center">Euros €</th>
										<th style="text-align: center">TDD/TDC Bs.</th>
										<th style="text-align: center">Transferencia Bs.</th>
										<th style="text-align: center">Depósito Bs.</th>
										<th style="text-align: center">Cheque Bs.</th>
										<th style="text-align: center">Banco emisor</th>
										<th style="text-align: center">Banco receptor</th>
										<th style="text-align: center">Cuenta o tarjeta</th>
										<th style="text-align: center">Serial</th>
										<th style="text-align: center">Destiempo</th>
										<th style="text-align: center">Comentario</th>
									</tr>
								</thead>
								<tbody>	
									<?php
										$totalFacturaBolivar = 0; 
										$totalEfectivoDolar = 0;
										$totalEfectivoEuro = 0;
										$totalEfectivoBolivar = 0;
										$totalZelleDolar = 0;
										$totalEuros = 0;
										$totalTddTdcBolivar = 0;
										$totalTransferenciaBolivar = 0;
										$totalDepositoBolivar = 0;
										$totalChequeBolivar = 0;
										$totalTransferenciaDestiempo = 0;
									?>
									<?php foreach ($vectorPagos as $pago): ?> 
										<tr>
											<td style="text-align: center"><?= $pago['Nro'] ?></td>
											<td style="text-align: center"><?= $pago['fechaHora']->format('d/m/Y') ?></td>
											<td style="text-align: center"><?= $pago['nroFactura'] ?></td>
											<td style="text-align: center"><?= $pago['nroControl'] ?></td>
											<td><?= $pago['tipoDocumento']; ?></td>
											<td><?= $pago['familia'] ?></td>
											<td style="text-align: center"><?= number_format($pago['tasaDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center"><?= number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
											
											<td style="text-align: center"><?= number_format($pago['totalFacturaBolivar'], 2, ",", ".") ?></td>
											<?php $totalFacturaBolivar += $pago['totalFacturaBolivar']; ?>
											
											<td style="text-align: center"><?= number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
											<?php $totalEfectivoDolar += $pago['efectivoDolar']; ?>
											
											<td style="text-align: center"><?= number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
											<?php $totalEfectivoEuro += $pago['efectivoEuro']; ?>
											
											<td style="text-align: center"><?= number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
											<?php $totalEfectivoBolivar += $pago['efectivoBolivar']; ?>
											
											<td style="text-align: center"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
											<?php $totalZelleDolar += $pago['zelleDolar']; ?>
											
											<?php if (isset($pago['euros'])): ?>
												<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".") ?></td>
												<?php $totalEuros += $pago['euros']; ?>
											<?php else: ?>
												<td style="text-align: center;"><?= "0,00" ?></td>
											<?php endif; ?>
											
											<td style="text-align: center"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
											<?php $totalTddTdcBolivar += $pago['tddTdcBolivar']; ?>
											
											<?php if ($pago['transferenciaDestiempo'] == ''): ?>
												<td style="text-align: center"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>
												<?php $totalTransferenciaBolivar += $pago['transferenciaBolivar']; ?>
											<?php else: ?>
												<td style="text-align: center">0,00</td>											
											<?php endif; ?>
											
											<td style="text-align: center"><?= number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
											<?php $totalDepositoBolivar += $pago['depositoBolivar']; ?>
											
											<td style="text-align: center"><?= number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
											<?php $totalChequeBolivar += $pago['chequeBolivar']; ?>
											
											<td style="text-align: center"><?= $pago['bancoEmisor'] ?></td>
											<td style="text-align: center"><?= $pago['bancoReceptor'] ?></td>
											<td style="text-align: center"><?= $pago['cuentaTarjeta'] ?></td>
											<td style="text-align: center"><?= $pago['serial'] ?></td>
											<?php if ($pago['transferenciaDestiempo'] == 'Sí'): ?>
												<td style="text-align: center"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>
												<?php $totalTransferenciaDestiempo += $pago['transferenciaBolivar']; ?>
											<?php else: ?>
												<td style="text-align: center">0,00</td>											
											<?php endif; ?>
											<td style="text-align: center"><?= $pago['comentario'] ?></td>		
										</tr> 
									<?php endforeach; ?>
								</tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><b>Totales</b></td>
										
										<td style="text-align: center"><b><?= number_format($totalFacturaBolivar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalEfectivoDolar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalEfectivoEuro, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalEfectivoBolivar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalZelleDolar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalEuros, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalTddTdcBolivar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalTransferenciaBolivar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalDepositoBolivar, 2, ",", ".") ?></b></td>
										
										<td style="text-align: center"><b><?= number_format($totalChequeBolivar, 2, ",", ".") ?></b></td>
										
										<td></td>
										<td></td>
										<td></td>
										<td></td>

										<td style="text-align: center"><b><?= number_format($totalTransferenciaDestiempo, 2, ",", ".") ?></b></td>
										
										<td></td>		
									</tr> 
								<tfoot>
								
								</tfoot>
							</table>
						</div>
					</div>
					<div class="row">
					<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$("#excel").click(function(){
			
			$("#excel-pagos").table2excel({
		
				exclude: ".noExl",
			
				name: "excel_pagos",
			
				filename: $('#excel-pagos').attr('name') 
		
			});
		});
    });
        
</script>