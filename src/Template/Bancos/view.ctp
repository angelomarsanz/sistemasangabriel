<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Banco'), ['action' => 'edit', $banco->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Banco'), ['action' => 'delete', $banco->id], ['confirm' => __('Are you sure you want to delete # {0}?', $banco->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bancos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Banco'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bancos view large-9 medium-8 columns content">
    <h3><?= h($banco->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre Banco') ?></th>
            <td><?= h($banco->nombre_banco) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Banco') ?></th>
            <td><?= h($banco->tipo_banco) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estatus Registro') ?></th>
            <td><?= h($banco->estatus_registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario Creador') ?></th>
            <td><?= h($banco->usuario_creador) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario Cambio Estatus') ?></th>
            <td><?= h($banco->usuario_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($banco->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Cambio Estatus') ?></th>
            <td><?= h($banco->fecha_cambio_estatus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($banco->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($banco->modified) ?></td>
        </tr>
    </table>
</div>
