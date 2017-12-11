<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Paysheets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['controller' => 'Employeepayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employeepayment'), ['controller' => 'Employeepayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paysheets form large-9 medium-8 columns content">
    <?= $this->Form->create($paysheet) ?>
    <fieldset>
        <legend><?= __('Add Paysheet') ?></legend>
        <?php
            echo $this->Form->input('year_paysheet');
            echo $this->Form->input('month_paysheet');
            echo $this->Form->input('fortnight');
            echo $this->Form->input('date_from', ['empty' => true]);
            echo $this->Form->input('date_until', ['empty' => true]);
            echo $this->Form->input('weeks_social_security');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
