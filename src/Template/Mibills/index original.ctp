<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Mibill'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="mibills index large-9 medium-8 columns content">
    <h3><?= __('Mibills') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('idd') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ci') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('direccion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefono') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iva') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sub') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('new_family') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mibills as $mibill): ?>
            <tr>
                <td><?= $this->Number->format($mibill->id) ?></td>
                <td><?= $this->Number->format($mibill->idd) ?></td>
                <td><?= h($mibill->ci) ?></td>
                <td><?= h($mibill->nombre) ?></td>
                <td><?= h($mibill->direccion) ?></td>
                <td><?= h($mibill->telefono) ?></td>
                <td><?= h($mibill->iva) ?></td>
                <td><?= h($mibill->total) ?></td>
                <td><?= h($mibill->sub) ?></td>
                <td><?= h($mibill->fecha) ?></td>
                <td><?= h($mibill->status) ?></td>
                <td><?= $this->Number->format($mibill->new_family) ?></td>
                <td><?= h($mibill->created) ?></td>
                <td><?= h($mibill->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $mibill->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mibill->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $mibill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mibill->id)]) ?>
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
