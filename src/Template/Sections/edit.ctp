<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
            <p><?= $this->Html->link(__('Volver'), ['controller' => 'Sections', 'action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></p>
    		<h2>Modificar Sección</h2>
    	</div>
        <?= $this->Form->create($section) ?>
        <fieldset>
        <?php
            echo $this->Form->input('level', ['options' => ['Pre-escolar' => 'Pre-escolar',
                    'Primaria' => 'Primaria', 'Secundaria' => 'Secundaria'], 'label' => 'Nivel']);
            echo $this->Form->input('sublevel', ['options' => ['Kinder' => 'Kinder',
                                'Pre-kinder' => 'Pre-kinder',
                                'Preparatorio' => 'Preparatorio',
                                '1er grado' => '1er grado',
                                '2do grado' => '2do grado',
                                '3er grado' => '3er grado',
                                '4to grado' => '4to grado',
                                '5to grado' => '5to grado',
                                '6to grado' => '6to grado',
                                '1er año' => '1er año',
                                '2do año' => '2do año',
                                '3er año' => '3er año',
                                '4to año' => '4to año',
                                '5to año' => '5to año'], 'label' => 'Sub-nivel']);
            echo $this->Form->input('section', ['options' => ['A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                                'F' => 'F',
                                'G' => 'G',
                                'H' => 'H',
                                'I' => 'I',
                                'J' => 'J'], 
                                'label' => 'Sección']);
            echo $this->Form->input('other',
                ['options' => ['' => 'Ninguna'], 'label' => 'Mención']);
            echo $this->Form->input('maximum_amount', ['label' => 'Cantidad máxima de alumnos']);
            echo $this->Form->input('employees._ids', ['label' => 'Empleado:', 'options' => $employees]);
        ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>