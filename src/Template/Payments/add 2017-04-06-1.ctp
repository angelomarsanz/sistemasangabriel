<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bills'), ['controller' => 'Bills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bill'), ['controller' => 'Bills', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payments form large-9 medium-8 columns content">
    <?= $this->Form->create($payment) ?>
    <fieldset>
        <legend><?= __('Add Payment') ?></legend>
        <?php
            echo $this->Form->input('bill_id', ['options' => $bills]);
            echo $this->Form->input('payment_type');
            echo $this->Form->input('amount');
            echo $this->Form->input('bank');
            echo $this->Form->input('account_or_card');
            echo $this->Form->input('serial');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
