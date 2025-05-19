<div class="row">
<?php
	// debug($mesesTarifas);
?>
<div class="col-md-4">
		<div class="page-header">
	        <h4>Reporte General de Morosidad de Representantes</h4>
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
	               	echo $this->Form->input('periodo_escolar', ['label' => 'Período escolar: ', 'options' => 
	                    ["" => "",
						'2023-2024' => '2023-2024',
						'2024-2025' => '2024-2025']]);
					echo "<div id='mensaje-periodo-escolar' class='mensaje-usuario'></div>";
					echo $this->Form->input('indicador_recalculo', ['label' => 'Desea recalcular las cuotas atrasadas de acuerdo con la tarifa vigente ?: ', 'options' => 
						["" => "",
							'Sí' => 'Sí',
							'No' => 'No',]]);
					echo "<div id='mensaje-indicador-recalculo' class='mensaje-usuario'></div>";
					echo $this->Form->input('consejo_educativo', ['label' => 'Desea mostrar la deuda de Consejo Educativo ?: ', 'options' => 
					["" => "",
						'Sí' => 'Sí',
						'No' => 'No',]]);
					echo "<div id='mensaje-consejo-educativo' class='mensaje-usuario'></div>";
					echo $this->Form->input('telefono', ['label' => 'Mostrar el número de teléfono del representante: ', 'options' => 
						["" => "",
						'Sí' => 'Sí',
						'No' => 'No',]]);
					echo "<div id='mensaje-telefono' class='mensaje-usuario'></div>"; 
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
            
			if ($('#periodo-escolar').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-periodo-escolar").html("Por favor seleccione el período escolar").css("color", 'red');
			}	
			
			if ($('#indicador-recalculo').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-indicador-recalculo").html("Por favor seleccione si desea recalcular las cuotas atrasadas").css("color", 'red');
			}	
			
			if ($('#consejo-educativo').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-consejo-educativo").html("Por favor seleccione si desea mostrar la deuda de consejo educativo").css("color", 'red');
			}	
			
			if ($('#telefono').val() == "")
			{
				indicadorError = 1;
				$("#mensaje-telefono").html("Por favor seleccione el tipo de reporte").css("color", 'red');
			}

			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos. Por favor revise");
				return false;
			}
		});
	});
</script>