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
<?php
if (isset($detalle_morosos)): ?>
	<div class="row" name="reporte_consejo_educativo_por_cobrar" id="reporte-consejo-educativo-por-cobrar" >
		<div class="col-md-12">
			<div style="float: left; width: 100%;">
				<h5><b><?= $school->name ?></b></h5>
				<p>RIF: <?= $school->rif ?></p>
				<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
				<h3 style="text-align: center;"><?= 'Consejo Educativo por Cobrar del período: '.$periodo_escolar ?></h3>
				<h4 style="text-align: left;">Resumen</h4>
				<p><?= "Monto total Consejo Educativo ".$periodo_escolar.": ".number_format($total_cuotas_periodo, 2, ",", ".")." $" ?></p>
				<p><?= "Consejo Educativo pagado: ".number_format(round($total_cuotas_periodo - $totales_morosidad["CE"], 2), 2, ",", ".")." $" ?></p>
				<p><?= "Consejo Educativo pendiente: ".number_format($totales_morosidad["CE"], 2, ",", ".")." $" ?></p>
				<p><?= "Porcentaje de morosidad: ".round(($totales_morosidad["Total $"]/$total_cuotas_periodo)*100, 2)." %" ?></p>
			</div>
			<table style="width:100%; font-size: 14px; line-height: 16px;" class="noverScreen">
				<tbody>
					<tr>
						<td><b><?= $school->name ?></b></td>
					</tr>
					<tr>
						<td>RIF: <?= $school->rif ?></td>
					</tr>
					<tr>
						<td>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></td>
					</tr>
					<tr>
						<td><?= 'Consejo Educativo por Cobrar del período: '.$periodo_escolar ?></td>
					</tr>
					<tr>
						<td>Resumen</td>
					</tr>
					<tr>
						<td><?= "Monto total Consejo Educativo ".$periodo_escolar.": ".number_format($total_cuotas_periodo, 2, ",", ".")." $" ?></td>
					</tr>
					<tr>
						<td><?= "Consejo Educativo pagado: ".number_format(round($total_cuotas_periodo - $totales_morosidad["CE"], 2), 2, ",", ".")." $" ?></td>
					</tr>
					<tr>
						<td><?= "Consejo Educativo pendiente: ".number_format($totales_morosidad["CE"], 2, ",", ".")." $" ?></td>
					</tr>
					<tr>
						<td><?= "Porcentaje de morosidad: ".round(($totales_morosidad["Total $"]/$total_cuotas_periodo)*100, 2)." %" ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<div style="float: left; width: 100%;">
				<h4 style="text-align: left;">Detalle</h4>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Nro.</th>
							<th style="text-align:center;">Familia</th>
							<th style="text-align:center;">Monto pendiente</th>
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
							<td style="text-align:center;"><b><?= number_format($totales_morosidad["CE"], 2, ",", ".") ?></b></td>
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
								<td style="text-align:center;"><?= number_format($moroso["CE"], 2, ",", ".") ?></td>
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
			<br />
		</div>
	</div>
<?php
else: ?>
	<div class="row">
		<div class="col-md-4">
			<div class="page-header">
				<h4>Reporte de Consejo Educativo Por Cobrar</h4>
			</div>
			<?= $this->Form->create() ?>
				<fieldset>
					<?php
						echo $this->Form->input('periodo_escolar', ['label' => 'Período escolar: ', 'options' =>
							["" => "",
							$periodoEscolarAnterior => $periodoEscolarAnterior,
							$periodoEscolarActual => $periodoEscolarActual]]);
						echo $this->Form->input('grados', ['label' => 'Grados: ', 'options' =>
							[
								"" => "",
								'Todos' => 'Todos',
                                'Todos menos 5to. Año' => 'Todos menos 5to. Año',
								'5to. Año' => '5to. Año'
							]]);
						echo '<div id="quinto_anio_opciones" style="display:none; border: 1px solid #ccc; padding: 10px; margin-top: 10px;">';
						echo '<h5>Incluir:</h5>';
						echo '<div class="checkbox"><label>' . $this->Form->checkbox('condicion_regulares', ['value' => 'Regulares', 'id' => 'condicion-regulares']) . ' Regulares</label></div>';
						echo '<div class="checkbox"><label>' . $this->Form->checkbox('condicion_egresados', ['value' => 'Egresados', 'id' => 'condicion-egresados']) . ' Egresados</label></div>';
						echo "<div id='mensaje-condicion-estudiante' class='mensaje-usuario'></div>";
						echo '</div>';
						echo $this->Form->input('telefono', ['label' => 'Mostrar el número de teléfono del representante: ', 'options' =>
						["" => "",
						'Sí' => 'Sí',
						'No' => 'No',]]);
					?>
				</fieldset>
				<?= $this->Form->button(__('Crear reporte'), ['id' => 'crear-reporte', 'class' =>'btn btn-success']) ?>
			<?= $this->Form->end() ?>
			<br />
			<?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
		</div>
	</div>
<?php
endif; ?>
<script>
function myFunction()
{
    window.print();
}
$(document).ready(function()
{
	$('#grados').change(function() {
		if ($(this).val() === '5to. Año') {
			$('#quinto_anio_opciones').show();
		} else {
			$('#quinto_anio_opciones').hide();
			// Limpiar checkboxes
			$('#condicion-regulares').prop('checked', false);
			$('#condicion-egresados').prop('checked', false);
		}
	});

	$('#crear-reporte').click(function(e)
	{
		$(".mensaje-usuario").html("");

		indicadorError = 0;

		if ($('#periodo-escolar').val() == "")
		{
			indicadorError = 1;
			alert("Por favor seleccione el período escolar");
		}

		if ($('#grados').val() == "")
		{
			indicadorError = 1;
			alert("Por favor seleccione los grados");
		}
		else if ($('#grados').val() === '5to. Año')
		{
			var regularesChecked = $('#condicion-regulares').is(':checked');
			var egresadosChecked = $('#condicion-egresados').is(':checked');

			if (!regularesChecked && !egresadosChecked) {
				indicadorError = 1;
				$("#mensaje-condicion-estudiante").html("Debe seleccionar al menos una condición (Regulares o Egresados)").css("color", 'red');
			}
		}

		if ($('#telefono').val() == "")
		{
			indicadorError = 1;
			alert("Por favor seleccione si desea mostrar el teléfono");
		}

		if (indicadorError > 0)
		{
			return false;
		}
	});

	$("#exportar-excel").click(function(){

		$("#reporte-consejo-educativo-por-cobrar").table2excel({

			exclude: ".noExl",

			name: "reporte_consejo_educativo_por_cobrar",

			filename: $('#reporte-consejo-educativo-por-cobrar').attr('name')

		});
	});
});
</script>
