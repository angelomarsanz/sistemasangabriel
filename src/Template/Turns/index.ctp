<?php
/**
 * Historial de turnos con filtros de período, búsqueda por cajeros y acceso a
 * reportes consolidados; distingue los usuarios por rol y omite cuentas técnicas.
 */
?>
<div class="row">
    <div class="col-md-12">
		<?php if (!empty($puedeConsultarTodos)): ?>
			<h3>Opciones del reporte de cierre</h3>
			<?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index'], 'id' => 'form-filtros-cierre']) ?>
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Seleccionar rango de fecha</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6 form-group">
								<label for="periodo-desde">Del</label>
								<input class="form-control" type="date" id="periodo-desde" name="desde" value="<?= h($desde) ?>" required>
							</div>
							<div class="col-sm-6 form-group">
								<label for="periodo-al">Al</label>
								<input class="form-control" type="date" id="periodo-al" name="al" value="<?= h($hasta) ?>" required>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-primary js-panel-reporte" data-panel="busqueda">
							<div class="panel-heading">
								<strong>Búsqueda de Reportes de Cierre</strong>
									<button type="button" class="btn btn-default btn-xs pull-right js-activar-panel" data-activa="busqueda" aria-label="Activar búsqueda de reportes">Usar este panel</button>
							</div>
							<fieldset class="panel-body js-controles-panel">
								<p>Seleccione uno o varios usuarios para consultar sus cierres por separado.</p>
								<div class="row">
									<?php foreach ($cajeros as $idCajero => $datosCajero): ?>
										<div class="col-sm-6">
											<label class="checkbox-inline">
												<input type="checkbox" name="usuarios_busqueda[]" value="<?= h($idCajero) ?>" class="js-usuario-busqueda" <?= in_array($idCajero, $usuariosBusquedaSeleccionados, true) ? 'checked' : '' ?>>
												<?= h($datosCajero['etiqueta']) ?>
											</label>
										</div>
									<?php endforeach; ?>
								</div>
								<button type="submit" name="modo" value="buscar" class="btn btn-primary btn-block">Buscar</button>
							</fieldset>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-success js-panel-reporte" data-panel="consolidado">
							<div class="panel-heading">
								<strong>Consolidado de Reporte de Cierre</strong>
								<button type="button" class="btn btn-default btn-xs pull-right js-activar-panel" data-activa="consolidado" aria-label="Activar consolidado de reportes">Usar este panel</button>
							</div>
							<fieldset class="panel-body js-controles-panel">
								<p>Seleccione uno o varios usuarios con el mismo tipo de rol.</p>
								<div class="row">
									<?php foreach ($cajeros as $idCajero => $datosCajero): ?>
										<div class="col-sm-6">
											<label class="checkbox-inline">
												<input type="checkbox" name="usuarios_consolidado[]" value="<?= h($idCajero) ?>" data-rol="<?= h($datosCajero['rol']) ?>" class="js-usuario-consolidado" <?= $modo === 'consolidar' && in_array($idCajero, $usuariosSeleccionados, true) ? 'checked' : '' ?>>
												<?= h($datosCajero['etiqueta']) ?>
											</label>
										</div>
									<?php endforeach; ?>
								</div>
								<button type="submit" name="modo" value="consolidar" class="btn btn-success btn-block">Generar reporte consolidado</button>
							</fieldset>
						</div>
					</div>
				</div>
			<?= $this->Form->end() ?>
			<div class="modal fade" id="modal-roles-cajeros" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-roles" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="titulo-modal-roles">Selección de usuarios no válida</h4>
						</div>
						<div class="modal-body">Se deben seleccionar usuarios que tengan el mismo tipo de rol</div>
						<div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button></div>
					</div>
				</div>
			</div>
			<script>
				$(function() {
					const $formulario = $('#form-filtros-cierre');
					const $campoDesde = $('#periodo-desde');
					const $campoHasta = $('#periodo-al');
					const $panelBusqueda = $('.js-panel-reporte[data-panel="busqueda"]');
					const $panelConsolidado = $('.js-panel-reporte[data-panel="consolidado"]');

					const activarPanel = (nombrePanel) => {
						const esBusqueda = nombrePanel === 'busqueda';
						const $panelActivo = esBusqueda ? $panelBusqueda : $panelConsolidado;
						const $panelInactivo = esBusqueda ? $panelConsolidado : $panelBusqueda;
						$panelInactivo.find('input[type="checkbox"]').prop('checked', false);
						$panelInactivo.attr('data-activo', 'false');
						$panelActivo.attr('data-activo', 'true');
						$panelActivo.removeClass('panel-default').addClass(esBusqueda ? 'panel-primary' : 'panel-success');
						$panelInactivo.removeClass(esBusqueda ? 'panel-success' : 'panel-primary').addClass('panel-default');
					};

					$('.js-activar-panel').on('click', function() {
						activarPanel($(this).data('activa'));
					});
					$('.js-usuario-busqueda').on('focus click change', function() {
						activarPanel('busqueda');
					});
					$('.js-usuario-consolidado').on('focus click change', function() {
						activarPanel('consolidado');
					});
					$('.js-usuario-consolidado').on('change', function() {
						const rolesSeleccionados = $('.js-usuario-consolidado:checked').map(function() {
							return $(this).data('rol');
						}).get();
						if (new Set(rolesSeleccionados).size > 1) {
							$(this).prop('checked', false);
							$('#modal-roles-cajeros').modal('show');
						}
					});

					$formulario.on('submit', function(evento) {
						const elementoEnvio = evento.originalEvent && evento.originalEvent.submitter;
						const modo = elementoEnvio
							? elementoEnvio.value
							: ($('.js-usuario-consolidado:checked').length ? 'consolidar' : 'buscar');
						const nombreUsuarios = modo === 'consolidar' ? 'usuarios_consolidado[]' : 'usuarios_busqueda[]';
						if (!$campoDesde.val() || !$campoHasta.val()) {
							evento.preventDefault();
							(!$campoDesde.val() ? $campoDesde : $campoHasta).trigger('focus');
							return;
						}
						if ($campoDesde.val() > $campoHasta.val()) {
							evento.preventDefault();
							window.alert('La fecha inicial no puede ser posterior a la fecha final.');
							return;
						}
						if (!$formulario.find('input[name="' + nombreUsuarios + '"]:checked').length) {
							evento.preventDefault();
							window.alert('Seleccione al menos un usuario para generar el reporte.');
						}
					});

					if ($('.js-usuario-busqueda:checked').length) {
						activarPanel('busqueda');
					}
				});
			</script>
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