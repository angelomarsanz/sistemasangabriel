<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Anular factura o recibo</h3>
	        <h5 id="Turno" value=<?= $idTurn ?>>Fecha: <?= $dateTurn->format('d-m-Y') ?>, Turno: <?= $turn ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h5>
	    </div>
		<?php
		if ($current_user['username'] == 'angel2703')
		{
			$vector_opciones_anulacion = 
				[
					"" => "",
					'Factura' => 'Factura',
					'Pedido' => 'Pedido',
					'Recibo de anticipo' => 'Recibo de anticipo',
					'Recibo de compra' => 'Recibo de compra',
					'Recibo de Consejo Educativo' => 'Recibo de Consejo Educativo',
					'Recibo de reintegro' => 'Recibo de reintegro',
					'Recibo de seguro' => 'Recibo de seguro',
					'Recibo de servicio educativo' => 'Recibo de servicio educativo',
					'Recibo de vuelto de compra' => 'Recibo de vuelto de compra'
				]; 
		} 
		else
		{
			$vector_opciones_anulacion = 
				[
					"" => "",
					'Pedido' => 'Pedido',
					'Recibo de anticipo' => 'Recibo de anticipo',
					'Recibo de compra' => 'Recibo de compra',
					'Recibo de Consejo Educativo' => 'Recibo de Consejo Educativo',
					'Recibo de reintegro' => 'Recibo de reintegro',
					'Recibo de seguro' => 'Recibo de seguro',
					'Recibo de servicio educativo' => 'Recibo de servicio educativo',
					'Recibo de vuelto de compra' => 'Recibo de vuelto de compra'
				]; 
		} ?>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
				echo $this->Form->input('bill_number', ['label' => 'Número de la factura o recibo: ']);
				echo $this->Form->input('tipo_documento', ['label' => 'Tipo de documento: ', 'options' => $vector_opciones_anulacion]); 
				?>
		    </fieldset>
			<?= $this->Form->button(__('Anular'), ['class' =>'btn btn-success']); ?>
		<?= $this->Form->end(); ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>