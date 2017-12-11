<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bill'), ['action' => 'edit', $bill->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bill'), ['action' => 'delete', $bill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bill->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bills'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bill'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bills view large-9 medium-8 columns content">
    <h3><?= h($bill->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bill Number') ?></th>
            <td><?= h($bill->bill_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identification') ?></th>
            <td><?= h($bill->identification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= h($bill->client) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Phone') ?></th>
            <td><?= h($bill->tax_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fiscal Address') ?></th>
            <td><?= h($bill->fiscal_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bill->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parentsandguardian Id') ?></th>
            <td><?= $this->Number->format($bill->parentsandguardian_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($bill->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($bill->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Paid') ?></th>
            <td><?= $this->Number->format($bill->amount_paid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date And Time') ?></th>
            <td><?= h($bill->date_and_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($bill->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($bill->modified) ?></td>
        </tr>
    </table>
</div>
