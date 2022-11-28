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
						<th scope="col">Nro.</th>
						<th scope="col" style="text-align:center">Turno</th>
						<th scope="col">Cajero</th>
						<th scope="col">Estatus</th>
						<th scope="col" class="actions"></th>
						<th scope="col" class="actions"></th>
						<th scope="col" class="actions"></th>
						<th scope="col" class="actions"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turns as $turn): ?>
						<tr>
							<td><?= h($turn->start_date->format('d-m-Y')) ?></td>
							<td><?= h($turn->id) ?></td>
							<td style="text-align:center"><?= h($turn->turn) ?></td>
							<td><?= h($turn->user->first_name . ' ' . $turn->user->surname) ?></td>
							<?php if ($turn->status == 0): ?>
								<td>Cerrado</td>
							<?php else: ?>
								<td>Abierto</td>
							<?php endif; ?>	
							<td class="actions">
								<?php 
									if ($turn->status == 0):
										if ($turn->id > 970):
											echo $this->Html->link('Reporte cierre', ['action' => 'reporteCierre', $turn->id], ['class' => 'btn btn-info']);
										else:
											echo $this->Html->link('Reporte cierre', ['action' => 'turnpdf', $turn->id, $turn->user->first_name . ' ' . $turn->user->surname, '_ext' => 'pdf'], ['class' => 'btn btn-info']); 
										endif;
									endif;
								?>
							</td>
							<td class="actions">
								<?php 
									if ($turn->status == 0):
										if ($turn->id > 970):
											echo $this->Html->link('Reporte contador', ['action' => 'reporteContador', $turn->id], ['class' => 'btn btn-info', 'disabled' => 'disabled']);
										endif;
									endif;
								?>
							</td>
							<td class="actions">
								<?php 
									if ($turn->status == 0):
										if ($turn->id > 970):
											echo $this->Html->link('Documentos', ['action' => 'excelDocumentos', $turn->id], ['class' => 'btn btn-info']);
										endif;
									endif;
								?>
							</td>
							<td class="actions">
								<?php 
									if ($turn->status == 0):
										if ($turn->id > 970):
											echo $this->Html->link('Pagos', ['action' => 'excelPagos', $turn->id], ['class' => 'btn btn-info']);											
										endif;
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