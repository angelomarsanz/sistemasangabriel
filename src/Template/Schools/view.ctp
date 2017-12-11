<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit School'), ['action' => 'edit', $school->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete School'), ['action' => 'delete', $school->id], ['confirm' => __('Are you sure you want to delete # {0}?', $school->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Schools'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New School'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="schools view large-9 medium-8 columns content">
    <h3><?= h($school->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($school->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rif') ?></th>
            <td><?= h($school->rif) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fiscal Address') ?></th>
            <td><?= h($school->fiscal_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Phone') ?></th>
            <td><?= h($school->tax_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profile Photo') ?></th>
            <td><?= h($school->profile_photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profile Photo Dir') ?></th>
            <td><?= h($school->profile_photo_dir) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($school->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($school->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($school->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($school->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted Record') ?></th>
            <td><?= $school->deleted_record ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
