<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Relación de mensualidades</h3>
	    </div>
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
</div>