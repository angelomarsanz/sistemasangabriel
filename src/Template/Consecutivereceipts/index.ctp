<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Consecutivereceipt'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="consecutivereceipts index large-9 medium-8 columns content">
    <h3><?= __('Consecutivereceipts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('requesting_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consecutivereceipts as $consecutivereceipt): ?>
            <tr>
                <td><?= $this->Number->format($consecutivereceipt->id) ?></td>
                <td><?= h($consecutivereceipt->requesting_user) ?></td>
                <td><?= h($consecutivereceipt->created) ?></td>
                <td><?= h($consecutivereceipt->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consecutivereceipt->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consecutivereceipt->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consecutivereceipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivereceipt->id)]) ?>
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
