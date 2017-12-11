<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Paysheets'), ['controller' => 'Paysheets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Paysheet'), ['controller' => 'Paysheets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeepayments form large-9 medium-8 columns content">
    <?= $this->Form->create($employeepayment) ?>
    <fieldset>
        <legend><?= __('Add Employeepayment') ?></legend>
        <?php
            echo $this->Form->input('paysheet_id', ['options' => $paysheets]);
            echo $this->Form->input('employee_id', ['options' => $employees]);
            echo $this->Form->input('fortnight');
            echo $this->Form->input('scale');
            echo $this->Form->input('overtime');
            echo $this->Form->input('amount_overtime');
            echo $this->Form->input('night_overtime');
            echo $this->Form->input('amount_night_overtime');
            echo $this->Form->input('worked_holidays');
            echo $this->Form->input('amount_worked_holidays');
            echo $this->Form->input('worked_breaks');
            echo $this->Form->input('amount_worked_break');
            echo $this->Form->input('other_income');
            echo $this->Form->input('days_escrow');
            echo $this->Form->input('amount_escrow');
            echo $this->Form->input('faov');
            echo $this->Form->input('ivss');
            echo $this->Form->input('percentage_imposed');
            echo $this->Form->input('amount_imposed');
            echo $this->Form->input('repose');
            echo $this->Form->input('discount_repose');
            echo $this->Form->input('discount_loan');
            echo $this->Form->input('days_absence');
            echo $this->Form->input('discount_absences');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
