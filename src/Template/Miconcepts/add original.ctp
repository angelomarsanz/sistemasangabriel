<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Miconcepts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="miconcepts form large-9 medium-8 columns content">
    <?= $this->Form->create($miconcept) ?>
    <fieldset>
        <legend><?= __('Add Miconcept') ?></legend>
        <?php
            echo $this->Form->input('idd');
            echo $this->Form->input('codigo_art');
            echo $this->Form->input('descripcion');
            echo $this->Form->input('total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
