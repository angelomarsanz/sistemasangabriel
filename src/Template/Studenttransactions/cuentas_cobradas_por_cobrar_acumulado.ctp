<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Cuentas Cobradas y por Cobrar (Acumulado)</h3>
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
	                echo $this->Form->input('mes_desde', ['label' => 'Desde:* ', 'options' => 
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
					echo "<div id='mensaje-mes-desde' class='mensajes-usuario'></div>";
					echo $this->Form->input('mes_hasta', ['label' => 'Hasta:* ', 'options' => 
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
				echo "<div id='mensaje-mes-hasta' class='mensajes-usuario'></div>";
				echo "<div id='mensaje-orden-meses' class='mensajes-usuario'></div>";
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
	var ordenMeses = 
	{
		"09" : "01",
		"10" : "02",
		"11" : "03",
		"12" : "04",
		"01" : "05",
		"02" : "06",
		"03" : "07",
		"04" : "08",
		"05" : "09",
		"06" : "10",
		"07" : "11"
	} 

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

            if ($('#mes-desde').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-mes-desde").html("Por favor seleccione un mes").css("color", 'red');
			}
            
			if ($('#mes-hasta').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-mes-hasta").html("Por favor seleccione un mes").css("color", 'red');
			}
			
			if (ordenMeses[$('#mes-desde').val()] > ordenMeses[$('#mes-hasta').val()])
			{
				indicadorError = 1;
				$("#mensaje-orden-meses").html("El orden en los meses para el período solicitado está invertido").css("color", 'red');
			}
			
			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos o presentan errores. Por favor revise");
				e.preventDefault();
			}
		});
	});
</script>