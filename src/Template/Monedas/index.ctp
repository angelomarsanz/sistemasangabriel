<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Moneda'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Historicotasas'), ['controller' => 'Historicotasas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Historicotasa'), ['controller' => 'Historicotasas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="monedas index large-9 medium-8 columns content">
    <h3><?= __('Monedas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('moneda') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tasa_cambio_dolar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra5') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra6') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra7') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra8') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra9') ?></th>
                <th scope="col"><?= $this->Paginator->sort('columna_extra10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estatus_registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivo_cambio_estatus') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha_cambio_estatus') ?></th>
                <th scope="col"><?= $this->Paginator->sort('usuario_responsable') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monedas as $moneda): ?>
            <tr>
                <td><?= $this->Number->format($moneda->id) ?></td>
                <td><?= h($moneda->moneda) ?></td>
                <td><?= $this->Number->format($moneda->tasa_cambio_dolar) ?></td>
                <td><?= h($moneda->columna_extra1) ?></td>
                <td><?= h($moneda->columna_extra2) ?></td>
                <td><?= h($moneda->columna_extra3) ?></td>
                <td><?= h($moneda->columna_extra4) ?></td>
                <td><?= h($moneda->columna_extra5) ?></td>
                <td><?= h($moneda->columna_extra6) ?></td>
                <td><?= h($moneda->columna_extra7) ?></td>
                <td><?= h($moneda->columna_extra8) ?></td>
                <td><?= h($moneda->columna_extra9) ?></td>
                <td><?= h($moneda->columna_extra10) ?></td>
                <td><?= h($moneda->estatus_registro) ?></td>
                <td><?= h($moneda->motivo_cambio_estatus) ?></td>
                <td><?= h($moneda->fecha_cambio_estatus) ?></td>
                <td><?= h($moneda->usuario_responsable) ?></td>
                <td><?= h($moneda->created) ?></td>
                <td><?= h($moneda->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $moneda->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $moneda->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $moneda->id], ['confirm' => __('Are you sure you want to delete # {0}?', $moneda->id)]) ?>
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
