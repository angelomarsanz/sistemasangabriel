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
				<h3><b>Facturas, notas y recibos:</b></h3>
				<div style="font-size: 12px; line-height: 14px;">
					<br />
					<div class="row">
						<div class="col-md-12">					
							<table name="excel_documentos" id="excel-documentos" class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;">Nro.</th>
										<th style="text-align: center;">Fecha/hora</th>
										<th style="text-align: center;">Factura</th>
										<th style="text-align: center;">Control</th>
										<th style="text-align: center;">Tipo documento</th>
										<th style="text-align: center;">Familia</th>
										<th style="text-align: center;">Tasa $</th>
										<th style="text-align: center;">Tasa €</th>
										<th style="text-align: center;">Monto total factura Bs.</th>
										<th style="text-align: center;">Efectivo $</th>
										<th style="text-align: center;">Efectivo €</th>
										<th style="text-align: center;">Efectivo Bs.</th>
										<th style="text-align: center;">Zelle $</th>
										<th style="text-align: center;">TDD/TDC Bs.</th>
										<th style="text-align: center;">Transferencia Bs.</th>
										<th style="text-align: center;">Depósito Bs.</th>
										<th style="text-align: center;">Cheque Bs.</th>
										<th style="text-align: center;">Total facturado $</th>
										<th style="text-align: center;">N/C-N/D $</th>
										<th style="text-align: center;">Total cobrado $</th>
										<th style="text-align: center;">Diferencia $</th>
									</tr>
								</thead>
								<tbody>				
									<?php foreach ($vectorPagos as $pago): ?> 
										<tr>
											<td style="text-align: center;"><?= $pago['Nro']; ?></td>
											<td style="text-align: center;"><?= $pago['fechaHora']->format('d-m-Y H:i:s'); ?></td>
											<td style="text-align: center;"><?= $pago['nroFactura']; ?></td>
											<td style="text-align: center;"><?= $pago['nroControl']; ?></td>
											<td><?= $pago['tipoDocumento']; ?></td>
											<td><?= $pago['familia']; ?></td>
											<td style="text-align: center;"><?= number_format($pago['tasaDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['totalFacturaBolivar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
											<td style="text-align: center;"><?= number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['totalFacturadoDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['ncNdDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['totalCobradoDolar'], 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pago['totalFacturadoDolar'] - $pago['ncNdDolar'] - $pago['totalCobradoDolar'], 2, ",", ".") ?></td>										
										</tr> 
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
					</div>
					<br />
					<br />
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$("#excel").click(function(){
			
			$("#excel-documentos").table2excel({
		
				exclude: ".noExl",
			
				name: "excel_documentos",
			
				filename: $('#excel-documentos').attr('name') 
		
			});
		});
    });
        
</script>