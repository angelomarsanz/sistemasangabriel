<?php
    use Cake\I18n\Time;	
?>
<div class="container">
	<?php if ($indicadorJulioPendiente == 1): ?>
	<div class="jumbotron" id="aviso">
		<h3><b>Importante</b></h3>      
		<p>Hemos verificado que aún posee cuotas pendientes del año en curso, por favor, realice el pago correspondiente y así poder completar el proceso de inscripción para el nuevo período escolar. Su inscripción sólo será validada cuando se confirme el pago del saldo adeudado.</p>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="cerrar-aviso">Cerrar</button>
		</div>
	</div>
	</div>
	<?php endif; ?>
	<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="page-header">
				<h3>Actualizar los datos del alumno</h3>
				<h4>Familia: <?= $parentsandguardian->family ?></h4>
			</div>
			<?= $this->Form->create($student) ?>
				<fieldset>
					<div class="row panel panel-default">
						<div class="col-md-12">
							<br />
							<?php
								setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
								date_default_timezone_set('America/Caracas');
														
								echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
								echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
								echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
								echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
								echo $this->Form->input('sex', ['options' => [null => " ", 'M' => 'Masculino', 'F' => 'Femenino'], 'label' => 'Sexo: *']);
								echo $this->Form->input('nationality', ['options' => [null => " ", 'Venezolano' =>  'Venezolano', 'Extranjero' => 'Extranjero'], 'label' => 'Nacionalidad: *']);
								echo $this->Form->input('type_of_identification', 
									['options' => 
									[null => " ",
									 'V' => 'Cédula venezolano',
									 'E' => 'Cédula extranjero',
									 'P' => 'Pasaporte',
									 'PN' => 'Partida de nacimiento'], 
									 'label' => 'Tipo de documento de identificación: *']);
								echo $this->Form->input('identity_card', ['label' => 'Número de cédula o pasaporte (si es partida de nacimiento coloque un cero): *', 'type' => 'number']);

								if ($current_user['role'] != 'Representante'):
									echo $this->Form->input('student_condition', 
										['label' => 'Condición del alumno:', 'options' => 
										[null => " ",
										 'Expulsado' => 'Expulsado',
										 'Egresado' => 'Egresado',
										 'Eliminado' => 'Eliminado',
										 'Regular' => 'Regular',
										 'Retirado' => 'Retirado',
										 'Suspendido' => 'Suspendido']]);
								endif;

								echo $this->Form->input('place_of_birth', ['label' => 'Lugar de nacimiento del alumno: *']);
								echo $this->Form->input('country_of_birth', ['label' => 'País de nacimiento del alumno: *']);
								echo $this->Form->input('birthdate', 
								['label' => 'Fecha de nacimiento del alumno: *', 
								'minYear' => 1990,
								'maxYear' => 2017,]);
								echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular:']);
								echo $this->Form->input('email', ['label' => 'Correo electrónico:']);
								echo $this->Form->input('address', ['label' => 'Dirección de habitacion: *',
											'value' => $parentsandguardian->address,
											'style' => 'background-color : #ffff99;']);
											
								if ($current_user['role'] != 'Representante'):
									echo $this->Form->input('section_id', ['label' => 'Grado y sección al que está asignado el alumno actualmente', 'options' => $sections]); 										
								endif;			
								echo $this->Form->input('level_of_study', ['options' => 
									[null => " ",
									'Pre-escolar, pre-kinder' => 'Pre-escolar, pre-kinder',                                
									'Pre-escolar, kinder' => 'Pre-escolar, kinder',
									'Pre-escolar, preparatorio' => 'Pre-escolar, preparatorio',
									'Primaria, 1er. grado' => 'Primaria, 1er. grado',
									'Primaria, 2do. grado' => 'Primaria, 2do. grado',
									'Primaria, 3er. grado' => 'Primaria, 3er. grado',
									'Primaria, 4to. grado' => 'Primaria, 4to. grado', 
									'Primaria, 5to. grado' => 'Primaria, 5to. grado', 
									'Primaria, 6to. grado' => 'Primaria, 6to. grado',
									'Secundaria, 1er. año' => 'Secundaria, 1er. año',
									'Secundaria, 2do. año' => 'Secundaria, 2do. año',
									'Secundaria, 3er. año' => 'Secundaria, 3er. año',
									'Secundaria, 4to. año' => 'Secundaria, 4to. año',
									'Secundaria, 5to. año' => 'Secundaria, 5to. año'], 'label' => 'Nivel de estudio que cursará el alumno en el próximo año escolar: *']);
								echo $this->Form->input('family_bond_guardian_student', ['options' => [null => " ", 'Padre' => 'Padre',
									'Madre' => 'Madre',
									'Hermano' => 'Hermano',
									'Hermana' => 'Hermana',
									'Abuelo' => 'Abuelo',
									'Abuela' => 'Abuela',
									'Tío' => 'Tío', 
									'Tía' => 'Tía', 
									'Otro vínculo familiar' => 'Otro vínculo familiar',
									'Ningún vínculo familiar' => 'Ningún vínculo familiar'], 'label' => 'Vínculo familiar del representante con el alumno: *']);
							?>
							<br />
							<p><b>Datos del padre (modifique si no son los correctos):</b></p>
							<br />
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-11">
									<?php
										echo $this->Form->input('first_name_father', ['label' => 'Primer nombre: *',
											'value' => $parentsandguardian->first_name_father,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('second_name_father', ['label' => 'Segundo nombre:',
											'value' => $parentsandguardian->second_name_father,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('surname_father', ['label' => 'Primer apellido: *',
											'value' => $parentsandguardian->surname_father,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('second_surname_father', ['label' => 'Segundo apellido:',
											'value' => $parentsandguardian->second_surname_father,
											'style' => 'background-color : #ffff99;']);
									?>
								</div>
							</div>
							<br />
							<p><b>Datos de la madre (modifique si no son los correctos):</b></p>
							<br />
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-11">
									<?php
										echo $this->Form->input('first_name_mother', ['label' => 'Primer nombre: *',
											'value' => $parentsandguardian->first_name_mother,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('second_name_mother', ['label' => 'Segundo nombre:',
											'value' => $parentsandguardian->second_name_mother,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('surname_mother', ['label' => 'Primer apellido: *',
											'value' => $parentsandguardian->surname_mother,
											'style' => 'background-color : #ffff99;']);
										echo $this->Form->input('second_surname_mother', ['label' => 'Segundo apellido:',
											'value' => $parentsandguardian->second_surname_mother,
											'style' => 'background-color : #ffff99;']);
									?>
								</div>
							</div>
							<?php
								echo $this->Form->input('previous_school', ['label' => 'Colegio de donde proviene: *']);
								echo $this->Form->input('student_illnesses', ['label' => 'Enfermedades del alumno: *']);
								echo $this->Form->input('observations', ['label' => 'Observaciones: *']);
							?>
						</div>
					</div>
				</fieldset>
			<?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-student']) ?>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$('#cerrar-aviso').click(function(e) 
        {
			$('#aviso').hide();
		});
        $('#save-student').click(function(e) 
        {
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
            $('#second-name').val($.trim($('#second-name').val().toUpperCase()));
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#second-surname').val($.trim($('#second-surname').val().toUpperCase()));
            $('#place-of-birth').val($.trim($('#place-of-birth').val().toUpperCase()));
            $('#country-of-birth').val($.trim($('#country-of-birth').val().toUpperCase()));
            $('#email').val($.trim($('#email').val().toLowerCase()));
            $('#address').val($.trim($('#address').val().toUpperCase()));
            $('#first-name-father').val($.trim($('#first-name-father').val().toUpperCase()));
            $('#second-name-father').val($.trim($('#second-name-father').val().toUpperCase()));
            $('#surname-father').val($.trim($('#surname-father').val().toUpperCase()));
            $('#second-surname-father').val($.trim($('#second-surname-father').val().toUpperCase()));
            $('#first-name-mother').val($.trim($('#first-name-mother').val().toUpperCase()));
            $('#second-name-mother').val($.trim($('#second-name-mother').val().toUpperCase()));
            $('#surname-mother').val($.trim($('#surname-mother').val().toUpperCase()));
            $('#second-surname-mother').val($.trim($('#second-surname-mother').val().toUpperCase()));
            $('#previous-school').val($.trim($('#previous-school').val().toUpperCase()));
            $('#student-illnesses').val($.trim($('#student-illnesses').val().toUpperCase()));
            $('#observations').val($.trim($('#observations').val().toUpperCase()));
        });
    });
</script>