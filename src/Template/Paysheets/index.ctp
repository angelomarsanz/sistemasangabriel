<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Paysheet'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['controller' => 'Employeepayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employeepayment'), ['controller' => 'Employeepayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paysheets index large-9 medium-8 columns content">
    <h3><?= __('Paysheets') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('year_paysheet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('month_paysheet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fortnight') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_until') ?></th>
                <th scope="col"><?= $this->Paginator->sort('weeks_social_security') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paysheets as $paysheet): ?>
            <tr>
                <td><?= $this->Number->format($paysheet->id) ?></td>
                <td><?= h($paysheet->year_paysheet) ?></td>
                <td><?= h($paysheet->month_paysheet) ?></td>
                <td><?= h($paysheet->fortnight) ?></td>
                <td><?= h($paysheet->date_from) ?></td>
                <td><?= h($paysheet->date_until) ?></td>
                <td><?= $this->Number->format($paysheet->weeks_social_security) ?></td>
                <td><?= h($paysheet->created) ?></td>
                <td><?= h($paysheet->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $paysheet->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paysheet->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paysheet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paysheet->id)]) ?>
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
