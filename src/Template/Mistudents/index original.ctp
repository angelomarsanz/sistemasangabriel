<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Mistudent'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="mistudents index large-9 medium-8 columns content">
    <h3><?= __('Mistudents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('familia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('idd') ?></th>
                <th scope="col"><?= $this->Paginator->sort('apellidos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombres') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sexo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nacimiento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('direccion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seccion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('condicion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('escolaridad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cuota') ?></th>
                <th scope="col"><?= $this->Paginator->sort('saldo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sep') ?></th>
                <th scope="col"><?= $this->Paginator->sort('oct') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nov') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dic') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ene') ?></th>
                <th scope="col"><?= $this->Paginator->sort('feb') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('abr') ?></th>
                <th scope="col"><?= $this->Paginator->sort('may') ?></th>
                <th scope="col"><?= $this->Paginator->sort('jun') ?></th>
                <th scope="col"><?= $this->Paginator->sort('jul') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ago') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mensualidad') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mistudents as $mistudent): ?>
            <tr>
                <td><?= $this->Number->format($mistudent->id) ?></td>
                <td><?= h($mistudent->codigo) ?></td>
                <td><?= h($mistudent->familia) ?></td>
                <td><?= $this->Number->format($mistudent->idd) ?></td>
                <td><?= h($mistudent->apellidos) ?></td>
                <td><?= h($mistudent->nombres) ?></td>
                <td><?= h($mistudent->sexo) ?></td>
                <td><?= h($mistudent->nacimiento) ?></td>
                <td><?= h($mistudent->direccion) ?></td>
                <td><?= h($mistudent->grado) ?></td>
                <td><?= h($mistudent->seccion) ?></td>
                <td><?= h($mistudent->condicion) ?></td>
                <td><?= h($mistudent->escolaridad) ?></td>
                <td><?= $this->Number->format($mistudent->cuota) ?></td>
                <td><?= $this->Number->format($mistudent->saldo) ?></td>
                <td><?= $this->Number->format($mistudent->sep) ?></td>
                <td><?= $this->Number->format($mistudent->oct) ?></td>
                <td><?= $this->Number->format($mistudent->nov) ?></td>
                <td><?= $this->Number->format($mistudent->dic) ?></td>
                <td><?= $this->Number->format($mistudent->ene) ?></td>
                <td><?= h($mistudent->feb) ?></td>
                <td><?= h($mistudent->mar) ?></td>
                <td><?= $this->Number->format($mistudent->abr) ?></td>
                <td><?= h($mistudent->may) ?></td>
                <td><?= $this->Number->format($mistudent->jun) ?></td>
                <td><?= $this->Number->format($mistudent->jul) ?></td>
                <td><?= $this->Number->format($mistudent->ago) ?></td>
                <td><?= $this->Number->format($mistudent->mensualidad) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $mistudent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mistudent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $mistudent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mistudent->id)]) ?>
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
