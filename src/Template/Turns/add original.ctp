<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Turns'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="turns form large-9 medium-8 columns content">
    <?= $this->Form->create($turn) ?>
    <fieldset>
        <legend><?= __('Add Turn') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('turn');
            echo $this->Form->input('start_date');
            echo $this->Form->input('end_date');
            echo $this->Form->input('status');
            echo $this->Form->input('initial_cash');
            echo $this->Form->input('cash_received');
            echo $this->Form->input('cash_paid');
            echo $this->Form->input('real_cash');
            echo $this->Form->input('debit_card_amount');
            echo $this->Form->input('real_debit_card_amount');
            echo $this->Form->input('credit_card_amount');
            echo $this->Form->input('real_credit_amount');
            echo $this->Form->input('transfer_amount');
            echo $this->Form->input('real_transfer_amount');
            echo $this->Form->input('deposit_amount');
            echo $this->Form->input('real_deposit_amount');
            echo $this->Form->input('check_amount');
            echo $this->Form->input('real_check_amount');
            echo $this->Form->input('retention_amount');
            echo $this->Form->input('real_retention_amount');
            echo $this->Form->input('opening_supervisor');
            echo $this->Form->input('supervisor_close');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
