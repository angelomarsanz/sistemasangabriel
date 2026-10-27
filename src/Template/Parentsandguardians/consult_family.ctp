<?php
    /**
     * Vista para buscar familias y abrir directamente el detalle al seleccionar
     * una opción de cualquiera de sus autocompletados.
     */
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Consultar datos de familias</h2>
            <p>La consulta se puede hacer por los apellidos que identifican la familia, el apellido de la madre o el apellido del representante, nombre o razón social (factura) como usted prefiera...</p>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="family">Escriba los apellidos que identifican la familia</label>
                <br />
                <input type="text" class="form-control" id="family">
                <br />
                <label for="mother">Escriba el primer apellido de la madre</label>
                <br />
                <input type="text" class="form-control" id="mother">
                <br />
                <label for="guardian">Escriba el primer apellido del representante</label>
                <br />
                <input type="text" class="form-control" id="guardian">
                <br />
                <label for="invoice">Nombre o razón social (factura)</label>
                <br />
                <input type="text" class="form-control" id="invoice">
                <br />
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Envía a la acción viewData los datos de la familia elegida.
     */
    function abrirDatosFamilia(idFamilia, nombreFamilia)
    {
        $.redirect(
            '<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "viewData"]); ?>',
            {idFamily: idFamilia, family: nombreFamilia}
        );
    }

    $(document).ready(function() 
    {
        $('#family').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                abrirDatosFamilia(ui.item.id, ui.item.value);
              }
        });

        $('#mother').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findMother")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                abrirDatosFamilia(ui.item.id, ui.item.value);
              }
        });

        $('#guardian').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findGuardian")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                abrirDatosFamilia(ui.item.id, ui.item.value);
              }
        });

        $('#invoice').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findInvoice")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                abrirDatosFamilia(ui.item.id, ui.item.value);
              }
        });
    });    

</script>