<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
			<?php if (isset($controller)): ?>
				<?php if ($controller == 'Paysheets' && $action == 'edit'): ?>   
					<p><?= $this->Html->link(__(''), ['controller' => $controller, 'action' => $action, $idPaysheet, $classification], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>
				<?php elseif ($controller == 'Employees' && $action == 'view'): ?>
					<?php if (isset($idPaysheet)): ?>
						<p><?= $this->Html->link(__(''), ['controller' => $controller, 'action' => $action, $employee->id, 'Paysheets', 'edit', $idPaysheet, $classification], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>
					<?php else: ?>
						<p><?= $this->Html->link(__(''), ['controller' => $controller, 'action' => $action, $employee->id], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>				
					<?php endif; ?>
				<?php endif; ?>
			<?php else: ?>
				<p><?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'index'], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>
			<?php endif; ?>
            <h3>Modificar empleado</h3>
        </div>
        <?= $this->Form->create($employee, ['type' => 'file']) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                            date_default_timezone_set('America/Caracas');
                            
                            echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                            echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
                            echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                            echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
                            echo $this->Form->input('sex', ['options' => [null => " ", 'Masculino' => 'Masculino', 'Femenino' => 'Femenino'], 'label' => 'Sexo: *']);
                            echo $this->Form->input('nationality', ['options' => [null => " ", 'Venezolano' =>  'Venezolano', 'Extranjero' => 'Extranjero'], 'label' => 'Nacionalidad: *']);
                            echo $this->Form->input('type_of_identification', 
                                ['options' => 
                                [null => " ",
                                 'V' => 'Cédula venezolano',
                                 'E' => 'Cédula extranjero',
                                 'P' => 'Pasaporte'],
                                 'label' => 'Tipo de documento de identificación: *']);
                            echo $this->Form->input('identity_card', ['label' => 'Número de cédula de identidad: *']);
                            echo $this->Form->input('rif', ['label' => 'Rif: *']);                            
                            echo $this->Form->input('place_of_birth', ['label' => 'Lugar de nacimiento: *']);
                            echo $this->Form->input('country_of_birth', ['label' => 'País de nacimiento: *']);
                            echo $this->Form->input('birthdate', 
                            ['label' => 'Fecha de nacimiento: *', 
                            'minYear' => 1950,
                            'maxYear' => 2017,]);
                            echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular:']);
                            echo $this->Form->input('landline', ['label' => 'Número de teléfono fijo: *']);
                            echo $this->Form->input('email', ['label' => 'Correo electrónico:']);
                            echo $this->Form->input('address', ['label' => 'Dirección de habitacion: *']);
                            echo $this->Form->input('degree_instruction', ['label' => 'Grado de instrucción: *']);
                            echo $this->Form->input('date_of_admission', ['label' => 'Fecha de ingreso: *']);
                            if (isset($classification))
                            {
                                echo $this->Form->input('classification', ['label' => 'Clasificación: *', 'options' =>
                                ['null' => '',
                                'Bachillerato y deporte' => 'Bachillerato y deporte',
                                'Primaria' => 'Primaria',
                                'Pre-escolar' => 'Pre-escolar',
                                'Administrativo y obrero' => 'Administrativo y obrero',
                                'Directivo' => 'Directivo'], 'value' => $classification]);
                            }
                            else
                            {
                                echo $this->Form->input('classification', ['label' => 'Clasificación: *', 'options' =>
                                ['null' => '',
                                'Bachillerato y deporte' => 'Bachillerato y deporte',
                                'Primaria' => 'Primaria',
                                'Pre-escolar' => 'Pre-escolar',
                                'Administrativo y obrero' => 'Administrativo y obrero',
                                'Directivo' => 'Directivo']]);
                            }
                            echo $this->Form->input('position_id', ['label' => 'Puesto de trabajo: *', 'options' => $positions]);
                            echo $this->Form->input('working_agreement', ['label' => 'Tipo de contrato de trabajo: *', 'options' =>
                            [null => '',
                            'Contratado' => 'Contratado',
                            'Fijo' => 'Fijo']]);
                            echo $this->Form->input('reason_withdrawal', ['label' => 'Estado: *', 'options' =>
                                ['null' => '',
                                'Activo' => 'Activo',
                                'Despido' => 'Despido',
                                'Eliminado' => 'Eliminado',
                                'Reducción de personal' => 'Reducción de personal',
                                'Retiro voluntario' => 'Retiro voluntario',
                                'Suspensión temporal' => 'Suspensión temporal']]);
                            echo $this->Form->input('retirement_date', ['label' => 'Fecha del cambio de estado: *']);
                            echo $this->Form->input('daily_hours', ['label' => 'Horas diarias de trabajo: *']);
                            echo $this->Form->input('weekly_hours', ['label' => 'Horas semanales de trabajo: *']);
//                            echo $this->Form->input('maximum_number_sections', ['label' => 'Máximo número de secciones a asignar: *']);
//                            echo $this->Form->input('sections._ids', ['label' => 'Asignar secciones: *', 'options' => $sections]);
                            echo $this->Form->input('teachingareas._ids', ['label' => 'Materia (s) que dicta: *', 'options' => $teachingareas]);
                            echo $this->Form->input('percentage_imposed', ['label' => 'Porcentaje de ISLR a aplicar: *']);
                            echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil:'));
                            
                        ?>
                    </div>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-employee']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#save-employee').click(function(e) 
        {
            $('#surname').val($.trim($('#surname').val()));
            $('#second-surname').val($.trim($('#second-surname').val()));
            $('#first-name').val($.trim($('#first-name').val()));
            $('#second-name').val($.trim($('#second-name').val()));
            $('#rif').val($.trim($('#rif').val().toUpperCase()));
            $('#place-of-birth').val($.trim($('#place-of-birth').val()));
            $('#country-of-birth').val($.trim($('#country-of-birth').val()));
            $('#email').val($.trim($('#email').val().toLowerCase()));
            $('#address').val($.trim($('#address').val()));
            $('#degree-instruction').val($.trim($('#degree-instruction').val()));
        });
    });
</script>