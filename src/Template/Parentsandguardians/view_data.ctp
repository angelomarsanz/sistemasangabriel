<?php
    /**
     * Vista de opciones de la familia consultada y actualización de sus estados.
     */
    use Cake\Routing\Router;
?>
<br />
<div class="page-header">
    <p><?= $this->Html->link(__('Volver'), ['controller' => 'Parentsandguardians', 'action' => 'consultFamily'], ['class' => 'btn btn-sm btn-default']) ?></p>
    <h4>Familia: <?= $family ?></h4>
	<input type="hidden" id="ambiente" value=<?= $schools->ambient ?> />
	<input type="hidden" id="id-user" value=<?= $user->id ?> />
</div>
<div>
	<?php if (isset($current_user['role']) && in_array($current_user['role'], ['Administrador', 'Propietario', 'Ventas generales', 'Contabilidad general', 'Control de estudios']) && $accionFamilia !== null): ?>
		<button
			type="button"
			id="cambiar-estatus-familia"
			class="btn <?= $accionFamilia === 'Activar familia' ? 'btn-success' : 'btn-warning' ?>"
			data-id-family="<?= (int)$idFamily ?>"
		><?= h($accionFamilia) ?></button>
		<br />
		<br />
	<?php endif; ?>
	<?php if(isset($current_user['role'])): ?>
		<?php if($current_user['role'] == 'Administrador' || $current_user['role'] == 'Propietario' || $current_user['role'] == 'Ventas generales' || $current_user['role'] == 'Contabilidad general' ): ?>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Actualizar usuario</button>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Actualizar usuario</h4>
					</div>
					<div class="modal-body">
						<p><input type="number" id="username" value=<?= $user->username ?> class="form-control" /></p>
						<p><input type="password" id="password" value=<?= $user->password ?> class="form-control" /></p>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					  <button id="actualizar" "type="button" class="btn btn-success" data-dismiss="modal">Actualizar</button>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>
	<br />
	<br />
	<?= $this->Html->link('Ver datos de la familia', ['action' => 'view', $idFamily], ['class' => 'btn btn-success']); ?>
	<br />
	<br />
	<?= $this->Html->link('Ver alumnos', ['controller' => 'Students', 'action' => 'indexConsult', $idFamily, $family], ['class' => 'btn btn-success']); ?>
	<br />
	<br />
	<?php if(isset($current_user['role'])): ?>
		<?php if($current_user['role'] == 'Administrador' || $current_user['role'] == 'Propietario' || $current_user['role'] == 'Ventas generales' || $current_user['role'] == 'Contabilidad general' ): ?> 
		<?= $this->Html->link('Ver facturas', ['controller' => 'Bills' , 'action' => 'index', $idFamily, $family], ['class' => 'btn btn-success']); ?>
		<br />
		<br />
		<?php endif; ?>
	<?php endif; ?>
</div>
<div class="modal fade" id="resultado-estatus-familia" tabindex="-1" role="dialog" aria-labelledby="titulo-resultado-estatus-familia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="titulo-resultado-estatus-familia">Actualización de la familia</h4>
			</div>
			<div class="modal-body">
				<p id="mensaje-resultado-estatus-familia"></p>
				<ul id="estudiantes-actualizados"></ul>
				<p id="sin-estudiantes-actualizados" class="hidden">No hubo estudiantes cuyo estado necesitara cambiar.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
			</div>
		</div>
	</div>
</div>
<script>
	/**
	 * Envía el cambio de estado y presenta el resultado en un modal.
	 *
	 * @param {jQuery} boton Botón que inició la solicitud.
	 */
	function actualizarEstadoFamilia(boton)
	{
		boton.prop('disabled', true);

		$.ajax({
			url: '<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "cambiarEstatusFamilia"]); ?>',
			method: 'POST',
			dataType: 'json',
			data: {idFamily: boton.data('id-family')}
		})
		.done(function(response)
		{
			if (!response.success)
			{
				alert(response.message);
				return;
			}

			boton.text(response.buttonText);
			boton.removeClass('btn-success btn-warning');
			boton.addClass(response.buttonText === 'Activar familia' ? 'btn-success' : 'btn-warning');

			$('#mensaje-resultado-estatus-familia').text(
				'Se ' + response.accion + ' la familia ' + response.familia +
				' y los estudiantes que la integran:'
			);

			const listaEstudiantes = $('#estudiantes-actualizados').empty();
			if (response.estudiantes.length > 0)
			{
				$('#sin-estudiantes-actualizados').addClass('hidden');
				response.estudiantes.forEach(function(estudiante)
				{
					listaEstudiantes.append($('<li>').text(estudiante.nombre));
				});
			}
			else
			{
				$('#sin-estudiantes-actualizados').removeClass('hidden');
			}

			$('#resultado-estatus-familia').modal('show');
		})
		.fail(function(jqXHR)
		{
			const respuesta = jqXHR.responseJSON;
			alert(respuesta && respuesta.message ? respuesta.message : 'No se pudo actualizar el estado de la familia.');
		})
		.always(function()
		{
			boton.prop('disabled', false);
		});
	}

	/**
	 * Inicializa las acciones AJAX disponibles en las opciones de la familia.
	 */
    $(document).ready(function() 
    {
		$('#cambiar-estatus-familia').on('click', function()
		{
			actualizarEstadoFamilia($(this));
		});

		updateUsername = '<?php echo Router::url(["controller" => "Users", "action" => "updateUsername"]); ?>'
		
        $('#actualizar').click(function(e) 
        {
            e.preventDefault();
            
            $.post(updateUsername, { username : $("#username").val(), idUser : $("#id-user").val() }, null, "json")
                
            .done(function(response) 
            {
                if (response.success == true) 
                {
                    alert(response.message);
                }        
				else
				{
					alert(response.message);
				}
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                alert('algo falló en el programa');
            });
        });
	});
</script>