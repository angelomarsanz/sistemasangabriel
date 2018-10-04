<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Discount'), ['action' => 'edit', $discount->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Discount'), ['action' => 'delete', $discount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discount->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Discounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="discounts view large-9 medium-8 columns content">
    <h3><?= h($discount->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description Discount') ?></th>
            <td><?= h($discount->description_discount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Mode') ?></th>
            <td><?= h($discount->discount_mode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Whole Rounding') ?></th>
            <td><?= h($discount->whole_rounding) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column1') ?></th>
            <td><?= h($discount->extra_column1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column2') ?></th>
            <td><?= h($discount->extra_column2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column3') ?></th>
            <td><?= h($discount->extra_column3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column4') ?></th>
            <td><?= h($discount->extra_column4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column5') ?></th>
            <td><?= h($discount->extra_column5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column6') ?></th>
            <td><?= h($discount->extra_column6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column7') ?></th>
            <td><?= h($discount->extra_column7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column8') ?></th>
            <td><?= h($discount->extra_column8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column9') ?></th>
            <td><?= h($discount->extra_column9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extra Column10') ?></th>
            <td><?= h($discount->extra_column10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Status') ?></th>
            <td><?= h($discount->registration_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reason Status') ?></th>
            <td><?= h($discount->reason_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($discount->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($discount->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Amount') ?></th>
            <td><?= $this->Number->format($discount->discount_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date From') ?></th>
            <td><?= h($discount->date_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Until') ?></th>
            <td><?= h($discount->date_until) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Status') ?></th>
            <td><?= h($discount->date_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($discount->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($discount->modified) ?></td>
        </tr>
    </table>
</div>
