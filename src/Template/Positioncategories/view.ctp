<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Positioncategory'), ['action' => 'edit', $positioncategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Positioncategory'), ['action' => 'delete', $positioncategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $positioncategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Positioncategories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Positioncategory'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="positioncategories view large-9 medium-8 columns content">
    <h3><?= h($positioncategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description Category') ?></th>
            <td><?= h($positioncategory->description_category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column1') ?></th>
            <td><?= h($positioncategory->extra_column1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column2') ?></th>
            <td><?= h($positioncategory->extra_column2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column3') ?></th>
            <td><?= h($positioncategory->extra_column3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column4') ?></th>
            <td><?= h($positioncategory->extra_column4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column5') ?></th>
            <td><?= h($positioncategory->extra_column5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column6') ?></th>
            <td><?= h($positioncategory->extra_column6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column7') ?></th>
            <td><?= h($positioncategory->extra_column7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column8') ?></th>
            <td><?= h($positioncategory->extra_column8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column9') ?></th>
            <td><?= h($positioncategory->extra_column9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column10') ?></th>
            <td><?= h($positioncategory->extra_column10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Status') ?></th>
            <td><?= h($positioncategory->registration_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reason Status') ?></th>
            <td><?= h($positioncategory->reason_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($positioncategory->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($positioncategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Status') ?></th>
            <td><?= h($positioncategory->date_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($positioncategory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($positioncategory->modified) ?></td>
        </tr>
    </table>
</div>
