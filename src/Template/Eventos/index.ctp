<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Evento'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventos index large-9 medium-8 columns content">
    <h3><?= __('Eventos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_modulo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_modulo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_metodo') ?></th>
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
            <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= $this->Number->format($evento->id) ?></td>
                <td><?= $evento->has('user') ? $this->Html->link($evento->user->id, ['controller' => 'Users', 'action' => 'view', $evento->user->id]) : '' ?></td>
                <td><?= h($evento->tipo_modulo) ?></td>
                <td><?= h($evento->nombre_modulo) ?></td>
                <td><?= h($evento->nombre_metodo) ?></td>
                <td><?= h($evento->columna_extra1) ?></td>
                <td><?= h($evento->columna_extra2) ?></td>
                <td><?= h($evento->columna_extra3) ?></td>
                <td><?= h($evento->columna_extra4) ?></td>
                <td><?= h($evento->columna_extra5) ?></td>
                <td><?= h($evento->columna_extra6) ?></td>
                <td><?= h($evento->columna_extra7) ?></td>
                <td><?= h($evento->columna_extra8) ?></td>
                <td><?= h($evento->columna_extra9) ?></td>
                <td><?= h($evento->columna_extra10) ?></td>
                <td><?= h($evento->estatus_registro) ?></td>
                <td><?= h($evento->motivo_cambio_estatus) ?></td>
                <td><?= h($evento->fecha_cambio_estatus) ?></td>
                <td><?= h($evento->usuario_responsable) ?></td>
                <td><?= h($evento->created) ?></td>
                <td><?= h($evento->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $evento->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $evento->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $evento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evento->id)]) ?>
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
