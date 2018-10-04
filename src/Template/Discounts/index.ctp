<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Discount'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="discounts index large-9 medium-8 columns content">
    <h3><?= __('Discounts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description_discount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_mode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('whole_rounding') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_until') ?></th>
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
            <?php foreach ($discounts as $discount): ?>
            <tr>
                <td><?= $this->Number->format($discount->id) ?></td>
                <td><?= h($discount->description_discount) ?></td>
                <td><?= h($discount->discount_mode) ?></td>
                <td><?= $this->Number->format($discount->discount_amount) ?></td>
                <td><?= h($discount->whole_rounding) ?></td>
                <td><?= h($discount->date_from) ?></td>
                <td><?= h($discount->date_until) ?></td>
                <td><?= h($discount->extra_column1) ?></td>
                <td><?= h($discount->extra_column2) ?></td>
                <td><?= h($discount->extra_column3) ?></td>
                <td><?= h($discount->extra_column4) ?></td>
                <td><?= h($discount->extra_column5) ?></td>
                <td><?= h($discount->extra_column6) ?></td>
                <td><?= h($discount->extra_column7) ?></td>
                <td><?= h($discount->extra_column8) ?></td>
                <td><?= h($discount->extra_column9) ?></td>
                <td><?= h($discount->extra_column10) ?></td>
                <td><?= h($discount->registration_status) ?></td>
                <td><?= h($discount->reason_status) ?></td>
                <td><?= h($discount->date_status) ?></td>
                <td><?= h($discount->responsible_user) ?></td>
                <td><?= h($discount->created) ?></td>
                <td><?= h($discount->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $discount->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $discount->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $discount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discount->id)]) ?>
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
