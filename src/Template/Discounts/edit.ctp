<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $discount->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $discount->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Discounts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="discounts form large-9 medium-8 columns content">
    <?= $this->Form->create($discount) ?>
    <fieldset>
        <legend><?= __('Edit Discount') ?></legend>
        <?php
            echo $this->Form->input('description_discount');
            echo $this->Form->input('discount_mode');
            echo $this->Form->input('discount_amount');
            echo $this->Form->input('whole_rounding');
            echo $this->Form->input('date_from', ['empty' => true]);
            echo $this->Form->input('date_until', ['empty' => true]);
            echo $this->Form->input('extra_column1');
            echo $this->Form->input('extra_column2');
            echo $this->Form->input('extra_column3');
            echo $this->Form->input('extra_column4');
            echo $this->Form->input('extra_column5');
            echo $this->Form->input('extra_column6');
            echo $this->Form->input('extra_column7');
            echo $this->Form->input('extra_column8');
            echo $this->Form->input('extra_column9');
            echo $this->Form->input('extra_column10');
            echo $this->Form->input('registration_status');
            echo $this->Form->input('reason_status');
            echo $this->Form->input('date_status', ['empty' => true]);
            echo $this->Form->input('responsible_user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
