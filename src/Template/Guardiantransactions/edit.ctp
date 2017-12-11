<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $guardiantransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $guardiantransaction->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Guardiantransactions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parentsandguardians'), ['controller' => 'Parentsandguardians', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parentsandguardian'), ['controller' => 'Parentsandguardians', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="guardiantransactions form large-9 medium-8 columns content">
    <?= $this->Form->create($guardiantransaction) ?>
    <fieldset>
        <legend><?= __('Edit Guardiantransaction') ?></legend>
        <?php
            echo $this->Form->input('parentsandguardian_id', ['options' => $parentsandguardians]);
            echo $this->Form->input('bank');
            echo $this->Form->input('date_and_time');
            echo $this->Form->input('serial');
            echo $this->Form->input('amount');
            echo $this->Form->input('concept');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
