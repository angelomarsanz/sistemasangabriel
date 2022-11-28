<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Anular factura o recibo</h3>
	        <h5 id="Turno" value=<?= $idTurn ?>>Fecha: <?= $dateTurn->format('d-m-Y') ?>, Turno: <?= $turn ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h5>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('bill_number', ['label' => 'Por favor escriba el número de la factura o recibo: ']);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Anular'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>