<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bill->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bills'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="bills form large-9 medium-8 columns content">
    <?= $this->Form->create($bill) ?>
    <fieldset>
        <legend><?= __('Edit Bill') ?></legend>
        <?php
            echo $this->Form->input('parentsandguardian_id');
            echo $this->Form->input('user_id');
            echo $this->Form->input('date_and_time');
            echo $this->Form->input('bill_number');
            echo $this->Form->input('identification');
            echo $this->Form->input('client');
            echo $this->Form->input('tax_phone');
            echo $this->Form->input('fiscal_address');
            echo $this->Form->input('amount');
            echo $this->Form->input('amount_paid');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
