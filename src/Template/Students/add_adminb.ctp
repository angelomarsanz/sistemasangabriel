<?php
    use Cake\I18n\Time;
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
                            echo $this->Form->input('number_of_brothers', ['label' => 'Tipo (Alumno nuevo): *', 'required' => true, 'options' => 
                                [null => " ",
                                0 => 'Alumno nuevo ' . $lastYear . '-' . $currentYear, 
								1 => 'Alumno nuevo ' . $currentYear . '-' . $nextYear]]);
                        ?>
						<div id='same-names' class='noverScreen fontColor'>
							<p><b>Estimado usuario, ya existe uno o más estudiantes con nombres similares en la base de datos. A fin de evitar tener registros duplicados, antes de pulsar el botón "Guardar", por favor verifique si el estudiante que está agregando coincide con el(los) que se muestra(n) a continuación:</b></p>
							<div class="table-responsive">          
								<table class="table table-striped table-hover" >
									<thead>
										<tr>
											<th scope="col">Alumno</th>
											<th scope="col">Familia</th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody id="tbody-same-names"></tbody>
								</table>
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
        $('#number-of-brothers').change(function(e) 
        {
			e.preventDefault();
		
			$.post('<?php echo Router::url(["controller" => "Students", "action" => "sameNames"]); ?>', {'surname' : $("#surname").val(), 'firstName' : $("#first-name").val()}, null, "json")				
                     
            .done(function(response) 
            {
                if (response.success) 
                {              
					$('#same-names').removeClass('noverScreen');
					
					students = '';
					accountArray = 0;
					
                    $.each(response.data.students, function(key, value) 
                    {					
                        $.each(value, function(studentKey, studentValue) 
                        {					
							if (studentKey == 'student')
							{
								if (accountArray == 0)
								{
									students = '<tr><td>' + studentValue + '</td>';
								}
								else
								{
									students += '<tr><td>' + studentValue + '</td>';
								}
								accountArray++;
							}
							else if (studentKey == 'family')
							{
								students +=  '<td>' + studentValue + '</td>';
								familyStudent = studentValue;
							}
							else
							{
								students += '<td><a href=<?= Router::url(array("controller" => "Students", "action" => "viewConsult")) ?>/' + studentValue + '<?= '/'. $idParentsandguardians ?>/familia/Students/registerNewStudents>Ver</a></td></tr>';
							}
						});
                    });
                    $('#tbody-same-names').html(students);
                } 
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#tbody-same-names").html("Algo ha fallado: " + textStatus);
            });  
        });			
		
        $('#save-student').click(function(e) 
        {
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
        });
    });
</script>