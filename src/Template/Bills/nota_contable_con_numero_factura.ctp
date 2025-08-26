<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Crear nota contable</h2>
            <p>La búsqueda de la factura original se puede hacer por los apellidos que identifican la familia o por el número de factura, como usted prefiera...</p>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
				 <?= $this->Form->create() ?>
					<fieldset>
					   	<?php
							echo $this->Form->input('familia', ['name' => 'familia', 'label' => 'Apellidos que identifican la familia']);
							echo $this->Form->input('Factura', ['name' => 'factura', 'label' => 'Factura']);
						?>
						<div class="mensajes-usuario" id="mensaje-factura"></div>
						<br />
					</fieldset>
					<?= $this->Form->button(__('Buscar factura'), ['id' => 'buscar-factura', 'class' =>'btn btn-success']) ?>
				<?= $this->Form->end() ?>
				<br />
            </div>
        </div>
    </div>
</div>
<script>   
// Funciones Jquery

    $(document).ready(function() 
    {
        $('#familia').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) 
				{
					$("#buscar-factura").attr("disabled", true);
					window.location.assign('<?php echo Router::url(["controller" => "Bills", "action" => "listaFacturasFamilia"]); ?>' + '/' + ui.item.id + '/' + ui.item.value);
				}
        });
		
		$('#buscar-factura').click(function(e) 
        {
			$('.mensajes-usuario').html("");
			
			if ($('#factura').val() < 0 || $("#factura").val() == "e" || $("#factura").val().length == 0) 
			{
				e.preventDefault();
				$('#factura').css('background-color', "#ffffe6");
				$('#mensaje-factura').html("Por favor introduzca un número de factura válido").css('color', 'red');
				$('#factura').focus();
			}
		});
    });    

</script>