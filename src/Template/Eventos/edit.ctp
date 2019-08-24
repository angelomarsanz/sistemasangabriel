<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $evento->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $evento->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Eventos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventos form large-9 medium-8 columns content">
    <?= $this->Form->create($evento) ?>
    <fieldset>
        <legend><?= __('Edit Evento') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('descripcion');
            echo $this->Form->input('tipo_modulo');
            echo $this->Form->input('nombre_modulo');
            echo $this->Form->input('nombre_metodo');
            echo $this->Form->input('columna_extra1');
            echo $this->Form->input('columna_extra2');
            echo $this->Form->input('columna_extra3');
            echo $this->Form->input('columna_extra4');
            echo $this->Form->input('columna_extra5');
            echo $this->Form->input('columna_extra6');
            echo $this->Form->input('columna_extra7');
            echo $this->Form->input('columna_extra8');
            echo $this->Form->input('columna_extra9');
            echo $this->Form->input('columna_extra10');
            echo $this->Form->input('estatus_registro');
            echo $this->Form->input('motivo_cambio_estatus');
            echo $this->Form->input('fecha_cambio_estatus', ['empty' => true]);
            echo $this->Form->input('usuario_responsable');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
