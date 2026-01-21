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
						'2024-2025' => '2024-2025',
						'2025-2026' => '2025-2026']]);
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
					echo "<div id='mensaje-consejo-educativo' class='mensaje-usuario'></div>"; ?>
					<div class="form-group">
						<label>Tipo de estudiante:</label>
						<div class="radio">
							<label>
								<?= $this->Form->radio('tipo_estudiante', [['value' => 'todos', 'text' => 'Todos los estudiantes', 'checked' => true]]) ?>
							</label>
						</div>
						<div class="radio">
							<label>
								<?= $this->Form->radio('tipo_estudiante', [['value' => 'quinto_anio', 'text' => 'Solo estudiantes de 5to. Año']]) ?>
							</label>
						</div>
					</div>
					<?php
					echo "<div id='mensaje-tipo-estudiante' class='mensaje-usuario'></div>";
					echo '<div id="quinto_anio_opciones" style="display:none; border: 1px solid #ccc; padding: 10px; margin-top: 10px;">';
					echo '<h5>Incluir:</h5>';
					echo '<div class="checkbox"><label>' . $this->Form->checkbox('condicion_regulares', ['value' => 'Regulares', 'id' => 'condicion-regulares']) . ' Regulares</label></div>';
					echo '<div class="checkbox"><label>' . $this->Form->checkbox('condicion_egresados', ['value' => 'Egresados', 'id' => 'condicion-egresados']) . ' Egresados</label></div>';
					echo "<div id='mensaje-condicion-estudiante' class='mensaje-usuario'></div>";
					echo '</div>';
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
		$('input[name="tipo_estudiante"]').change(function() {
			if ($(this).val() === 'quinto_anio') {
				$('#quinto_anio_opciones').show();
			} else {
				$('#quinto_anio_opciones').hide();
				// Limpiar checkboxes si se vuelve a "Todos"
				$('#condicion-regulares').prop('checked', false);
				$('#condicion-egresados').prop('checked', false);
			}
		});


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

			var tipoEstudiante = $('input[name="tipo_estudiante"]:checked').val();
			if (!tipoEstudiante) {
				indicadorError = 1;
				$("#mensaje-tipo-estudiante").html("Por favor seleccione un tipo de estudiante").css("color", 'red');
			} else if (tipoEstudiante === 'quinto_anio') {
				var regularesChecked = $('#condicion-regulares').is(':checked');
				var egresadosChecked = $('#condicion-egresados').is(':checked');

				if (!regularesChecked && !egresadosChecked) {
					indicadorError = 1;
					$("#mensaje-condicion-estudiante").html("Debe seleccionar al menos una condición (Regulares o Egresados)").css("color", 'red');
				}
			}

			if (indicadorError > 0)
			{
				alert("Estimado usuario los datos están incompletos. Por favor revise");
				return false;
			}
		});
	});
</script>