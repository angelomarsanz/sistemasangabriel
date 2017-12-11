<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Turn'), ['action' => 'edit', $turn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Turn'), ['action' => 'delete', $turn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $turn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Turns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Turn'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="turns view large-9 medium-8 columns content">
    <h3><?= h($turn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $turn->has('user') ? $this->Html->link($turn->user->id, ['controller' => 'Users', 'action' => 'view', $turn->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Turn') ?></th>
            <td><?= h($turn->turn) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($turn->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Initial Cash') ?></th>
            <td><?= $this->Number->format($turn->initial_cash) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cash Received') ?></th>
            <td><?= $this->Number->format($turn->cash_received) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cash Paid') ?></th>
            <td><?= $this->Number->format($turn->cash_paid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Cash') ?></th>
            <td><?= $this->Number->format($turn->real_cash) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Card Amount') ?></th>
            <td><?= $this->Number->format($turn->debit_card_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Debit Card Amount') ?></th>
            <td><?= $this->Number->format($turn->real_debit_card_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Card Amount') ?></th>
            <td><?= $this->Number->format($turn->credit_card_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Credit Amount') ?></th>
            <td><?= $this->Number->format($turn->real_credit_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transfer Amount') ?></th>
            <td><?= $this->Number->format($turn->transfer_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Transfer Amount') ?></th>
            <td><?= $this->Number->format($turn->real_transfer_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deposit Amount') ?></th>
            <td><?= $this->Number->format($turn->deposit_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Deposit Amount') ?></th>
            <td><?= $this->Number->format($turn->real_deposit_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Check Amount') ?></th>
            <td><?= $this->Number->format($turn->check_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Check Amount') ?></th>
            <td><?= $this->Number->format($turn->real_check_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Retention Amount') ?></th>
            <td><?= $this->Number->format($turn->retention_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Real Retention Amount') ?></th>
            <td><?= $this->Number->format($turn->real_retention_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opening Supervisor') ?></th>
            <td><?= $this->Number->format($turn->opening_supervisor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supervisor Close') ?></th>
            <td><?= $this->Number->format($turn->supervisor_close) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($turn->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($turn->end_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($turn->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($turn->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $turn->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
