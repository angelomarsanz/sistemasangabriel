<div class="page-header">
    <p><?= $this->Html->link(__('Volver'), ['controller' => 'Parentsandguardians', 'action' => 'consultFamily'], ['class' => 'btn btn-sm btn-default']) ?></p>
    <h4>Familia: <?= $family ?></h4>
	<input type="hidden" id="ambiente" value=<?= $schools->ambient ?> />
	<input type="hidden" id="id-user" value=<?= $user->id ?> />
</div>
<div>
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
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				  <button id="actualizar" "type="button" class="btn btn-success" data-dismiss="modal">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<br />
	<br />
	<?= $this->Html->link('Ver datos de la familia', ['action' => 'view', $idFamily], ['class' => 'btn btn-success']); ?>
	<br />
	<br />
	<?= $this->Html->link('Ver alumnos', ['controller' => 'Students', 'action' => 'indexConsult', $idFamily, $family], ['class' => 'btn btn-success']); ?>
	<br />
	<br />
	<?= $this->Html->link('Ver facturas', ['controller' => 'Bills' , 'action' => 'index', $idFamily, $family], ['class' => 'btn btn-success']); ?>
	<br />
	<br />
</div>
<script>
    $(document).ready(function() 
    {
		if ($('#ambiente').val() == 'Producción')
		{
			updateUsername = '/sistemasangabriel/users/updateUsername';
		}
		else
		{
			updateUsername = '/desarrollosistemasangabriel/users/updateUsername';
		}
		
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