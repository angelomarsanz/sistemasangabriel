<?php
    use Cake\I18n\Time;	
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Aplicar beca especial</h3>
            <h4>Alumno: <?= $student->full_name ?></h4>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                            date_default_timezone_set('America/Caracas');
													
                            echo $this->Form->input('discount', ['label' => 'Descuento (%): *', 'type' => 'number']);
						?>
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
        $('#save-student').click(function(e) 
        {
            if ($('#discount').val() < 0)
			{
				alert("Estimado usuario debe indicar un número mayor a cero");
				return false;
			}
		});
    });
</script>