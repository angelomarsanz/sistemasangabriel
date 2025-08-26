<?php
    use Cake\Routing\Router; 
?>
<div id='ruta-datos-reporte-formas-de-pago' class='noVerEnPantalla noVerImpreso'><?= Router::url(array("controller" => "Payments", "action" => "datosReporteFormasDePago")); ?></div>
<div class="page-header">
    <h3>Relación de mensualidades</h3>
</div>
<div class="row">
	<div class="col-md-4">
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
		        	echo $this->Form->input('section_id', ['label' => 'Sección:*', 'options' => $sections]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Imprimir'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'home'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
	<div id='formulario-formas-de-pago' class="col-md-8">
	</div>
</div>
<div class="row">
	<div id='reporte-formas-de-pago' class="col-md-12">
	</div>
</div>