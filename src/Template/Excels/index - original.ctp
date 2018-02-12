<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Excel'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="excels index large-9 medium-8 columns content">
    <h3><?= __('Excels') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('report') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start-end') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col5') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col6') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col7') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col8') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col9') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col11') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col12') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col13') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col14') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col15') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col16') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col17') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col18') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col19') ?></th>
                <th scope="col"><?= $this->Paginator->sort('col20') ?></th>
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
            <?php foreach ($excels as $excel): ?>
            <tr>
                <td><?= $this->Number->format($excel->id) ?></td>
                <td><?= h($excel->report) ?></td>
                <td><?= h($excel->start-end) ?></td>
                <td><?= $this->Number->format($excel->number) ?></td>
                <td><?= h($excel->col1) ?></td>
                <td><?= h($excel->col2) ?></td>
                <td><?= h($excel->col3) ?></td>
                <td><?= h($excel->col4) ?></td>
                <td><?= h($excel->col5) ?></td>
                <td><?= h($excel->col6) ?></td>
                <td><?= h($excel->col7) ?></td>
                <td><?= h($excel->col8) ?></td>
                <td><?= h($excel->col9) ?></td>
                <td><?= h($excel->col10) ?></td>
                <td><?= h($excel->col11) ?></td>
                <td><?= h($excel->col12) ?></td>
                <td><?= h($excel->col13) ?></td>
                <td><?= h($excel->col14) ?></td>
                <td><?= h($excel->col15) ?></td>
                <td><?= h($excel->col16) ?></td>
                <td><?= h($excel->col17) ?></td>
                <td><?= h($excel->col18) ?></td>
                <td><?= h($excel->col19) ?></td>
                <td><?= h($excel->col20) ?></td>
                <td><?= h($excel->registration_status) ?></td>
                <td><?= h($excel->reason_status) ?></td>
                <td><?= h($excel->date_status) ?></td>
                <td><?= h($excel->responsible_user) ?></td>
                <td><?= h($excel->created) ?></td>
                <td><?= h($excel->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $excel->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $excel->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $excel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $excel->id)]) ?>
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
