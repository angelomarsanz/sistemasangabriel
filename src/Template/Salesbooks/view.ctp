<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Salesbook'), ['action' => 'edit', $salesbook->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Salesbook'), ['action' => 'delete', $salesbook->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesbook->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Salesbooks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Salesbook'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="salesbooks view large-9 medium-8 columns content">
    <h3><?= h($salesbook->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Type') ?></th>
            <td><?= h($salesbook->document_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identification Client') ?></th>
            <td><?= h($salesbook->identification_client) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name Social Reazon') ?></th>
            <td><?= h($salesbook->name_social_reazon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill Number') ?></th>
            <td><?= h($salesbook->bill_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Control Number') ?></th>
            <td><?= h($salesbook->control_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note') ?></th>
            <td><?= h($salesbook->debit_note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note') ?></th>
            <td><?= h($salesbook->credit_note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Affected') ?></th>
            <td><?= h($salesbook->invoice_affected) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Base') ?></th>
            <td><?= h($salesbook->base) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Aliquot') ?></th>
            <td><?= h($salesbook->aliquot) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($salesbook->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Plus Tax') ?></th>
            <td><?= $this->Number->format($salesbook->sales_plus_tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exonerated Sales') ?></th>
            <td><?= $this->Number->format($salesbook->exonerated_sales) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iva') ?></th>
            <td><?= $this->Number->format($salesbook->iva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Date') ?></th>
            <td><?= h($salesbook->invoice_date) ?></td>
        </tr>
    </table>
</div>
