<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Miclient'), ['action' => 'edit', $miclient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Miclient'), ['action' => 'delete', $miclient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miclient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Miclients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Miclient'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="miclients view large-9 medium-8 columns content">
    <h3><?= h($miclient->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Clave Familia') ?></th>
            <td><?= h($miclient->clave_familia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Familia') ?></th>
            <td><?= h($miclient->familia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cimadre') ?></th>
            <td><?= h($miclient->cimadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apmadre') ?></th>
            <td><?= h($miclient->apmadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nomadre') ?></th>
            <td><?= h($miclient->nomadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dirmadre') ?></th>
            <td><?= h($miclient->dirmadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Emailmadre') ?></th>
            <td><?= h($miclient->emailmadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telfmadre') ?></th>
            <td><?= h($miclient->telfmadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Celmadre') ?></th>
            <td><?= h($miclient->celmadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cipadre') ?></th>
            <td><?= h($miclient->cipadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Appadre') ?></th>
            <td><?= h($miclient->appadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nopadre') ?></th>
            <td><?= h($miclient->nopadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dirpadre') ?></th>
            <td><?= h($miclient->dirpadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Emailpadre') ?></th>
            <td><?= h($miclient->emailpadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telfpadre') ?></th>
            <td><?= h($miclient->telfpadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Celpadre') ?></th>
            <td><?= h($miclient->celpadre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($miclient->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ci') ?></th>
            <td><?= h($miclient->ci) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Direccion') ?></th>
            <td><?= h($miclient->direccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($miclient->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($miclient->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hijos') ?></th>
            <td><?= $this->Number->format($miclient->hijos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deuda') ?></th>
            <td><?= $this->Number->format($miclient->deuda) ?></td>
        </tr>
    </table>
</div>
