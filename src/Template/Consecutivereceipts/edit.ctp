<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $consecutivereceipt->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivereceipt->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Consecutivereceipts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="consecutivereceipts form large-9 medium-8 columns content">
    <?= $this->Form->create($consecutivereceipt) ?>
    <fieldset>
        <legend><?= __('Edit Consecutivereceipt') ?></legend>
        <?php
            echo $this->Form->input('requesting_user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
