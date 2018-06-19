<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Registrar datos del nuevo alumno</h3>
        </div>
        <?= $this->Form->create($student, ['type' => 'file']) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                            echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                            echo $this->Form->input('number_of_brothers', ['label' => 'Tipo (Alumno nuevo/caso especial): *', 'required' => true, 'options' => 
                                [null => " ",
                                0 => 'Alumno nuevo ' . $lastYear . '-' . $currentYear, 
								1 => 'Alumno nuevo ' . $currentYear . '-' . $nextYear,
                                2 => 'Alumno regular (caso especial)']]);
                        ?>
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
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
        });
    });
</script>