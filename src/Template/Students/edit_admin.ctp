<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Modificar datos del alumno</h3>
            <h4>Familia: <?= $parentsandguardian->family ?></h4>
        </div>
        <?= $this->Form->create($student, ['type' => 'file']) ?>
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
                            echo $this->Form->input('identity_card', ['label' => 'Número de cédula o pasaporte (si es partida de nacimiento coloque un cero): *']);
                            
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
                            echo $this->Form->input('level_of_study', ['options' => 
                                [null => " ",
                                'Pre-escolar, kinder' => 'Pre-escolar, kinder',                                'Pre-escolar, pre-kinder' => 'Pre-escolar, pre-kinder',
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
                                'Secundaria, 5to. año' => 'Secundaria, 5to. año'], 'label' => 'Nivel de estudio del alumno: *']);
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
                            echo $this->Form->input('brothers_in_school', ['label' => 'Tiene hermanos en el colegio?: *']);
                            echo $this->Form->input('number_of_brothers', ['label' => 'Número de hermanos en el colegio (si no tiene, no llene este campo): *', 'value' => 0]);
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
<script>
    $(document).ready(function() 
    {
        $('#save-student').click(function(e) 
        {
            $('#first-name').val($('#first-name').val().toUpperCase());
            $('#second-name').val($('#second-name').val().toUpperCase());
            $('#surname').val($('#surname').val().toUpperCase());
            $('#second-surname').val($('#second-surname').val().toUpperCase());
            $('#place-of-birth').val($('#place-of-birth').val().toUpperCase());
            $('#country-of-birth').val($('#country-of-birth').val().toUpperCase());
            $('#email').val($('#email').val().toLowerCase());
            $('#address').val($('#address').val().toUpperCase());
            $('#first-name-father').val($('#first-name-father').val().toUpperCase());
            $('#second-name-father').val($('#second-name-father').val().toUpperCase());
            $('#surname-father').val($('#surname-father').val().toUpperCase());
            $('#second-surname-father').val($('#second-surname-father').val().toUpperCase());
            $('#first-name-mother').val($('#first-name-mother').val().toUpperCase());
            $('#second-name-mother').val($('#second-name-mother').val().toUpperCase());
            $('#surname-mother').val($('#surname-mother').val().toUpperCase());
            $('#second-surname-mother').val($('#second-surname-mother').val().toUpperCase());
            $('#previous-school').val($('#previous-school').val().toUpperCase());
            $('#student-illnesses').val($('#student-illnesses').val().toUpperCase());
            $('#observations').val($('#observations').val().toUpperCase());
        });
    });
</script>