<?php
/**
 * Muestra los controles de verificación y cierre junto al detalle compartido del reporte.
 */
use Cake\Routing\Router;
?>
<style>
@media screen {
	.noverScreen { display: none; }
}
@media print {
	.noVerImpreso { display: none; }
}
</style>
<div class="container noVerImpreso">
	<h3 id="Turno" value="<?= h($turn->id) ?>">Cerrar turno: <?= h($turn->turn) ?></h3>
	<p><strong>TURNO NO CERRADO</strong></p>
	<p>Fecha: <?= h($turn->start_date->format('d-m-Y')) ?>, Cajero: <?= h($cajero) ?></p>
	<div id="factura-control" class="row">
		<div class="col-sm-8 col-md-6">
			<p>Por favor introduzca el Nro. de control de la factura <b><?= h($lastNumber) ?></b></p>
			<?= $this->Form->input('control_number', ['label' => 'Nro. Control:']) ?>
			<button id="verificar" type="button" class="btn btn-success">Verificar si se saltó el número de control</button>
		</div>
	</div>
</div>
<div id="contadores">
	<?= $this->element('Turns/reporte_cierre_detalle', [
		'consolidadoPeriodo' => false,
		'esConsolidadoDetallado' => false
	]) ?>
</div>
<div class="container noVerImpreso">
	<?= $this->Form->create($turn) ?>
		<?= $this->Form->button(__('Cerrar turno'), ['id' => 'cerrar-turno', 'class' => 'btn btn-success']) ?>
	<?= $this->Form->end() ?>
</div>
<script>
	/** Prepara la verificación del control fiscal antes de cerrar el turno. */
	$(document).ready(function() {
		const ultimoNumero = <?= json_encode((string)$lastNumber, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
		const ultimoControl = <?= json_encode((string)$lastControl, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
		const idTurno = <?= json_encode((string)$turn->id, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
		const urlControl = <?= json_encode(Router::url(['controller' => 'Bills', 'action' => 'editControl']), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

		if (ultimoNumero == '0') {
			$('#factura-control').addClass('noverScreen');
		} else {
			$('#contadores, #cerrar-turno').addClass('noverScreen');
		}

		/** Verifica el número de control o redirige a su corrección. */
		$('#verificar').click(function() {
			if ($('#control-number').val() == ultimoControl) {
				alert('Felicidades ! Los números de control están correctos, puede continuar con el cierre de turno');
				$('#factura-control').addClass('noverScreen');
				$('#contadores, #cerrar-turno').removeClass('noverScreen');
			} else {
				$.redirect(urlControl, {turn: idTurno});
			}
		});
	});
</script>
