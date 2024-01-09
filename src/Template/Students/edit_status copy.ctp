<?php
    /*
        Cambios:
        03/08/2023
        Se agregó un debug a la variable $student
        Por error se están enviando valores nulos en el campo level_of_study en los casos cuando se selecciona distinto a "nuevo" por esa razón no se actualiza el registro 
    */
    use Cake\I18n\Time;
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3><?= "Cambiar la condición del alumno: " . $student->full_name ?></h3>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                            date_default_timezone_set('America/Caracas');

                            $proximo_anio_matricula_mas_uno = $proximo_anio_matricula + 1;
							
                            echo $this->Form->input('student_condition', 
                                ['label' => 'Condición del alumno:', 'options' => 
                                [null => " ",
                                'Expulsado' => 'Expulsado',
                                'Egresado' => 'Egresado',
                                'Eliminado' => 'Eliminado',
                                'Nuevo' => 'Nuevo',
                                'Regular' => 'Regular',
                                'Retirado' => 'Retirado',
                                'Suspendido' => 'Suspendido']]);
                            echo "<div id='datos_alumnos_nuevos' class='noverScreen'>";
                                echo $this->Form->input('brothers_in_school', ['label' => 'Año escolar: ', 'required' => false, 'options' => 
                                    [null => " ",
                                    0 => $actual_anio_matricula . '-' . $proximo_anio_matricula, 
			    					1 => $proximo_anio_matricula . '-' . $proximo_anio_matricula_mas_uno]]);
                                echo $this->Form->input('level_of_study', ['required' => false, 'options' => 
                                    [null => "",
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
                                    'Secundaria, 5to. año' => 'Secundaria, 5to. año'], 'label' => 'Nivel de estudio que cursará el estudiante']);
                            echo "</div>";
                            echo $this->Form->input('observations', ['label' => 'Observaciones: *']);
                        ?>
                    </div>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-student']) ?>
        <?= $this->Form->end() ?>
        <?php debug($student); ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $("#student-condition").on("change", function()
        {
            if ($("#student-condition").val() == "Nuevo")
            {
                $("#datos_alumnos_nuevos").removeClass("noverScreen");
                $("#brothers_in_school").attr("required", true);
                $("#level-of-study").attr("required", true);
            }
            else
            {
                $("#datos_alumnos_nuevos").addClass("noverScreen");
                $("#brothers_in_school").attr("required", false);
                $("#level-of-study").attr("required", false
                );                
            }
        });

        $('#save-student').click(function(e) 
        {
            $('#observations').val($('#observations').val().toUpperCase());
        });
    });
</script>