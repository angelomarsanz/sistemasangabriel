<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Concepts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bills'), ['controller' => 'Bills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bill'), ['controller' => 'Bills', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="concepts form large-9 medium-8 columns content">
    <?= $this->Form->create($concept) ?>
    <fieldset>
        <legend><?= __('Add Concept') ?></legend>
        <?php
            echo $this->Form->input('bill_id', ['options' => $bills]);
            echo $this->Form->input('quantity');
            echo $this->Form->input('accounting_code');
            echo $this->Form->input('concept');
            echo $this->Form->input('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
