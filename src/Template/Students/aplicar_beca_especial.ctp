<?php
use Cake\I18n\Time;	
if ($student->tipo_descuento == null || $student->tipo_descuento == '' || $student->tipo_descuento == ' '):
    $tipoDescuento = 'Ninguna';
elseif ($student->tipo_descuento == 'Becado'):
    $tipoDescuento = "Completa";
else:
    $tipoDescuento = $student->tipo_descuento;
endif; ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Aplicar Beca Especial</h3>
            <h4>Alumno: <?= $student->full_name ?></h4>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            echo '<p><strong>Tipo de beca actual: </strong>'.$tipoDescuento.'</p>';
                            echo '<p><strong>Porcentaje de beca actual: </strong>'.$student->discount.'%</p>';
                            echo $this->Form->input('discount', ['label' => 'Porcentaje a asignar (%): *', 'type' => 'number']);
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