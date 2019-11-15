<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Bancos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="bancos form large-9 medium-8 columns content">
    <?= $this->Form->create($banco) ?>
    <fieldset>
        <legend><?= __('Add Banco') ?></legend>
        <?php
            echo $this->Form->input('nombre_banco');
            echo $this->Form->input('tipo_banco');
            echo $this->Form->input('estatus_registro');
            echo $this->Form->input('usuario_creador');
            echo $this->Form->input('usuario_cambio_estatus');
            echo $this->Form->input('fecha_cambio_estatus', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
