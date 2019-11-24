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
		<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
	</div>
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
			<div>				
				<h3><b>Resumen de pagos:</b></h3>
				<div style="font-size: 12px; line-height: 14px;" class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<table id="resumen-pagos" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Fecha y hora</th>
									<th>Factura</th>
									<th>Control</th>
									<th>Familia</th>
									<th>Tasa $</th>
									<th>Tasa €</th>
									<th>Monto total factura Bs.</th>
									<th>Efectivo $</th>
									<th>Efectivo €</th>
									<th>Efectivo Bs.</th>
									<th>Zelle $</th>
									<th>TDD/TDC Bs.</th>
									<th>Transferencia Bs.</th>
									<th>Depósito Bs.</th>
									<th>Cheque Bs.</th>
									<th>Total facturado $</th>
									<th>N/C-N/D $</th>
									<th>Total cobrado $</th>
									<th>Diferencia $</th>
								</tr>
								<?php $contadorLinea++ ?>
							</thead>
							<tbody>				
								<?php foreach ($vectorPagos as $pago): ?> 
									<tr>
										<td><?php $pago['fechaHora']->format('d-m-Y H:i:s'); ?></td>
										<td><?php $pago['nroFactura']; ?></td>
										<td><?php $pago['nroControl']; ?></td>
										<td><?php $pago['familia']; ?></td>
										<td><?php number_format($pago['tasaDolar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['totalFacturaBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
										<td><?php number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['totalFacturadoBolivar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['ncNdDolar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['totalCobradoDolar'], 2, ",", ".") ?></td>
										<td><?php number_format($pago['totalFacturadoDolar'] - $pago['ncNdDolar'] - $pago['totalCobradoDolar'], 2, ",", ".") ?></td>										
									</tr> 
								<?php endforeach; ?>
							</tbody>
						</table>
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
			
			$("#resumen-pagos").table2excel({
		
				exclude: ".noExl",
			
				name: "resumen-pagos",
			
				filename: $('#resumen-pagos').attr('name') 
		
			});
		});
    });
        
</script>