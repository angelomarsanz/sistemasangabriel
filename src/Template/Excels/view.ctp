<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Excel'), ['action' => 'edit', $excel->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Excel'), ['action' => 'delete', $excel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $excel->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Excels'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Excel'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="excels view large-9 medium-8 columns content">
    <h3><?= h($excel->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Report') ?></th>
            <td><?= h($excel->report) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start-end') ?></th>
            <td><?= h($excel->start-end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col1') ?></th>
            <td><?= h($excel->col1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col2') ?></th>
            <td><?= h($excel->col2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col3') ?></th>
            <td><?= h($excel->col3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col4') ?></th>
            <td><?= h($excel->col4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col5') ?></th>
            <td><?= h($excel->col5) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col6') ?></th>
            <td><?= h($excel->col6) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col7') ?></th>
            <td><?= h($excel->col7) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col8') ?></th>
            <td><?= h($excel->col8) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col9') ?></th>
            <td><?= h($excel->col9) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col10') ?></th>
            <td><?= h($excel->col10) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col11') ?></th>
            <td><?= h($excel->col11) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col12') ?></th>
            <td><?= h($excel->col12) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col13') ?></th>
            <td><?= h($excel->col13) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col14') ?></th>
            <td><?= h($excel->col14) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col15') ?></th>
            <td><?= h($excel->col15) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col16') ?></th>
            <td><?= h($excel->col16) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col17') ?></th>
            <td><?= h($excel->col17) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col18') ?></th>
            <td><?= h($excel->col18) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col19') ?></th>
            <td><?= h($excel->col19) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Col20') ?></th>
            <td><?= h($excel->col20) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Status') ?></th>
            <td><?= h($excel->registration_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reason Status') ?></th>
            <td><?= h($excel->reason_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($excel->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($excel->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= $this->Number->format($excel->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Status') ?></th>
            <td><?= h($excel->date_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($excel->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($excel->modified) ?></td>
        </tr>
    </table>
</div>
