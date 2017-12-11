<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Registrar datos del padre y/o representante</h2>
        </div>
        <?= $this->Form->create($parentsandguardian) ?>
        <fieldset>
            <div class="row panel panel-default">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <br />
                    <?php
                        echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                        echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                        echo $this->Form->input('type_of_identification', 
                            ['options' => 
                            [null => ' ',
                            'V' => 'Cédula venezolano',
                            'E' => 'Cédula extranjero',
                            'P' => 'Pasaporte'],
                            'label' => 'Tipo de documento de identificación: *']);
                        echo $this->Form->input('identidy_card', ['label' => 'Número de cédula o pasaporte: *', 'type' => 'number']);
                    ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-parentsandguardians', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#save-parentsandguardians').click(function(e) 
        {
            $('#surname').val($('#surname').val().toUpperCase());
            $('#first-name').val($('#first-name').val().toUpperCase());
        });
    });    
</script>