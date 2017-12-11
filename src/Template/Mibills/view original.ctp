<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Mibill'), ['action' => 'edit', $mibill->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Mibill'), ['action' => 'delete', $mibill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mibill->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Mibills'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mibill'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="mibills view large-9 medium-8 columns content">
    <h3><?= h($mibill->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Ci') ?></th>
            <td><?= h($mibill->ci) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($mibill->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Direccion') ?></th>
            <td><?= h($mibill->direccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($mibill->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iva') ?></th>
            <td><?= h($mibill->iva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= h($mibill->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sub') ?></th>
            <td><?= h($mibill->sub) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($mibill->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($mibill->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($mibill->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Idd') ?></th>
            <td><?= $this->Number->format($mibill->idd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New Family') ?></th>
            <td><?= $this->Number->format($mibill->new_family) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($mibill->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($mibill->modified) ?></td>
        </tr>
    </table>
</div>
