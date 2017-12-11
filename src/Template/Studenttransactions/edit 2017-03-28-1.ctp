<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $studenttransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $studenttransaction->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Studenttransactions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="studenttransactions form large-9 medium-8 columns content">
    <?= $this->Form->create($studenttransaction) ?>
    <fieldset>
        <legend><?= __('Edit Studenttransaction') ?></legend>
        <?php
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('payment_date');
            echo $this->Form->input('transaction_type');
            echo $this->Form->input('transaction_description');
            echo $this->Form->input('paid_out');
            echo $this->Form->input('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
