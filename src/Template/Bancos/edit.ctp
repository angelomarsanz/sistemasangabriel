<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $banco->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $banco->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bancos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="bancos form large-9 medium-8 columns content">
    <?= $this->Form->create($banco) ?>
    <fieldset>
        <legend><?= __('Edit Banco') ?></legend>
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
