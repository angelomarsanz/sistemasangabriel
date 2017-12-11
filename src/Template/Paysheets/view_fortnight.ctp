<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Por favor seleccione los datos de la nómina: </h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	               	echo $this->Form->input('year_paysheet', ['label' => 'Año: ', 'options' => 
	                    [null => ' ',
	                    '2017' => '2017',
	                    '2018' => '2018',
	                    '2019' => '2019']]);
	                echo $this->Form->input('month_paysheet', ['label' => 'Mes: ', 'options' => 
	                    [null => ' ',
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
	                    '12' => 'Diciembre']]);
	               	echo $this->Form->input('fortnight', ['label' => 'Quincena: ', 'options' => 
	                    [null => ' ',
	                    '1ra. Quincena' => '1ra. Quincena',
	                    '2da. Quincena' => '2da. Quincena']]);
                    echo $this->Form->input('classification', ['label' => 'Clasificación: *', 'options' =>
                            ['null' => '',
                            'Bachillerato y deporte' => 'Bachillerato y deporte',
                            'Primaria' => 'Primaria',
                            'Pre-escolar' => 'Pre-escolar',
                            'Administrativo y obrero' => 'Administrativo y obrero',
                            'Directivo' => 'Directivo']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('buscar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
	</div>
</div>