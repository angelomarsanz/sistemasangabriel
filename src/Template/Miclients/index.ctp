<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Miclient'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="miclients index large-9 medium-8 columns content">
    <h3><?= __('Miclients') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('clave_familia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('familia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cimadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('apmadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nomadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dirmadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('emailmadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telfmadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('celmadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cipadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('appadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nopadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dirpadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('emailpadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telfpadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('celpadre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ci') ?></th>
                <th scope="col"><?= $this->Paginator->sort('direccion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefono') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hijos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deuda') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($miclients as $miclient): ?>
            <tr>
                <td><?= $this->Number->format($miclient->id) ?></td>
                <td><?= h($miclient->clave_familia) ?></td>
                <td><?= h($miclient->familia) ?></td>
                <td><?= h($miclient->cimadre) ?></td>
                <td><?= h($miclient->apmadre) ?></td>
                <td><?= h($miclient->nomadre) ?></td>
                <td><?= h($miclient->dirmadre) ?></td>
                <td><?= h($miclient->emailmadre) ?></td>
                <td><?= h($miclient->telfmadre) ?></td>
                <td><?= h($miclient->celmadre) ?></td>
                <td><?= h($miclient->cipadre) ?></td>
                <td><?= h($miclient->appadre) ?></td>
                <td><?= h($miclient->nopadre) ?></td>
                <td><?= h($miclient->dirpadre) ?></td>
                <td><?= h($miclient->emailpadre) ?></td>
                <td><?= h($miclient->telfpadre) ?></td>
                <td><?= h($miclient->celpadre) ?></td>
                <td><?= h($miclient->nombre) ?></td>
                <td><?= h($miclient->ci) ?></td>
                <td><?= h($miclient->direccion) ?></td>
                <td><?= h($miclient->telefono) ?></td>
                <td><?= $this->Number->format($miclient->hijos) ?></td>
                <td><?= $this->Number->format($miclient->deuda) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $miclient->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $miclient->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $miclient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miclient->id)]) ?>
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
