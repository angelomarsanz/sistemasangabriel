<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Recibo de compra</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
					echo $this->Form->input('moneda', ['label' => 'Moneda:', 'id' => 'moneda', 'options' => 
						[null => '',
						'2' => '$',
						'3' => '€',
						'1' => 'Bs.']]);
					echo $this->Form->input('concepto', ['type' => 'text', 'label' => 'Concepto:']);
	                echo $this->Form->input('monto', ['id' => 'monto', 'type' => 'number', 'label' => 'Monto:', 'value' => 0]);
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