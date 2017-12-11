<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salesbook->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salesbook->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Salesbooks'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="salesbooks form large-9 medium-8 columns content">
    <?= $this->Form->create($salesbook) ?>
    <fieldset>
        <legend><?= __('Edit Salesbook') ?></legend>
        <?php
            echo $this->Form->input('invoice_date', ['empty' => true]);
            echo $this->Form->input('document_type');
            echo $this->Form->input('identification_client');
            echo $this->Form->input('name_social_reazon');
            echo $this->Form->input('bill_number');
            echo $this->Form->input('control_number');
            echo $this->Form->input('debit_note');
            echo $this->Form->input('credit_note');
            echo $this->Form->input('invoice_affected');
            echo $this->Form->input('sales_plus_tax');
            echo $this->Form->input('exonerated_sales');
            echo $this->Form->input('base');
            echo $this->Form->input('aliquot');
            echo $this->Form->input('iva');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
