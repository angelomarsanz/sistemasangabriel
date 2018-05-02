<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Binnacle'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="binnacles index large-9 medium-8 columns content">
    <h3><?= __('Binnacles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_class') ?></th>
                <th scope="col"><?= $this->Paginator->sort('class_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('method_name') ?></th>
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
            <?php foreach ($binnacles as $binnacle): ?>
            <tr>
                <td><?= $this->Number->format($binnacle->id) ?></td>
                <td><?= h($binnacle->type_class) ?></td>
                <td><?= h($binnacle->class_name) ?></td>
                <td><?= h($binnacle->method_name) ?></td>
                <td><?= h($binnacle->extra_column1) ?></td>
                <td><?= h($binnacle->extra_column2) ?></td>
                <td><?= h($binnacle->extra_column3) ?></td>
                <td><?= h($binnacle->extra_column4) ?></td>
                <td><?= h($binnacle->extra_column5) ?></td>
                <td><?= h($binnacle->extra_column6) ?></td>
                <td><?= h($binnacle->extra_column7) ?></td>
                <td><?= h($binnacle->extra_column8) ?></td>
                <td><?= h($binnacle->extra_column9) ?></td>
                <td><?= h($binnacle->extra_column10) ?></td>
                <td><?= h($binnacle->registration_status) ?></td>
                <td><?= h($binnacle->reason_status) ?></td>
                <td><?= h($binnacle->date_status) ?></td>
                <td><?= h($binnacle->responsible_user) ?></td>
                <td><?= h($binnacle->created) ?></td>
                <td><?= h($binnacle->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $binnacle->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $binnacle->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $binnacle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binnacle->id)]) ?>
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
