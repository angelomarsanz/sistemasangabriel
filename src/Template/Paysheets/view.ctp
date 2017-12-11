<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Paysheet'), ['action' => 'edit', $paysheet->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Paysheet'), ['action' => 'delete', $paysheet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paysheet->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Paysheets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Paysheet'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['controller' => 'Employeepayments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employeepayment'), ['controller' => 'Employeepayments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="paysheets view large-9 medium-8 columns content">
    <h3><?= h($paysheet->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Year Paysheet') ?></th>
            <td><?= h($paysheet->year_paysheet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Month Paysheet') ?></th>
            <td><?= h($paysheet->month_paysheet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fortnight') ?></th>
            <td><?= h($paysheet->fortnight) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($paysheet->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Weeks Social Security') ?></th>
            <td><?= $this->Number->format($paysheet->weeks_social_security) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date From') ?></th>
            <td><?= h($paysheet->date_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Until') ?></th>
            <td><?= h($paysheet->date_until) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($paysheet->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($paysheet->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Employeepayments') ?></h4>
        <?php if (!empty($paysheet->employeepayments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Paysheet Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Fortnight') ?></th>
                <th scope="col"><?= __('Scale') ?></th>
                <th scope="col"><?= __('Overtime') ?></th>
                <th scope="col"><?= __('Amount Overtime') ?></th>
                <th scope="col"><?= __('Night Overtime') ?></th>
                <th scope="col"><?= __('Amount Night Overtime') ?></th>
                <th scope="col"><?= __('Worked Holidays') ?></th>
                <th scope="col"><?= __('Amount Worked Holidays') ?></th>
                <th scope="col"><?= __('Worked Breaks') ?></th>
                <th scope="col"><?= __('Amount Worked Break') ?></th>
                <th scope="col"><?= __('Other Income') ?></th>
                <th scope="col"><?= __('Days Escrow') ?></th>
                <th scope="col"><?= __('Amount Escrow') ?></th>
                <th scope="col"><?= __('Faov') ?></th>
                <th scope="col"><?= __('Ivss') ?></th>
                <th scope="col"><?= __('Percentage Imposed') ?></th>
                <th scope="col"><?= __('Amount Imposed') ?></th>
                <th scope="col"><?= __('Repose') ?></th>
                <th scope="col"><?= __('Discount Repose') ?></th>
                <th scope="col"><?= __('Discount Loan') ?></th>
                <th scope="col"><?= __('Days Absence') ?></th>
                <th scope="col"><?= __('Discount Absences') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($paysheet->employeepayments as $employeepayments): ?>
            <tr>
                <td><?= h($employeepayments->id) ?></td>
                <td><?= h($employeepayments->paysheet_id) ?></td>
                <td><?= h($employeepayments->employee_id) ?></td>
                <td><?= h($employeepayments->fortnight) ?></td>
                <td><?= h($employeepayments->scale) ?></td>
                <td><?= h($employeepayments->overtime) ?></td>
                <td><?= h($employeepayments->amount_overtime) ?></td>
                <td><?= h($employeepayments->night_overtime) ?></td>
                <td><?= h($employeepayments->amount_night_overtime) ?></td>
                <td><?= h($employeepayments->worked_holidays) ?></td>
                <td><?= h($employeepayments->amount_worked_holidays) ?></td>
                <td><?= h($employeepayments->worked_breaks) ?></td>
                <td><?= h($employeepayments->amount_worked_break) ?></td>
                <td><?= h($employeepayments->other_income) ?></td>
                <td><?= h($employeepayments->days_escrow) ?></td>
                <td><?= h($employeepayments->amount_escrow) ?></td>
                <td><?= h($employeepayments->faov) ?></td>
                <td><?= h($employeepayments->ivss) ?></td>
                <td><?= h($employeepayments->percentage_imposed) ?></td>
                <td><?= h($employeepayments->amount_imposed) ?></td>
                <td><?= h($employeepayments->repose) ?></td>
                <td><?= h($employeepayments->discount_repose) ?></td>
                <td><?= h($employeepayments->discount_loan) ?></td>
                <td><?= h($employeepayments->days_absence) ?></td>
                <td><?= h($employeepayments->discount_absences) ?></td>
                <td><?= h($employeepayments->created) ?></td>
                <td><?= h($employeepayments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employeepayments', 'action' => 'view', $employeepayments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employeepayments', 'action' => 'edit', $employeepayments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employeepayments', 'action' => 'delete', $employeepayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeepayments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
