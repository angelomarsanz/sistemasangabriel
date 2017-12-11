<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Controlnumber'), ['action' => 'edit', $controlnumber->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Controlnumber'), ['action' => 'delete', $controlnumber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlnumber->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Controlnumbers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Controlnumber'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="controlnumbers view large-9 medium-8 columns content">
    <h3><?= h($controlnumber->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($controlnumber->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Series') ?></th>
            <td><?= $this->Number->format($controlnumber->invoice_series) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Lote') ?></th>
            <td><?= $this->Number->format($controlnumber->invoice_lote) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($controlnumber->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($controlnumber->modified) ?></td>
        </tr>
    </table>
</div>
