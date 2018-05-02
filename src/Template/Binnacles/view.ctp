<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Binnacle'), ['action' => 'edit', $binnacle->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Binnacle'), ['action' => 'delete', $binnacle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binnacle->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Binnacles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Binnacle'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="binnacles view large-9 medium-8 columns content">
    <h3><?= h($binnacle->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type Class') ?></th>
            <td><?= h($binnacle->type_class) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Class Name') ?></th>
            <td><?= h($binnacle->class_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Method Name') ?></th>
            <td><?= h($binnacle->method_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column1') ?></th>
            <td><?= h($binnacle->extra_column1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column2') ?></th>
            <td><?= h($binnacle->extra_column2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column3') ?></th>
            <td><?= h($binnacle->extra_column3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column4') ?></th>
            <td><?= h($binnacle->extra_column4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column5') ?></th>
            <td><?= h($binnacle->extra_column5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column6') ?></th>
            <td><?= h($binnacle->extra_column6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column7') ?></th>
            <td><?= h($binnacle->extra_column7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column8') ?></th>
            <td><?= h($binnacle->extra_column8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column9') ?></th>
            <td><?= h($binnacle->extra_column9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column10') ?></th>
            <td><?= h($binnacle->extra_column10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Status') ?></th>
            <td><?= h($binnacle->registration_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reason Status') ?></th>
            <td><?= h($binnacle->reason_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($binnacle->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($binnacle->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Status') ?></th>
            <td><?= h($binnacle->date_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($binnacle->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($binnacle->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Novelty') ?></h4>
        <?= $this->Text->autoParagraph(h($binnacle->novelty)); ?>
    </div>
</div>
