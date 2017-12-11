<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <p><?= $this->Html->link(__('Volver'), ['controller' => 'Teachingareas', 'action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></p>
            <h2>Modificar Materia</h2>
        </div>
        <?= $this->Form->create($teachingarea) ?>
        <fieldset>
            <?php
                echo $this->Form->input('description_teaching_area', ['label' => 'Área de enseñanza']);
                echo $this->Form->input('employees._ids', ['label' => 'Docente'], ['options' => $employees]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>