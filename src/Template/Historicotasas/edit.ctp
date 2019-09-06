<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $historicotasa->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $historicotasa->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Historicotasas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Monedas'), ['controller' => 'Monedas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Moneda'), ['controller' => 'Monedas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="historicotasas form large-9 medium-8 columns content">
    <?= $this->Form->create($historicotasa) ?>
    <fieldset>
        <legend><?= __('Edit Historicotasa') ?></legend>
        <?php
            echo $this->Form->input('moneda_id', ['options' => $monedas]);
            echo $this->Form->input('tasa_cambio_dolar');
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
