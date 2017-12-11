<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Salesbook'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="salesbooks index large-9 medium-8 columns content">
    <h3><?= __('Salesbooks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('document_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identification_client') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name_social_reazon') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bill_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('control_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit_note') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_affected') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_plus_tax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('exonerated_sales') ?></th>
                <th scope="col"><?= $this->Paginator->sort('base') ?></th>
                <th scope="col"><?= $this->Paginator->sort('aliquot') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iva') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salesbooks as $salesbook): ?>
            <tr>
                <td><?= $this->Number->format($salesbook->id) ?></td>
                <td><?= h($salesbook->invoice_date) ?></td>
                <td><?= h($salesbook->document_type) ?></td>
                <td><?= h($salesbook->identification_client) ?></td>
                <td><?= h($salesbook->name_social_reazon) ?></td>
                <td><?= h($salesbook->bill_number) ?></td>
                <td><?= h($salesbook->control_number) ?></td>
                <td><?= h($salesbook->debit_note) ?></td>
                <td><?= h($salesbook->credit_note) ?></td>
                <td><?= h($salesbook->invoice_affected) ?></td>
                <td><?= $this->Number->format($salesbook->sales_plus_tax) ?></td>
                <td><?= $this->Number->format($salesbook->exonerated_sales) ?></td>
                <td><?= h($salesbook->base) ?></td>
                <td><?= h($salesbook->aliquot) ?></td>
                <td><?= $this->Number->format($salesbook->iva) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $salesbook->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salesbook->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salesbook->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesbook->id)]) ?>
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
