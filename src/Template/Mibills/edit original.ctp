<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $mibill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $mibill->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Mibills'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="mibills form large-9 medium-8 columns content">
    <?= $this->Form->create($mibill) ?>
    <fieldset>
        <legend><?= __('Edit Mibill') ?></legend>
        <?php
            echo $this->Form->input('idd');
            echo $this->Form->input('ci');
            echo $this->Form->input('nombre');
            echo $this->Form->input('direccion');
            echo $this->Form->input('telefono');
            echo $this->Form->input('iva');
            echo $this->Form->input('total');
            echo $this->Form->input('sub');
            echo $this->Form->input('fecha');
            echo $this->Form->input('status');
            echo $this->Form->input('new_family');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
