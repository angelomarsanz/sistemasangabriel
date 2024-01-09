<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h4>Familias con diferencias de mensualidades adelantadas</h4>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('mes', ['label' => 'Mes: ', 'options' => 
	                    ["" => "",
	                    '09' => 'Septiembre',
	                    '10' => 'Octubre',
	                    '11' => 'Noviembre',
	                    '12' => 'Diciembre',
						'01' => 'Enero',
	                    '02' => 'Febrero',
	                    '03' => 'Marzo',
	                    '04' => 'Abril',
	                    '05' => 'Mayo',
	                    '06' => 'Junio',
	                    '07' => 'Julio']]); 
					echo "<div id='mensaje-mes' class='mensaje-usuario'></div>";
					echo "<br />"
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Crear reporte'), ['id' => 'crear-reporte', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$('#crear-reporte').click(function(e) 
        {		
			$(".mensaje-usuario").html("");
			
			indicadorError = 0;
            
            if ($('#mes').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-mes").html("Por favor seleccione un mes").css("color", 'red');
			}
            
			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos. Por favor revise");
				return false;
			}
		});
	});
</script>