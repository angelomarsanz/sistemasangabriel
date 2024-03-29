<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Recibo de vuelto de compra</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
					echo $this->Form->input('id_recibo_original', ['id' => 'id_recibo_original', 'label' => 'Este vuelto corresponde al recibo con el Nro.', 'required' => 'required', 'options' => $opciones_recibos]);
					echo $this->Form->input('concepto', ['type' => 'text', 'label' => 'Concepto:', 'required' => 'required']);
	                echo $this->Form->input('monto', ['id' => 'monto', 'type' => 'number', 'label' => 'Monto:', 'value' => 0, 'required' => 'required']);
					echo $this->Form->input('moneda', ['label' => 'Moneda:', 'id' => 'moneda', 'required' => 'required', 'options' => 
						[null => '',
						'1' => 'Bs.',
						'2' => '$',
						'3' => '€',]]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Guardar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
	</div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#guardar').click(function(e) 
		{            
            if ($("#monto").val() < 1)
            {    
                alert("Estimado usuario el monto debe ser mayor a cero");   
                return false;
            }
		});
	});
</script>