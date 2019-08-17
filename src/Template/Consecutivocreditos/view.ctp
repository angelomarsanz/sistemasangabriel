<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Consecutivocredito'), ['action' => 'edit', $consecutivocredito->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Consecutivocredito'), ['action' => 'delete', $consecutivocredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivocredito->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Consecutivocreditos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consecutivocredito'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="consecutivocreditos view large-9 medium-8 columns content">
    <h3><?= h($consecutivocredito->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Usuario Solicitante') ?></th>
            <td><?= h($consecutivocredito->usuario_solicitante) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($consecutivocredito->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($consecutivocredito->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($consecutivocredito->modified) ?></td>
        </tr>
    </table>
</div>
