<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Consulta de contrato de servicio</h2>
            <p>La consulta se puede hacer individualmente por "familia" o "representante" o emitir un reporte de representantes</p>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="family">Escriba los apellidos que identifican la familia</label>
                <br />
                <input type="text" class="form-control" id="family">
                <br />
                <label for="guardian">Escriba el primer apellido del representante</label>
                <br />
                <input type="text" class="form-control" id="guardian">
                <br />
                <?= $this->Form->create() ?>
                    <fieldset>
                        <?php
                            echo $this->Form->input('tipo_reporte', ['label' => 'Tipo de reporte: ', 'required', 'options' => 
                            [
                                null => "",
                                'Representantes de estudiantes regulares que han firmado el contrato' => 'Representantes de estudiantes regulares que han firmado el contrato',
                                'Representantes de estudiantes regulares que no han firmado el contrato' => 'Representantes de estudiantes regulares que no han firmado el contrato',
                                'Representantes de estudiantes nuevos que han firmado el contrato' => 'Representantes de estudiantes nuevos que han firmado el contrato',
                                'Representantes de estudiantes nuevos que no han firmado el contrato' => 'Representantes de estudiantes nuevos que no han firmado el contrato'
                            ]]);
                        ?>
                    </fieldset>   
                    <?php // $this->Form->button(__('Emitir reporte'), ['class' =>'btn btn-success']) ?>
                <?= $this->Form->end() ?>
                <p id="header-messages"></p>
                <br />
            </div>
        </div>
    </div>
</div>
<script>
    // Declaración de variables
    
    // Funciones Jquery

    $(document).ready(function() 
    {
        $('#family').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
			    window.location = '<?php echo Router::url(["controller" => "Guardiantransactions", "action" => "previoContratoRepresentante"]); ?>' + '/' + ui.item.id + '/Parentsandguardians/consultaContratoRepresentante';
            }
        });

        $('#guardian').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findGuardian")); ?>',
            minLength: 3,
            select: function( event, ui ) {
			    window.location = '<?php echo Router::url(["controller" => "Guardiantransactions", "action" => "previoContratoRepresentante"]); ?>' + '/' + ui.item.id + '/Parentsandguardians/consultaContratoRepresentante';
            }
        });
    });    

</script>