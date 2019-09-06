<div class="row">
    <div class="col-md-8">
    	<div class="page-header">
    	    <h3><?= __('Eventos del usuario') ?></h3>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col"><?= $this->Paginator->sort('created', 'Fecha y hora') ?></th>
						<th scope="col"><?= $this->Paginator->sort('descripcion', 'Evento') ?></th>
						<th scope="col"><?= $this->Paginator->sort('usuario_responsable', 'Usuario responsable') ?></th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($eventos as $evento): ?>
					<tr>
						<td><?= h($evento->created->format('d/m/Y H:i:s')) ?></td>
						<td><?= h($evento->descripcion)  ?></td>
						<td><?= h($evento->usuario_responsable) ?></td>
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