<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Evento'), ['action' => 'edit', $evento->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Evento'), ['action' => 'delete', $evento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evento->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Eventos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eventos view large-9 medium-8 columns content">
    <h3><?= h($evento->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $evento->has('user') ? $this->Html->link($evento->user->id, ['controller' => 'Users', 'action' => 'view', $evento->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Modulo') ?></th>
            <td><?= h($evento->tipo_modulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre Modulo') ?></th>
            <td><?= h($evento->nombre_modulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre Metodo') ?></th>
            <td><?= h($evento->nombre_metodo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra1') ?></th>
            <td><?= h($evento->columna_extra1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra2') ?></th>
            <td><?= h($evento->columna_extra2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra3') ?></th>
            <td><?= h($evento->columna_extra3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra4') ?></th>
            <td><?= h($evento->columna_extra4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra5') ?></th>
            <td><?= h($evento->columna_extra5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra6') ?></th>
            <td><?= h($evento->columna_extra6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra7') ?></th>
            <td><?= h($evento->columna_extra7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra8') ?></th>
            <td><?= h($evento->columna_extra8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra9') ?></th>
            <td><?= h($evento->columna_extra9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Columna Extra10') ?></th>
            <td><?= h($evento->columna_extra10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estatus Registro') ?></th>
            <td><?= h($evento->estatus_registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Motivo Cambio Estatus') ?></th>
            <td><?= h($evento->motivo_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario Responsable') ?></th>
            <td><?= h($evento->usuario_responsable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($evento->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Cambio Estatus') ?></th>
            <td><?= h($evento->fecha_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($evento->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($evento->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Descripcion') ?></h4>
        <?= $this->Text->autoParagraph(h($evento->descripcion)); ?>
    </div>
</div>
