<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <h2><?= "Histórico de turnos correspondientes a " . $current_user['first_name'] . ' ' . $current_user['surname'] ?></h2>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
					<tr>
						<th scope="col">Fecha</th>
						<th scope="col">Turno</th>
						<th scope="col">Cajero</th>
						<th scope="col">Estatus</th>
						<th scope="col" class="actions"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turns as $turn): ?>
						<tr>
							<td><?= h($turn->start_date->format('d-m-Y')) ?></td>
							<td><?= h($turn->turn) ?></td>
							<td><?= h($turn->user->first_name . ' ' . $turn->user->surname) ?></td>
							<?php if ($turn->status == 0): ?>
								<td>Cerrado</td>
							<?php else: ?>
								<td>Abierto</td>
							<?php endif; ?>
							<td class="actions">
								<?php 
									if ($turn->status == 0):
										echo $this->Html->link('Imprimir', ['action' => 'turnpdf', $turn->id, $turn->user->first_name . ' ' . $turn->user->surname, '_ext' => 'pdf'], ['class' => 'btn btn-success']); 
									endif;
								?>
							</td>
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