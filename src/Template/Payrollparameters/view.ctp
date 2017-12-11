<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payrollparameter'), ['action' => 'edit', $payrollparameter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payrollparameter'), ['action' => 'delete', $payrollparameter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrollparameter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payrollparameters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payrollparameter'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payrollparameters view large-9 medium-8 columns content">
    <h3><?= h($payrollparameter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Parameter') ?></th>
            <td><?= h($payrollparameter->parameter) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($payrollparameter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New Value') ?></th>
            <td><?= $this->Number->format($payrollparameter->new_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($payrollparameter->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($payrollparameter->modified) ?></td>
        </tr>
    </table>
</div>
