<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Controlnumber'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controlnumbers index large-9 medium-8 columns content">
    <h3><?= __('Controlnumbers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_series') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_lot') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($controlnumbers as $controlnumber): ?>
            <tr>
                <td><?= h($controlnumber->id) ?></td>
                <td><?= $this->Number->format($controlnumber->invoice_series) ?></td>
                <td><?= $this->Number->format($controlnumber->invoice_lot) ?></td>
                <td><?= h($controlnumber->created) ?></td>
                <td><?= h($controlnumber->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $controlnumber->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $controlnumber->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $controlnumber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlnumber->id)]) ?>
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
