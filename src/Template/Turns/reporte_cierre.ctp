<?php
/**
 * Muestra la relación de cajeros y turnos de un consolidado y luego imprime
 * los mismos cuadros y detalles contables utilizados por el cierre diario,
 * presentando las fechas como día-mes-año.
 */
?>
<?php if (!empty($consolidadoPeriodo)): ?>
	<?php
	$fechaDesdeReporte = \DateTimeImmutable::createFromFormat('!Y-m-d', $desde)->format('d-m-Y');
	$fechaHastaReporte = \DateTimeImmutable::createFromFormat('!Y-m-d', $hasta)->format('d-m-Y');
	?>
	<div class="container" style="font-size: 12px; line-height: 16px;">
		<h2>Cierre consolidado de turnos</h2>
		<p><strong>Período:</strong> <?= h($fechaDesdeReporte) ?> al <?= h($fechaHastaReporte) ?></p>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Cajero o usuario</th>
						<th>Rol</th>
						<th>ID del turno</th>
						<th>Fecha del turno</th>
						<th>Tasa dólar</th>
						<th>Tasa euro</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turnosResumen as $turnoResumen): ?>
						<tr>
							<td><?= h($turnoResumen['cajero']) ?></td>
							<td><?= h($turnoResumen['rol']) ?></td>
							<td><?= h($turnoResumen['id']) ?></td>
							<td><?= h($turnoResumen['fecha']->format('d-m-Y H:i')) ?></td>
							<td class="text-right"><?= number_format((float)$turnoResumen['tasaDolar'], 2, ',', '.') ?></td>
							<td class="text-right"><?= number_format((float)$turnoResumen['tasaEuro'], 2, ',', '.') ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>
<?= $this->element('Turns/reporte_cierre_detalle', [
	'consolidadoPeriodo' => false,
	'esConsolidadoDetallado' => !empty($consolidadoPeriodo),
	'fechaDesdeReporte' => isset($fechaDesdeReporte) ? $fechaDesdeReporte : null,
	'fechaHastaReporte' => isset($fechaHastaReporte) ? $fechaHastaReporte : null
]) ?>
