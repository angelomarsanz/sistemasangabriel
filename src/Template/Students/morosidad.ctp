<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Reporte de Morosidad</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('mes', ['label' => 'Mes: ', 'options' => 
	                    ["" => "",
						'01' => 'Enero',
	                    '02' => 'Febrero',
	                    '03' => 'Marzo',
	                    '04' => 'Abril',
	                    '05' => 'Mayo',
	                    '06' => 'Junio',
	                    '07' => 'Julio',
	                    '08' => 'Agosto',
	                    '09' => 'Septiembre',
	                    '10' => 'Octubre',
	                    '11' => 'Noviembre',
	                    '12' => 'Diciembre']]); 
					echo "<div id='mensaje-mes' class='mensaje-usuario'></div>";
	               	echo $this->Form->input('ano', ['label' => 'Año: ', 'options' => 
	                    ["" => "",
						'2018' => '2018',
	                    '2019' => '2019',
	                    '2020' => '2020',
						'2021' => '2021',
						'2022' => '2022',
						'2023' => '2023']]);
					echo "<div id='mensaje-ano' class='mensaje-usuario'></div>";
	               	echo $this->Form->input('tipo_reporte', ['label' => 'Tipo de reporte: ', 'options' => 
	                    ["" => "",
						'Total general' => 'Total general',
	                    'Por grado' => 'Por grado']]);
					echo "<div id='mensaje-tipo-reporte' class='mensaje-usuario'></div>";
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
            
			if ($('#ano').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-ano").html("Por favor seleccione un año").css("color", 'red');
			}			
			
			if ($('#tipo-reporte').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-tipo-reporte").html("Por favor seleccione el tipo de reporte").css("color", 'red');
			}			
			
			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos. Por favor revise");
				return false;
			}
		});
	});
</script>