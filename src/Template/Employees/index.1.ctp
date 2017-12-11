<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Positions'), ['controller' => 'Positions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Position'), ['controller' => 'Positions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employeepayments'), ['controller' => 'Employeepayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employeepayment'), ['controller' => 'Employeepayments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Studentactivities'), ['controller' => 'Studentactivities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Studentactivity'), ['controller' => 'Studentactivities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Teachingareas'), ['controller' => 'Teachingareas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Teachingarea'), ['controller' => 'Teachingareas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employees index large-9 medium-8 columns content">
    <h3><?= __('Employees') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code_for_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('surname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_surname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sex') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nationality') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_of_identification') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identity_card') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profile_photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profile_photo_dir') ?></th>
                <th scope="col"><?= $this->Paginator->sort('birthdate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cell_phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('landline') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('degree_instruction') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_of_admission') ?></th>
                <th scope="col"><?= $this->Paginator->sort('position_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('working_agreement') ?></th>
                <th scope="col"><?= $this->Paginator->sort('daily_hours') ?></th>
                <th scope="col"><?= $this->Paginator->sort('weekly_hours') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hours_month') ?></th>
                <th scope="col"><?= $this->Paginator->sort('maximum_number_sections') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_assigned_sections') ?></th>
                <th scope="col"><?= $this->Paginator->sort('percentage_imposed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $this->Number->format($employee->id) ?></td>
                <td><?= $employee->has('user') ? $this->Html->link($employee->user->id, ['controller' => 'Users', 'action' => 'view', $employee->user->id]) : '' ?></td>
                <td><?= h($employee->code_for_user) ?></td>
                <td><?= h($employee->first_name) ?></td>
                <td><?= h($employee->second_name) ?></td>
                <td><?= h($employee->surname) ?></td>
                <td><?= h($employee->second_surname) ?></td>
                <td><?= h($employee->sex) ?></td>
                <td><?= h($employee->nationality) ?></td>
                <td><?= h($employee->type_of_identification) ?></td>
                <td><?= h($employee->identity_card) ?></td>
                <td><?= h($employee->profile_photo) ?></td>
                <td><?= h($employee->profile_photo_dir) ?></td>
                <td><?= h($employee->birthdate) ?></td>
                <td><?= h($employee->cell_phone) ?></td>
                <td><?= h($employee->landline) ?></td>
                <td><?= h($employee->email) ?></td>
                <td><?= h($employee->address) ?></td>
                <td><?= h($employee->degree_instruction) ?></td>
                <td><?= h($employee->date_of_admission) ?></td>
                <td><?= $employee->has('position') ? $this->Html->link($employee->position->id, ['controller' => 'Positions', 'action' => 'view', $employee->position->id]) : '' ?></td>
                <td><?= h($employee->working_agreement) ?></td>
                <td><?= $this->Number->format($employee->daily_hours) ?></td>
                <td><?= $this->Number->format($employee->weekly_hours) ?></td>
                <td><?= $this->Number->format($employee->hours_month) ?></td>
                <td><?= $this->Number->format($employee->maximum_number_sections) ?></td>
                <td><?= $this->Number->format($employee->number_assigned_sections) ?></td>
                <td><?= $this->Number->format($employee->percentage_imposed) ?></td>
                <td><?= h($employee->created) ?></td>
                <td><?= h($employee->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employee->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employee->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
