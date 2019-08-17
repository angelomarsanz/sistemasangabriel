<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Consecutivocredito'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="consecutivocreditos index large-9 medium-8 columns content">
    <h3><?= __('Consecutivocreditos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('usuario_solicitante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consecutivocreditos as $consecutivocredito): ?>
            <tr>
                <td><?= $this->Number->format($consecutivocredito->id) ?></td>
                <td><?= h($consecutivocredito->usuario_solicitante) ?></td>
                <td><?= h($consecutivocredito->created) ?></td>
                <td><?= h($consecutivocredito->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consecutivocredito->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consecutivocredito->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consecutivocredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivocredito->id)]) ?>
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
