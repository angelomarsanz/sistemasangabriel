<?php
/**
 * Historial de turnos con filtros de período y cierres individuales por cajero.
 */
?>
<div class="row">
    <div class="col-md-12">
		<?php if (!empty($puedeConsultarTodos)): ?>
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Filtros de reportes de cierre</strong></div>
				<div class="panel-body">
					<?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index'], 'class' => 'form-inline']) ?>
						<div class="form-group">
							<label for="periodo-desde">Del</label>
							<input class="form-control" type="date" id="periodo-desde" name="desde" value="<?= h($desde) ?>" required>
						</div>
						<div class="form-group">
							<label for="periodo-al">Al</label>
							<input class="form-control" type="date" id="periodo-al" name="al" value="<?= h($hasta) ?>" required>
						</div>
						<div class="form-group">
							<label for="modo-reporte">Mostrar</label>
							<select class="form-control" id="modo-reporte" name="modo" required>
								<option value="">Seleccione una opción</option>
								<option value="todos_separados" <?= $modo === 'todos_separados' ? 'selected' : '' ?>>Todos los turnos en reportes separados</option>
								<option value="todos_unico" <?= $modo === 'todos_unico' ? 'selected' : '' ?>>Todos los turnos en un único reporte</option>
								<?php foreach ($cajeros as $idCajero => $nombreCajero): ?>
									<option value="<?= h('usuario-' . $idCajero) ?>" <?= ($modo === 'usuario-' . $idCajero) ? 'selected' : '' ?>>Turnos de <?= h($nombreCajero) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Buscar</button>
					<?= $this->Form->end() ?>
				</div>
			</div>
		<?php endif; ?>
    	<div class="page-header">
			<h2><?= h($tituloTurnos) ?></h2>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
					<tr>
						<th scope="col">Fecha-hora inicio</th>
        				<th scope="col">Fecha-hora fin</th>
						<th scope="col">Nro.</th>
						<th scope="col" style="text-align:center">Turno</th>
						<th scope="col">Cajero</th>
						<?php
						if ($current_user['id'] == 1 || $current_user['id'] == 978): ?>
							<th scope="col" style="text-align:center">Fiscal</th>
						<?php
						endif ?>  
						<th scope="col">Estatus</th>
						<th scope="col" class="actions"></th>
						<?php
						if ($current_user['role'] == 'Administrador' || $current_user['role'] == 'Propietario' || $current_user['role'] == 'Ventas generales' || $current_user['role'] == 'Contabilidad general' ): ?>
							<th scope="col" class="actions"></th>
							<th scope="col" class="actions"></th>
							<th scope="col" class="actions"></th>
						<?php
						endif ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turns as $turn): ?>
						<tr>
							<td>
								<?= h($turn->start_date->format('d-m-Y')) ?><br>
								<?= h($turn->start_date->format('h:i a')) ?>
							</td>
							<td>
								<?= h($turn->end_date->format('d-m-Y')) ?><br>
								<?= h($turn->end_date->format('h:i a')) ?>
							</td>
							<td><?= h($turn->id) ?></td>
							<td style="text-align:center"><?= h($turn->turn) ?></td>
							<td><?= h($turn->user->first_name . ' ' . $turn->user->surname) ?></td>
							<?php
							if ($current_user['id'] == 1 || $current_user['id'] == 978): 
								if ($turn->user->role == 'Seniat'): ?>
									<td style="text-align:center">Sí</td>
								<?php
								else: ?>
									<td style="text-align:center">No</td>
								<?php endif; 
							endif; ?>
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
							<?php
							if ($current_user['role'] == 'Administrador' || $current_user['role'] == 'Propietario' || $current_user['role'] == 'Ventas generales' || $current_user['role'] == 'Contabilidad general' ): ?>
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
							<?php 
							endif ; ?>
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