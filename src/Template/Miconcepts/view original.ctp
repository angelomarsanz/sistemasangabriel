<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Miconcept'), ['action' => 'edit', $miconcept->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Miconcept'), ['action' => 'delete', $miconcept->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miconcept->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Miconcepts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Miconcept'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="miconcepts view large-9 medium-8 columns content">
    <h3><?= h($miconcept->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($miconcept->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= h($miconcept->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($miconcept->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Idd') ?></th>
            <td><?= $this->Number->format($miconcept->idd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo Art') ?></th>
            <td><?= $this->Number->format($miconcept->codigo_art) ?></td>
        </tr>
    </table>
</div>
