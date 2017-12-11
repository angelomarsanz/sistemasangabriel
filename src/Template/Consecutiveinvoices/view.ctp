<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Consecutiveinvoice'), ['action' => 'edit', $consecutiveinvoice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Consecutiveinvoice'), ['action' => 'delete', $consecutiveinvoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutiveinvoice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Consecutiveinvoices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consecutiveinvoice'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="consecutiveinvoices view large-9 medium-8 columns content">
    <h3><?= h($consecutiveinvoice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Requesting User') ?></th>
            <td><?= h($consecutiveinvoice->requesting_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($consecutiveinvoice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($consecutiveinvoice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($consecutiveinvoice->modified) ?></td>
        </tr>
    </table>
</div>
