<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payrollparameter'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payrollparameters index large-9 medium-8 columns content">
    <h3><?= __('Payrollparameters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parameter') ?></th>
                <th scope="col"><?= $this->Paginator->sort('new_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payrollparameters as $payrollparameter): ?>
            <tr>
                <td><?= $this->Number->format($payrollparameter->id) ?></td>
                <td><?= h($payrollparameter->parameter) ?></td>
                <td><?= $this->Number->format($payrollparameter->new_value) ?></td>
                <td><?= h($payrollparameter->created) ?></td>
                <td><?= h($payrollparameter->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payrollparameter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payrollparameter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payrollparameter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrollparameter->id)]) ?>
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
