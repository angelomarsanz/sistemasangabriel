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
    .nover 
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
<br />
<div class="row">
	<div class="col-md-12">
		<?php if ($tipo_reporte == "General de Representantes"): ?>
			<div style="float: left; width: 100%;">
				<h5><b><?= $school->name ?></b></h5>
				<p>RIF: <?= $school->rif ?></p>
				<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
				<h3 style="text-align: center;"><?= 'Reporte General Morosidad de Representantes al '.$mes_anio_hasta ?></h3>
				<h4 style="text-align: left;">Resumen</h4>
				<p><?= "Monto total mensualidades de septiembre a ".$nombre_mes_reporte." ".$anio_correspondiente_mes.": ".number_format($total_cuotas_periodo, 2, ",", ".")." $" ?></p>
				<p><?= "Mensualidades pagadas: ".number_format(round($total_cuotas_periodo - $totales_morosidad["Total $"], 2), 2, ",", ".")." $" ?></p>
				<p><?= "Mensualidades pendientes: ".number_format($totales_morosidad["Total $"], 2, ",", ".")." $" ?></p>
				<p><?= "Porcentaje de morosidad: ".round(($totales_morosidad["Total $"]/$total_cuotas_periodo)*100, 2)." %" ?></p>
				<p>Totales de mensualidades pendientes por mes:</p>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Sep</th>
							<th style="text-align:center;">Oct</th>
							<th style="text-align:center;">Nov</th>
							<th style="text-align:center;">Dic</th>
							<th style="text-align:center;">Ene</th>
							<th style="text-align:center;">Feb</th>
							<th style="text-align:center;">Mar</th>
							<th style="text-align:center;">Abr</th>
							<th style="text-align:center;">May</th>
							<th style="text-align:center;">Jun</th>
							<th style="text-align:center;">Jul</th>
							<th style="text-align:center;">Total $</th>
							<th style="text-align:center;">Total Bs.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Sep"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Oct"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Nov"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Dic"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Ene"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Feb"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Mar"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Abr"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["May"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Jun"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Jul"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($totales_morosidad["Total $"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format(round($totales_morosidad["Total $"] * $dollarExchangeRate, 2), 2, ",", ".") ?></td>
						</tr>
					</tbody>
				<table>
			</div>
			<div style="float: left; width: 100%;">
				<h4 style="text-align: left;">Detalle</h4>
				<table  name="reporte_general_morosidad_representantes" id="reporte-general-morosidad-representantes" class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Nro.</th>
							<th style="text-align:center;">Familia</th>
							<th style="text-align:center;">Sep</th>
							<th style="text-align:center;">Oct</th>
							<th style="text-align:center;">Nov</th>
							<th style="text-align:center;">Dic</th>
							<th style="text-align:center;">Ene</th>
							<th style="text-align:center;">Feb</th>
							<th style="text-align:center;">Mar</th>
							<th style="text-align:center;">Abr</th>
							<th style="text-align:center;">May</th>
							<th style="text-align:center;">Jun</th>
							<th style="text-align:center;">Jul</th>
							<th style="text-align:center;">Total $</th>
							<th style="text-align:center;">Total Bs.</th>
							<?php
							if ($telefono == "Sí"): ?>
								<th style="text-align:center;">Teléfono</th>
							<?php
							endif; ?>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"><b>Totales</b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Sep"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Oct"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Nov"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Dic"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Ene"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Feb"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Mar"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Abr"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["May"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Jun"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Jul"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["Total $"], 2, ",", ".") ?></b></td>
							<td style="text-align:center;"><b><?= number_format(round($totales_morosidad["Total $"] * $dollarExchangeRate, 2), 2, ",", ".") ?></b></td>
							<?php
							if ($telefono == "Sí"): ?>
								<td></td>
							<?php
							endif; ?>

						</tr>
					</tfoot>
					<tbody>
						<?php
						$contador_transacciones = 1;
						foreach ($detalle_morosos as $moroso): ?>
							<tr>
								<td style="text-align:center;"><?= $contador_transacciones ?></td>
								<td style="text-align:left;"><?= $moroso["Familia"] ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Sep"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Oct"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Nov"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Dic"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Ene"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Feb"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Mar"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Abr"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["May"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Jun"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Jul"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format($moroso["Total $"], 2, ",", ".") ?></td>
								<td style="text-align:center;"><?= number_format(round($moroso["Total $"] * $dollarExchangeRate, 2), 2, ",", ".") ?></td>
								<?php
								if ($telefono == "Sí"): ?>
									<td style="text-align:center;"><?= $moroso["Teléfono"] ?></td>
								<?php endif; ?>
							</tr>  
							<?php $contador_transacciones++; ?>
						<?php 
						endforeach; ?>
					</tbody>
				</table>
			</div>

		<?php endif; ?>
		<br />			
	</div>
</div>
<script>
function myFunction() 
{
    window.print();
}
$(document).ready(function()
{ 
	$("#exportar-excel").click(function(){
		
		$("#reporte-general-morosidad-representantes").table2excel({
	
			exclude: ".noExl",
		
			name: "reporte_general_morosidad_representantes",
		
			filename: $('#reporte-general-morosidad-representantes').attr('name') 
	
		});
	});
});
</script>