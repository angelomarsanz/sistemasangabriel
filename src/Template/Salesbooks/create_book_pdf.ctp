<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Libro de ventas en PDF</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('month', ['label' => 'Mes: ', 'options' => 
	                    ['01' => 'Enero',
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
	               	echo $this->Form->input('year', ['label' => 'Año: ', 'options' => 
	                    ['2016' => '2016',
	                    '2017' => '2017',
	                    '2018' => '2018',
						'2019' => '2019',
						'2020' => '2020',
						'2021' => '2021']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Crear libro de ventas'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>