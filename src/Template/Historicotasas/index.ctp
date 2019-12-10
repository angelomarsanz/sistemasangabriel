<div class="row">
    <div class="col-md-8">
    	<div class="page-header">
    	    <h3><?= __('Histórico cambio tasas dólar y euro') ?></h3>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col"><?= $this->Paginator->sort('created', 'Fecha y hora') ?></th>
						<th scope="col" style="text-align: center;"><?= $this->Paginator->sort('moneda', 'Moneda') ?></th>
						<th scope="col" style="text-align: center;"><?= $this->Paginator->sort('tasa_cambio_dolar', 'Tasa de cambio dólar') ?></th>
						<th scope="col"><?= $this->Paginator->sort('usuario_responsable', 'Usuario responsable') ?></th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($historicotasas as $historicotasa): ?>
					<tr>
						<td><?= h($historicotasa->created->format('d/m/Y H:i:s')) ?></td>
						<td style="text-align: center;"><?= h($historicotasa->moneda->moneda) ?></td>
						<td style="text-align: center;"><?= number_format(($historicotasa->tasa_cambio_dolar), 2, ",", ".")  ?></td>
						<td><?= h($historicotasa->usuario_responsable) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="paginator">
			<ul class="pagination">
				<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('Siguiente') . ' >') ?>
			</ul>
			<p><?= $this->Paginator->counter() ?></p>
		</div>
	</div>
</div>