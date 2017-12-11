<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Turn'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="turns index large-9 medium-8 columns content">
    <h3><?= __('Turns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('turn') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('initial_cash') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cash_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cash_paid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_cash') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit_card_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_debit_card_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_card_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_credit_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transfer_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_transfer_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deposit_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_deposit_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('check_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_check_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('retention_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('real_retention_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('opening_supervisor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('supervisor_close') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($turns as $turn): ?>
            <tr>
                <td><?= $this->Number->format($turn->id) ?></td>
                <td><?= $turn->has('user') ? $this->Html->link($turn->user->id, ['controller' => 'Users', 'action' => 'view', $turn->user->id]) : '' ?></td>
                <td><?= h($turn->turn) ?></td>
                <td><?= h($turn->start_date) ?></td>
                <td><?= h($turn->end_date) ?></td>
                <td><?= h($turn->status) ?></td>
                <td><?= $this->Number->format($turn->initial_cash) ?></td>
                <td><?= $this->Number->format($turn->cash_received) ?></td>
                <td><?= $this->Number->format($turn->cash_paid) ?></td>
                <td><?= $this->Number->format($turn->real_cash) ?></td>
                <td><?= $this->Number->format($turn->debit_card_amount) ?></td>
                <td><?= $this->Number->format($turn->real_debit_card_amount) ?></td>
                <td><?= $this->Number->format($turn->credit_card_amount) ?></td>
                <td><?= $this->Number->format($turn->real_credit_amount) ?></td>
                <td><?= $this->Number->format($turn->transfer_amount) ?></td>
                <td><?= $this->Number->format($turn->real_transfer_amount) ?></td>
                <td><?= $this->Number->format($turn->deposit_amount) ?></td>
                <td><?= $this->Number->format($turn->real_deposit_amount) ?></td>
                <td><?= $this->Number->format($turn->check_amount) ?></td>
                <td><?= $this->Number->format($turn->real_check_amount) ?></td>
                <td><?= $this->Number->format($turn->retention_amount) ?></td>
                <td><?= $this->Number->format($turn->real_retention_amount) ?></td>
                <td><?= $this->Number->format($turn->opening_supervisor) ?></td>
                <td><?= $this->Number->format($turn->supervisor_close) ?></td>
                <td><?= h($turn->created) ?></td>
                <td><?= h($turn->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $turn->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $turn->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $turn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $turn->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
