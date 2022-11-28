<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Establecer el monto a reintegrar al representante</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('monto_reintegro', ['type' => 'number', 'label' => 'Por favor indique el monto a reintegrar', 'value' => $monto]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Reintegrar'), ['id' => 'reintegrar', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		montoMaximoReintegro = <?= $monto ?>;
		
        $('#reintegrar').click(function(e) 
		{            
            if ($("#monto-reintegro").val() < 0)
            {    
                alert("Estimado usuario no puede reintegrar un valor negativo");   
                return false;
            }
			if ($("#monto-reintegro").val() > montoMaximoReintegro)
			{    
				alert("Estimado usuario no puede reintegrar un monto mayor a " + montoMaximoReintegro);   
				return false;
			}
		});
	});
</script>