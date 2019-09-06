<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Moneda'), ['action' => 'edit', $moneda->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Moneda'), ['action' => 'delete', $moneda->id], ['confirm' => __('Are you sure you want to delete # {0}?', $moneda->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Monedas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Moneda'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Historicotasas'), ['controller' => 'Historicotasas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Historicotasa'), ['controller' => 'Historicotasas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monedas view large-9 medium-8 columns content">
    <h3><?= h($moneda->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Moneda') ?></th>
            <td><?= h($moneda->moneda) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra1') ?></th>
            <td><?= h($moneda->columna_extra1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra2') ?></th>
            <td><?= h($moneda->columna_extra2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra3') ?></th>
            <td><?= h($moneda->columna_extra3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra4') ?></th>
            <td><?= h($moneda->columna_extra4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra5') ?></th>
            <td><?= h($moneda->columna_extra5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra6') ?></th>
            <td><?= h($moneda->columna_extra6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra7') ?></th>
            <td><?= h($moneda->columna_extra7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra8') ?></th>
            <td><?= h($moneda->columna_extra8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra9') ?></th>
            <td><?= h($moneda->columna_extra9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra10') ?></th>
            <td><?= h($moneda->columna_extra10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estatus Registro') ?></th>
            <td><?= h($moneda->estatus_registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Motivo Cambio Estatus') ?></th>
            <td><?= h($moneda->motivo_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario Responsable') ?></th>
            <td><?= h($moneda->usuario_responsable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($moneda->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tasa Cambio Dolar') ?></th>
            <td><?= $this->Number->format($moneda->tasa_cambio_dolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Cambio Estatus') ?></th>
            <td><?= h($moneda->fecha_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($moneda->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($moneda->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Historicotasas') ?></h4>
        <?php if (!empty($moneda->historicotasas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Moneda Id') ?></th>
                <th scope="col"><?= __('Tasa Cambio Dolar') ?></th>
                <th scope="col"><?= __('Columna Extra1') ?></th>
                <th scope="col"><?= __('Columna Extra2') ?></th>
                <th scope="col"><?= __('Columna Extra3') ?></th>
                <th scope="col"><?= __('Columna Extra4') ?></th>
                <th scope="col"><?= __('Columna Extra5') ?></th>
                <th scope="col"><?= __('Columna Extra6') ?></th>
                <th scope="col"><?= __('Columna Extra7') ?></th>
                <th scope="col"><?= __('Columna Extra8') ?></th>
                <th scope="col"><?= __('Columna Extra9') ?></th>
                <th scope="col"><?= __('Columna Extra10') ?></th>
                <th scope="col"><?= __('Estatus Registro') ?></th>
                <th scope="col"><?= __('Motivo Cambio Estatus') ?></th>
                <th scope="col"><?= __('Fecha Cambio Estatus') ?></th>
                <th scope="col"><?= __('Usuario Responsable') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($moneda->historicotasas as $historicotasas): ?>
            <tr>
                <td><?= h($historicotasas->id) ?></td>
                <td><?= h($historicotasas->moneda_id) ?></td>
                <td><?= h($historicotasas->tasa_cambio_dolar) ?></td>
                <td><?= h($historicotasas->columna_extra1) ?></td>
                <td><?= h($historicotasas->columna_extra2) ?></td>
                <td><?= h($historicotasas->columna_extra3) ?></td>
                <td><?= h($historicotasas->columna_extra4) ?></td>
                <td><?= h($historicotasas->columna_extra5) ?></td>
                <td><?= h($historicotasas->columna_extra6) ?></td>
                <td><?= h($historicotasas->columna_extra7) ?></td>
                <td><?= h($historicotasas->columna_extra8) ?></td>
                <td><?= h($historicotasas->columna_extra9) ?></td>
                <td><?= h($historicotasas->columna_extra10) ?></td>
                <td><?= h($historicotasas->estatus_registro) ?></td>
                <td><?= h($historicotasas->motivo_cambio_estatus) ?></td>
                <td><?= h($historicotasas->fecha_cambio_estatus) ?></td>
                <td><?= h($historicotasas->usuario_responsable) ?></td>
                <td><?= h($historicotasas->created) ?></td>
                <td><?= h($historicotasas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Historicotasas', 'action' => 'view', $historicotasas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Historicotasas', 'action' => 'edit', $historicotasas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Historicotasas', 'action' => 'delete', $historicotasas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicotasas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
