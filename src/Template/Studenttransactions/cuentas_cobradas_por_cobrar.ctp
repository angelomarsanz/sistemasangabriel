<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Reporte de Cuentas Cobradas y por Cobrar</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	               	echo $this->Form->input('tipo_reporte', ['label' => 'Tipo de reporte:* ', 'options' => 
					   ["" => "",
					   'Totales generales' => 'Totales generales',
					   'Por grado' => 'Por grado',
					   'Por estudiante' => 'Por estudiante']]);
					echo "<div id='mensaje-tipo-reporte' class='mensajes-usuario'></div>";
	                echo $this->Form->input('concepto', ['label' => 'Concepto:* ', 'options' => 
	                    ["" => "",
						'13' => 'Matrícula',
						'14' => 'Seguro escolar',
						'15' => 'Servicio educativo',
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
	                    '07' => 'Julio',
						'08' => 'Agosto']]); 
					echo "<div id='mensaje-concepto' class='mensajes-usuario'></div>";
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
			$(".mensajes-usuario").html("");
			
			indicadorError = 0;

			if ($('#tipo-reporte').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-tipo-reporte").html("Por favor seleccione el tipo de reporte").css("color", 'red');
			}

            if ($('#concepto').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-concepto").html("Por favor seleccione un concepto").css("color", 'red');
			}
            
			if ($('#periodo-escolar').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-periodo-escolar").html("Por favor seleccione el período escolar").css("color", 'red');
			}
			
			if ($('#acumulado').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-acumulado").html("Por favor seleccione si el reporte es acumulado o no").css("color", 'red');
			}	
			
			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos. Por favor revise");
				e.preventDefault();
			}
		});
	});
</script>