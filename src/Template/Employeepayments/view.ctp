<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employeepayment'), ['action' => 'edit', $employeepayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employeepayment'), ['action' => 'delete', $employeepayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeepayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employeepayment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Paysheets'), ['controller' => 'Paysheets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Paysheet'), ['controller' => 'Paysheets', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeepayments view large-9 medium-8 columns content">
    <h3><?= h($employeepayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Paysheet') ?></th>
            <td><?= $employeepayment->has('paysheet') ? $this->Html->link($employeepayment->paysheet->id, ['controller' => 'Paysheets', 'action' => 'view', $employeepayment->paysheet->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $employeepayment->has('employee') ? $this->Html->link($employeepayment->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeepayment->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Worked Holidays') ?></th>
            <td><?= h($employeepayment->worked_holidays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Worked Breaks') ?></th>
            <td><?= h($employeepayment->worked_breaks) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeepayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fortnight') ?></th>
            <td><?= $this->Number->format($employeepayment->fortnight) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Scale') ?></th>
            <td><?= $this->Number->format($employeepayment->scale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Overtime') ?></th>
            <td><?= $this->Number->format($employeepayment->overtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Overtime') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_overtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Night Overtime') ?></th>
            <td><?= $this->Number->format($employeepayment->night_overtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Night Overtime') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_night_overtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Worked Holidays') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_worked_holidays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Worked Break') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_worked_break) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Income') ?></th>
            <td><?= $this->Number->format($employeepayment->other_income) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Days Escrow') ?></th>
            <td><?= $this->Number->format($employeepayment->days_escrow) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Escrow') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_escrow) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Faov') ?></th>
            <td><?= $this->Number->format($employeepayment->faov) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ivss') ?></th>
            <td><?= $this->Number->format($employeepayment->ivss) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Percentage Imposed') ?></th>
            <td><?= $this->Number->format($employeepayment->percentage_imposed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Imposed') ?></th>
            <td><?= $this->Number->format($employeepayment->amount_imposed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Repose') ?></th>
            <td><?= $this->Number->format($employeepayment->discount_repose) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Loan') ?></th>
            <td><?= $this->Number->format($employeepayment->discount_loan) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Days Absence') ?></th>
            <td><?= $this->Number->format($employeepayment->days_absence) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Absences') ?></th>
            <td><?= $this->Number->format($employeepayment->discount_absences) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeepayment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeepayment->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Repose') ?></th>
            <td><?= $employeepayment->repose ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
