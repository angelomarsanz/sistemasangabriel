<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Studenttransaction'), ['action' => 'edit', $studenttransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Studenttransaction'), ['action' => 'delete', $studenttransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studenttransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Studenttransactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Studenttransaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="studenttransactions view large-9 medium-8 columns content">
    <h3><?= h($studenttransaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $studenttransaction->has('student') ? $this->Html->link($studenttransaction->student->full_name, ['controller' => 'Students', 'action' => 'view', $studenttransaction->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Type') ?></th>
            <td><?= h($studenttransaction->transaction_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Description') ?></th>
            <td><?= h($studenttransaction->transaction_description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($studenttransaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($studenttransaction->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($studenttransaction->payment_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($studenttransaction->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($studenttransaction->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paid Out') ?></th>
            <td><?= $studenttransaction->paid_out ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
