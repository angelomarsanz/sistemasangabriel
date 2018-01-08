<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Agregar tarifa</h2>
    	</div>
        <?= $this->Form->create($rate) ?>
        <fieldset>
            <?php
                echo $this->Form->input('concept', ['options' => 
                    [null => '',
                    'Matrícula' => 'Matrícula',
                    'Seguro escolar' => 'Seguro escolar',
                    'Mensualidad' => 'Mensualidad',
                    'Servicio educativo' => 'Servicio educativo'],
                    'label' => 'Tarifa']); 
                echo $this->Form->input('rate_month', ['label' => 'A partir del mes: ', 'options' => 
                    [null => '',
                    '01' => 'Enero',
                    '02' => 'Febrero',
                    '03' => 'Marzo',
                    '04' => 'Abril',
                    '05' => 'Mayo',
                    '06' => 'Junio',
                    '07' => 'Julio',
                    '08' => 'Agosto',
                    '09' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre'], 'disabled' => 'disabled']);
               	echo $this->Form->input('rate_year', ['label' => 'Del año: ', 'options' => 
                    [null => '',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019'], 'disabled' => 'disabled']);
                echo $this->Form->input('amount', [
                    'label' => 'Monto']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    function enableInputs() 
    {
		alert('Estimado usuario antes de agregar una nueva tarifa por favor comunicarse con el personal de sistema para que haga un respaldo de la base de datos');

        $("#rate-month").attr('disabled', true);
        $("#rate-year").attr('disabled', true);

        if ($("#concept").val().substring(0, 11) == "Mensualidad")
        {
            $("#rate-month").attr('disabled', false);
            $("#rate-year").attr('disabled', false);
        }
        else
        {
            $("#rate-year").attr('disabled', false);
        }
    }
    
    $(document).ready(function() 
    {
        $("#concept").change(enableInputs);
    });
</script>