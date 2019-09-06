<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Historicotasa'), ['action' => 'edit', $historicotasa->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Historicotasa'), ['action' => 'delete', $historicotasa->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicotasa->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Historicotasas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Historicotasa'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monedas'), ['controller' => 'Monedas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Moneda'), ['controller' => 'Monedas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="historicotasas view large-9 medium-8 columns content">
    <h3><?= h($historicotasa->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Moneda') ?></th>
            <td><?= $historicotasa->has('moneda') ? $this->Html->link($historicotasa->moneda->id, ['controller' => 'Monedas', 'action' => 'view', $historicotasa->moneda->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra1') ?></th>
            <td><?= h($historicotasa->columna_extra1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra2') ?></th>
            <td><?= h($historicotasa->columna_extra2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra3') ?></th>
            <td><?= h($historicotasa->columna_extra3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra4') ?></th>
            <td><?= h($historicotasa->columna_extra4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra5') ?></th>
            <td><?= h($historicotasa->columna_extra5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra6') ?></th>
            <td><?= h($historicotasa->columna_extra6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra7') ?></th>
            <td><?= h($historicotasa->columna_extra7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra8') ?></th>
            <td><?= h($historicotasa->columna_extra8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra9') ?></th>
            <td><?= h($historicotasa->columna_extra9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra10') ?></th>
            <td><?= h($historicotasa->columna_extra10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estatus Registro') ?></th>
            <td><?= h($historicotasa->estatus_registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Motivo Cambio Estatus') ?></th>
            <td><?= h($historicotasa->motivo_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario Responsable') ?></th>
            <td><?= h($historicotasa->usuario_responsable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($historicotasa->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tasa Cambio Dolar') ?></th>
            <td><?= $this->Number->format($historicotasa->tasa_cambio_dolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Cambio Estatus') ?></th>
            <td><?= h($historicotasa->fecha_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($historicotasa->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($historicotasa->modified) ?></td>
        </tr>
    </table>
</div>
