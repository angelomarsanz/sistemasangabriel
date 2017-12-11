<style>
@media screen
{
    .cerrar 
    {
        display:scroll;
        position:fixed;
        bottom:5%;
        right: 50px;
    }
    .volver 
    {
        display:scroll;
        position:fixed;
        bottom:5%;
        right: 95px;
    }
}
</style>
<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Reporte de secciones</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	               	echo $this->Form->input('level_of_study', ['label' => 'Nivel de estudio: ', 'required' => true, 'options' => 
                        [null => " ",
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
	               	echo $this->Form->input('section', ['label' => 'Sección: ', 'required' => true, 'options' => 
                        [null => " ",
                        'A' => 'A',                                
                        'B' => 'B',
                        'C' => 'C']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Buscar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <a title="Cerrar" class='cerrar img-thumbnail img-responsive' href='/sistemasangabriel/users/wait'><img src='/sistemasangabriel/img/x.png' width = 25 height = 25 border="0"/></a>
        <a title="Volver" class='volver img-thumbnail img-responsive' href='/sistemasangabriel/users/wait'><img src='/sistemasangabriel/img/volver.jpg' width = 25 height = 25 border="0"/></a>
	</div>
</div>