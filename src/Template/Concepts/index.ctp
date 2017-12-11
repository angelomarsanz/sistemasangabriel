<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Concept'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bills'), ['controller' => 'Bills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bill'), ['controller' => 'Bills', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="concepts index large-9 medium-8 columns content">
    <h3><?= __('Concepts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bill_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accounting_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('concept') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($concepts as $concept): ?>
            <tr>
                <td><?= $this->Number->format($concept->id) ?></td>
                <td><?= $concept->has('bill') ? $this->Html->link($concept->bill->id, ['controller' => 'Bills', 'action' => 'view', $concept->bill->id]) : '' ?></td>
                <td><?= $this->Number->format($concept->quantity) ?></td>
                <td><?= h($concept->accounting_code) ?></td>
                <td><?= h($concept->concept) ?></td>
                <td><?= $this->Number->format($concept->amount) ?></td>
                <td><?= h($concept->created) ?></td>
                <td><?= h($concept->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $concept->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $concept->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $concept->id], ['confirm' => __('Are you sure you want to delete # {0}?', $concept->id)]) ?>
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
