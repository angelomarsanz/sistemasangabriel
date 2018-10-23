<?php
    use Cake\Routing\Router; 
?>
<style>
    .noverScreen
    {
		display:none;
    }
	.fontColor
	{
		color: #ff8080;
	}
</style>
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
						echo $this->Form->input('family', ['label' => 'Apellidos que identifican la familia: *']);
					?>
					<div id='same-names' class='noverScreen fontColor'>
						<p><b>Estimado usuario, ya existe uno o más representantes con nombres similares en la base de datos. A fin de evitar tener registros duplicados, antes de pulsar el botón "Guardar", por favor verifique si el representante que está agregando coincide con el(los) que se muestra(n) a continuación:</b></p>
						<div class="table-responsive">          
							<table class="table table-striped table-hover" >
								<thead>
									<tr>
										<th scope="col">Representante</th>
										<th scope="col">Familia</th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody id="tbody-same-names"></tbody>
							</table>
						</div>
					</div>	
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-parentsandguardians', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
	
        $('#type-of-identification').change(function(e) 
        {
			e.preventDefault();
		
			$.post('<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "sameNames"]); ?>', {'surname' : $("#surname").val(), 'firstName' : $("#first-name").val()}, null, "json")				
                     
            .done(function(response) 
            {
                if (response.success) 
                {              
					$('#same-names').removeClass('noverScreen');
					
					parents = '';
					accountArray = 0;
					
                    $.each(response.data.parents, function(key, value) 
                    {					
                        $.each(value, function(parentKey, parentValue) 
                        {					
							if (parentKey == 'parent')
							{
								if (accountArray == 0)
								{
									parents = '<tr><td>' + parentValue + '</td>';									
								}
								else 
								{
									parents += '<tr><td>' + parentValue + '</td>';
								}
								accountArray++;
							}
							else if (parentKey == 'family')
							{
								parents +=  '<td>' + parentValue + '</td>';
							}
							else
							{
								parents += '<td><a href=<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "view")); ?>/' + parentValue + '/parentsandguardians/addb>Ver</a></td></tr>';
							}
						});
                    });
                    $('#tbody-same-names').html(parents);
                } 
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#tbody-same-names").html("Algo ha fallado: " + textStatus);
            });  
        });			

        $('#save-parentsandguardians').click(function(e) 
        {
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
        });
    });    
</script>