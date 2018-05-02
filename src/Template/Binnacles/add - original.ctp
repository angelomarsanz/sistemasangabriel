<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Binnacles'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="binnacles form large-9 medium-8 columns content">
    <?= $this->Form->create($binnacle) ?>
    <fieldset>
        <legend><?= __('Add Binnacle') ?></legend>
        <?php
            echo $this->Form->input('novelty');
            echo $this->Form->input('type_class');
            echo $this->Form->input('class_name');
            echo $this->Form->input('method_name');
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
