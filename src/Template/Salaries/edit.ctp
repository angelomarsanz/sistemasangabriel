<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salary->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salary->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Salaries'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="salaries form large-9 medium-8 columns content">
    <?= $this->Form->create($salary) ?>
    <fieldset>
        <legend><?= __('Edit Salary') ?></legend>
        <?php
            echo $this->Form->input('positions_id');
            echo $this->Form->input('new_salary');
            echo $this->Form->input('reason');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
