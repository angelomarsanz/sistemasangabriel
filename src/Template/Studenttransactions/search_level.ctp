<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Asignar Sección</h3>
	        <h4>Por favor seleccione:</h4>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	               	echo $this->Form->input('level_of_study', ['label' => 'Grado: ', 'options' => 
                        [' ' => ' ',
                        'Pre-escolar, pre-kinder' => 'Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder' => 'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio' => 'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado' => 'Primaria, 1er. grado',
                        'Primaria, 2do. grado' => 'Primaria, 2do. grado',
                        'Primaria, 3er. grado' => 'Primaria, 3er. grado',
                        'Primaria, 4to. grado' => 'Primaria, 4to. grado', 
                        'Primaria, 5to. grado' => 'Primaria, 5to. grado', 
                        'Primaria, 6to. grado' => 'Primaria, 6to. grado',
                        'Secundaria, 1er. año' => 'Secundaria, 1er. año',
                        'Secundaria, 2do. año' => 'Secundaria, 2do. año',
                        'Secundaria, 3er. año' => 'Secundaria, 3er. año',
                        'Secundaria, 4to. año' => 'Secundaria, 4to. año',
                        'Secundaria, 5to. año' => 'Secundaria, 5to. año']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('buscar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
	</div>
</div>