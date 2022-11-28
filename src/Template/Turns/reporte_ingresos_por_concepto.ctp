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
<?php $contador_item = 1 ?>
<div name="reporte_ingresos_por_concepto" id="reporte_ingresos_por_concepto" class="container" style="font-size: 12px; line-height: 14px;">
	<br />
    <div class="row">
        <div class="col-md-12">
			<div>
				<table style="width:100%; font-size: 14px; line-height: 16px;">
					<tbody>
						<tr>
							<td>Unidad Educativa Colegio</td>
						</tr>
						<tr>
							<td><b>"San Gabriel Arcángel C.A."</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>	
						<tr>
							<td><b>Reporte de Ingresos Por Concepto|</b></td>
						</tr>
						<tr>
							<td><b>Concepto: <?= $concepto ?>, Año <?= $ano ?></b></td>
						</tr>							
					</tbody>
				</table>
			</div>
			<div>	
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>	
									<tr>
										<th style="text-align: center;"><b>Item</b></th>
										<th style="text-align: center;"><b>Nro. Factura/Recibo</b></th>
										<th style="text-align: center;"><b>Fecha</b></th>
										<th style="text-align: center;"><b>Familia</b></th>
										<th style="text-align: center;"><b>Cliente</b></th>
										<th style="text-align: center;"><b>Cédula o RIF</b></th>
										<th style="text-align: center;"><b>Estudiante</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Monto $</b></th>
										<th style="text-align: center;"><b>Tasa de cambio</b></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ($ingresos as $ingreso): ?>
										<?php 
										$monto_dolar = round($ingreso->amount / $ingreso->bill->tasa_cambio, 2); ?> 
										<tr>
											<td style="text-align: center;"><b><?= $contador_item ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->bill->bill_number ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->bill->created->format('d-m-Y') ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->bill->parentsandguardian->family ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->bill->client ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->bill->identification ?></b></td>
											<td style="text-align: center;"><b><?= $ingreso->student_name ?></b></td>
											<td style="text-align: center;"><b><?= number_format($ingreso->amount, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($monto_dolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($ingreso->bill->tasa_cambio, 2, ",", ".") ?></b></td>

										</tr>
										<?php $contador_item++ ?>
									<?php
									endforeach; ?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>

<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#reporte_ingresos_por_concepto").table2excel({
		
				exclude: ".noExl",
			
				name: "reporte_ingresos_por_concepto",
			
				filename: $('#reporte_ingresos_por_concepto').attr('name') 
		
			});
		});
    });
        
</script>