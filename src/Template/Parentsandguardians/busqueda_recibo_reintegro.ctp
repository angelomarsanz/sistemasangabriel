<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Buscar familia para hacer reintegro</h2>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="family">Escriba los apellidos que identifican la familia</label>
                <br />
                <input type="text" class="form-control" id="family">
                <br />
            </div>
        </div>
    </div>
</div>
<script>
// Funciones Jquery
var family = "";
$(document).ready(function() 
{
	$('#family').autocomplete(
	{
		source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
		minLength: 3,
		select: function( event, ui ) {
			$.redirect('<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "previoReciboReintegro"]); ?>', {idRepresentante : ui.item.id }); 
		  }
	});
});    
</script>