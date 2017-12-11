<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Volver'), ['controller' => 'positions', 'action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></p>
    		<h2>Modificar Puesto de Trabajo</h2>
    	</div>
        <?= $this->Form->create($position) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('position', ['label' => 'Puesto de trabajo: *']);
                    echo $this->Form->input('short_name', ['label' => 'Nombre corto: *']);
                    echo $this->Form->input('type_of_salary', ['label' => 'Tipo de sueldo: *', 'options' =>
                    [null => '',
                    'Por horas' => 'Por horas',
                    'Sueldo fijo' => 'Sueldo fijo']]);
                    echo $this->Form->input('minimum_wage', ['label' => 'Sueldo básico: *']);
/*
                    echo $this->Form->input('reason_salary_increase', ['label' => 'Motivo del aumento de sueldo:', 'options' =>
                    [null => '',
                    'Decreto Presidencial' => 'Decreto Presidencial',
                    'Resolución del Ministerio de Educación' => 'Resolución del Ministerio de Educación',
                    'Aprobado por la Asamblea de Padres y Representantes' => 'Aprobado por la Asamblea de Padres y Representante',
                    'Aprobado por los Directivos del colegio' => 'Aprobado por los Directivos del colegio']]);
                    
                    setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                    date_default_timezone_set('America/Caracas');

                    echo $this->Form->input('effective_date_increase', ['label' => 'Fecha efectiva del aumento de sueldo:']);
*/
                ?>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>