<?php
    use Cake\Routing\Router;
?>
<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
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
		<?php if ($tipo_reporte == "General por Representantes"): ?>
			<div>
				<div style="float: left; width:10%;">
					<p><img src="<?php echo Router::url(["controller" => "webroot/files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/logo1.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
				</div>
				<div style="float: left; width: 90%;">
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
					<h3 style="text-align: center;"><?= 'Reporte General Morosidad por Representantes al '.$mes_anio_hasta ?></h3>
					<p><?= "Monto total mensualidades de septiembre a ".$nombre_mes_reporte." ".$anio_correspondiente_mes.": ".number_format($total_cuotas_periodo, 2, ",", ".")." $" ?></p>
					<p><?= "Mensualidades pagadas: ".number_format(round($total_cuotas_periodo - $total_morosos, 2), 2, ",", ".")." $" ?></p>
					<p><?= "Mensualidades pendientes ".number_format(round($total_morosos, 2), 2, ",", ".")." $" ?></p>
					<p><?= "Porcentaje de morosidad: ".round(($total_morosos/$total_cuotas_periodo)*100, 2)." %" ?></p>
				</div>
			</div>
			<div>
				<table class="table table-striped table-hover">
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
							<td style="text-align:center;">Totales</td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"></td>
							<td style="text-align:center;"><?= number_format($total_morosos, 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format(round($total_morosos * $dollarExchangeRate, 2), 2, ",", ".") ?></td>
							<td style="text-align:center;"></td>

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
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
         <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
function myFunction() 
{
    window.print();
}
$(document).ready(function(){ 
    $('#mas').on('click',function()
    {
        $('#menu-menos').hide();
        $('#menu-mas').show();
    });
    
    $('#menos').on('click',function()
    {
        $('#menu-mas').hide();
        $('#menu-menos').show();
    });
});
</script>