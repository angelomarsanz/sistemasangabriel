<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Guardiantransaction'), ['action' => 'edit', $guardiantransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Guardiantransaction'), ['action' => 'delete', $guardiantransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guardiantransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Guardiantransactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Guardiantransaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parentsandguardians'), ['controller' => 'Parentsandguardians', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parentsandguardian'), ['controller' => 'Parentsandguardians', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="guardiantransactions view large-9 medium-8 columns content">
    <h3><?= h($guardiantransaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Parentsandguardian') ?></th>
            <td><?= $guardiantransaction->has('parentsandguardian') ? $this->Html->link($guardiantransaction->parentsandguardian->full_name, ['controller' => 'Parentsandguardians', 'action' => 'view', $guardiantransaction->parentsandguardian->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bank') ?></th>
            <td><?= h($guardiantransaction->bank) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Serial') ?></th>
            <td><?= h($guardiantransaction->serial) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Concept') ?></th>
            <td><?= h($guardiantransaction->concept) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($guardiantransaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($guardiantransaction->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date And Time') ?></th>
            <td><?= h($guardiantransaction->date_and_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($guardiantransaction->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($guardiantransaction->modified) ?></td>
        </tr>
    </table>
</div>
