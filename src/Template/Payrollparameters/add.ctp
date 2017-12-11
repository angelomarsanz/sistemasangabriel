<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Payrollparameters'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="payrollparameters form large-9 medium-8 columns content">
    <?= $this->Form->create($payrollparameter) ?>
    <fieldset>
        <legend><?= __('Add Payrollparameter') ?></legend>
        <?php
            echo $this->Form->input('parameter');
            echo $this->Form->input('new_value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
