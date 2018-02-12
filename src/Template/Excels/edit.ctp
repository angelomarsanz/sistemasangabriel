<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $excel->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $excel->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Excels'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="excels form large-9 medium-8 columns content">
    <?= $this->Form->create($excel) ?>
    <fieldset>
        <legend><?= __('Edit Excel') ?></legend>
        <?php
            echo $this->Form->input('report');
            echo $this->Form->input('start-end');
            echo $this->Form->input('number');
            echo $this->Form->input('col1');
            echo $this->Form->input('col2');
            echo $this->Form->input('col3');
            echo $this->Form->input('col4');
            echo $this->Form->input('col5');
            echo $this->Form->input('col6');
            echo $this->Form->input('col7');
            echo $this->Form->input('col8');
            echo $this->Form->input('col9');
            echo $this->Form->input('col10');
            echo $this->Form->input('col11');
            echo $this->Form->input('col12');
            echo $this->Form->input('col13');
            echo $this->Form->input('col14');
            echo $this->Form->input('col15');
            echo $this->Form->input('col16');
            echo $this->Form->input('col17');
            echo $this->Form->input('col18');
            echo $this->Form->input('col19');
            echo $this->Form->input('col20');
            echo $this->Form->input('registration_status');
            echo $this->Form->input('reason_status');
            echo $this->Form->input('date_status', ['empty' => true]);
            echo $this->Form->input('responsible_user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
