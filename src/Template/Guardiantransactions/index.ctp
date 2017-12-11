<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Guardiantransaction'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parentsandguardians'), ['controller' => 'Parentsandguardians', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parentsandguardian'), ['controller' => 'Parentsandguardians', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="guardiantransactions index large-9 medium-8 columns content">
    <h3><?= __('Guardiantransactions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parentsandguardian_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bank') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_and_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('serial') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('concept') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guardiantransactions as $guardiantransaction): ?>
            <tr>
                <td><?= $this->Number->format($guardiantransaction->id) ?></td>
                <td><?= $guardiantransaction->has('parentsandguardian') ? $this->Html->link($guardiantransaction->parentsandguardian->full_name, ['controller' => 'Parentsandguardians', 'action' => 'view', $guardiantransaction->parentsandguardian->id]) : '' ?></td>
                <td><?= h($guardiantransaction->bank) ?></td>
                <td><?= h($guardiantransaction->date_and_time) ?></td>
                <td><?= h($guardiantransaction->serial) ?></td>
                <td><?= $this->Number->format($guardiantransaction->amount) ?></td>
                <td><?= h($guardiantransaction->concept) ?></td>
                <td><?= h($guardiantransaction->created) ?></td>
                <td><?= h($guardiantransaction->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $guardiantransaction->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $guardiantransaction->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $guardiantransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guardiantransaction->id)]) ?>
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
