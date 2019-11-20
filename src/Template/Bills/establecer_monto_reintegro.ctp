<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Establecer el monto a reintegrar al representante</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('monto_reintegro', ['label' => 'Por favor indique el monto a reintegrar');
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Reintegrar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>