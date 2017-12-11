<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Concept'), ['action' => 'edit', $concept->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Concept'), ['action' => 'delete', $concept->id], ['confirm' => __('Are you sure you want to delete # {0}?', $concept->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Concepts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Concept'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bills'), ['controller' => 'Bills', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bill'), ['controller' => 'Bills', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="concepts view large-9 medium-8 columns content">
    <h3><?= h($concept->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bill') ?></th>
            <td><?= $concept->has('bill') ? $this->Html->link($concept->bill->id, ['controller' => 'Bills', 'action' => 'view', $concept->bill->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accounting Code') ?></th>
            <td><?= h($concept->accounting_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Concept') ?></th>
            <td><?= h($concept->concept) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($concept->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($concept->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($concept->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($concept->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($concept->modified) ?></td>
        </tr>
    </table>
</div>
