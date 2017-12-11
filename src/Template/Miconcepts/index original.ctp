<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Miconcept'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="miconcepts index large-9 medium-8 columns content">
    <h3><?= __('Miconcepts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('idd') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo_art') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($miconcepts as $miconcept): ?>
            <tr>
                <td><?= $this->Number->format($miconcept->id) ?></td>
                <td><?= $this->Number->format($miconcept->idd) ?></td>
                <td><?= $this->Number->format($miconcept->codigo_art) ?></td>
                <td><?= h($miconcept->descripcion) ?></td>
                <td><?= h($miconcept->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $miconcept->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $miconcept->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $miconcept->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miconcept->id)]) ?>
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
