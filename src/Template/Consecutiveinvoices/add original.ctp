<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Consecutiveinvoices'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="consecutiveinvoices form large-9 medium-8 columns content">
    <?= $this->Form->create($consecutiveinvoice) ?>
    <fieldset>
        <legend><?= __('Add Consecutiveinvoice') ?></legend>
        <?php
            echo $this->Form->input('requesting_user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
