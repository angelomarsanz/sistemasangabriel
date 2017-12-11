<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Consecutivereceipt'), ['action' => 'edit', $consecutivereceipt->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Consecutivereceipt'), ['action' => 'delete', $consecutivereceipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivereceipt->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Consecutivereceipts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consecutivereceipt'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="consecutivereceipts view large-9 medium-8 columns content">
    <h3><?= h($consecutivereceipt->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Requesting User') ?></th>
            <td><?= h($consecutivereceipt->requesting_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($consecutivereceipt->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($consecutivereceipt->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($consecutivereceipt->modified) ?></td>
        </tr>
    </table>
</div>
