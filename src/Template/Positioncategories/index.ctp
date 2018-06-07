<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Positioncategory'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="positioncategories index large-9 medium-8 columns content">
    <h3><?= __('Positioncategories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description_category') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column5') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column6') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column7') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column8') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column9') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extra_column10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registration_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reason_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('responsible_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($positioncategories as $positioncategory): ?>
            <tr>
                <td><?= $this->Number->format($positioncategory->id) ?></td>
                <td><?= h($positioncategory->description_category) ?></td>
                <td><?= h($positioncategory->extra_column1) ?></td>
                <td><?= h($positioncategory->extra_column2) ?></td>
                <td><?= h($positioncategory->extra_column3) ?></td>
                <td><?= h($positioncategory->extra_column4) ?></td>
                <td><?= h($positioncategory->extra_column5) ?></td>
                <td><?= h($positioncategory->extra_column6) ?></td>
                <td><?= h($positioncategory->extra_column7) ?></td>
                <td><?= h($positioncategory->extra_column8) ?></td>
                <td><?= h($positioncategory->extra_column9) ?></td>
                <td><?= h($positioncategory->extra_column10) ?></td>
                <td><?= h($positioncategory->registration_status) ?></td>
                <td><?= h($positioncategory->reason_status) ?></td>
                <td><?= h($positioncategory->date_status) ?></td>
                <td><?= h($positioncategory->responsible_user) ?></td>
                <td><?= h($positioncategory->created) ?></td>
                <td><?= h($positioncategory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $positioncategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $positioncategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $positioncategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $positioncategory->id)]) ?>
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
