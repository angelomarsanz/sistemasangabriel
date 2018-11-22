<?php
    use Cake\I18n\Time;
	use Cake\Routing\Router;
?>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="page-header">
				<?php if (isset($controller) && isset($action)): ?>
					<p><?= $this->Html->link(__('Volver'), ['controller' => $controller, 'action' => $action, $id], ['class' => 'btn btn-sm btn-default']) ?></p>
				<?php endif; ?>
				<h3><?= "Reasignar familia al alumno: " . $nameStudent ?></h3>
			</div>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="row panel">
						<div class="col-md-6">
							<br />
							<?php
								setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
								date_default_timezone_set('America/Caracas');
							?>										
								<input type="text" id="family" class="form-control" placeholder="Buscar familia..." title="Escriba los apellidos de la familia"/>
						</div>
					</div>
				</fieldset>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
	function log(id) 
	{
		console.log('Entre a log y el valor de id es: ' + <?= $id ?>);
		// $.redirect('<?php echo Router::url(array("controller" => "Students", "action" => "editFamily")); ?>', { idStudent : <?= $id ?>, idFamily : id });
	}
    $(document).ready(function() 
    {
		$('#family').autocomplete(
		{
			source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
			minLength: 3,             
			select: function( event, ui ) {
				log(ui.item.id, ui.item.value);
			  }
		});	
    });
</script>