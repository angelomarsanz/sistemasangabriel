<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Datos adicionales del alumno</h2>
        </div>
        <?= $this->Form->create($student, ['type' => 'file']) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('nationality', ['options' => [null => ' ', 'Venezolano' =>  'Venezolano', 'Extranjero' => 'Extranjero'], 'label' => 'Nacionalidad: *']);
                    echo $this->Form->input('type_of_identification', 
                        ['options' => 
                        [null => ' ', 
                         'Cédula venezolano' => 'Cédula venezolano',
                         'Cédula extranjero' => 'Cédula extranjero',
                         'Pasaporte' => 'Pasaporte',
                         'Partida de nacimiento' => 'Partida de nacimiento'], 
                         'label' => 'Tipo de documento de identificación: *']);
                    echo $this->Form->input('identity_card', ['label' => 'Número de cédula o pasaporte (si es partida de nacimiento coloque un cero): *']);
                    echo $this->Form->input('family_bond_guardian_student', ['options' => 
                        [null => " ",
                        'Padre' => 'Padre',
                        'Madre' => 'Madre',
                        'Hermano' => 'Hermano',
                        'Hermana' => 'Hermana',
                        'Abuelo' => 'Abuelo',
                        'Abuela' => 'Abuela',
                        'Tío' => 'Tío', 
                        'Tía' => 'Tía', 
                        'Otro vínculo familiar' => 'Otro vínculo familiar',
                        'Ningún vínculo familiar' => 'Ningún vínculo familiar'], 'label' => 'Vínculo familiar del representante con el alumno']);
                    echo $this->Form->input('first_name_father', ['label' => 'Primer nombre del padre: *', 'value' => $resultParentsandguardians[0]['first_name_father'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('second_name_father', ['label' => 'Segundo nombre del padre:', 'value' => $resultParentsandguardians[0]['second_name_father'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('surname_father', ['label' => 'Primer apellido del padre: *', 'value' => $resultParentsandguardians[0]['surname_father'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('second_surname_father', ['label' => 'Segundo apellido del padre:', 'value' => $resultParentsandguardians[0]['second_surname_father'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('first_name_mother', ['label' => 'Primer nombre de la madre: *', 'value' => $resultParentsandguardians[0]['first_name_mother'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('second_name_mother', ['label' => 'Segundo nombre de la madre:', 'value' => $resultParentsandguardians[0]['second_name_mother'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('surname_mother', ['label' => 'Primer apellido de la madre', 'value' => $resultParentsandguardians[0]['surname_mother'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('second_surname_mother', ['label' => 'Segundo apellido de la madre:', 'value' => $resultParentsandguardians[0]['second_surname_mother'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('place_of_birth', ['label' => 'Lugar de nacimiento del alumno: *']);
                    echo $this->Form->input('country_of_birth', ['label' => 'País de nacimiento del alumno: *']);
                    echo $this->Form->input('birthdate', 
                            ['label' => 'Fecha de nacimiento del alumno: *', 
                            'minYear' => 1990,
                            'maxYear' => 2017,]);
                    echo $this->Form->input('address', ['label' => 'Dirección de habitacion: *', 'value' => $resultParentsandguardians[0]['address_mother'], 'style' => 'background-color: #ffff99;']);
                    echo $this->Form->input('level_of_study', ['options' =>
                        [null => " ",
                        'Pre-escolar, kinder' => 'Pre-escolar, kinder',
                        'Pre-escolar, pre-kinder' => 'Pre-escolar, pre-kinder',
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
                    echo $this->Form->input('brothers_in_school', ['label' => 'Tiene hermanos en el colegio: *']);
                    echo $this->Form->input('number_of_brothers', ['label' => 'Número de hermanos en el colegio: *']);
                    echo $this->Form->input('previous_school', ['label' => 'Colegio de donde proviene: *']);
                    echo $this->Form->input('student_illnesses', ['label' => 'Enfermedades del alumno: *']);
                    echo $this->Form->input('observations', ['label' => 'Observaciones: *']);
                ?>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>