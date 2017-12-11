<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Miparentsandguardian'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="miparentsandguardians index large-9 medium-8 columns content">
    <h3><?= __('Miparentsandguardians') ?></h3>
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
                <th scope="col"><?= $this->Paginator->sort('family') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sex') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_of_identification') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identidy_card') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guardian') ?></th>
                <th scope="col"><?= $this->Paginator->sort('family_tie') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profession') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item') ?></th>
                <th scope="col"><?= $this->Paginator->sort('work_phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('workplace') ?></th>
                <th scope="col"><?= $this->Paginator->sort('professional_position') ?></th>
                <th scope="col"><?= $this->Paginator->sort('work_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cell_phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('landline') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('first_name_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_name_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('surname_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_surname_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_of_identification_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identidy_card_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('landline_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cell_phone_father') ?></th>
                <th scope="col"><?= $this->Paginator->sort('first_name_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_name_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('surname_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('second_surname_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_of_identification_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identidy_card_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('landline_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cell_phone_mother') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_of_identification_client') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identification_number_client') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fiscal_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('balance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creative_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('guardian_migration') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mi_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mi_children') ?></th>
                <th scope="col"><?= $this->Paginator->sort('new_guardian') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profile_photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profile_photo_dir') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($miparentsandguardians as $miparentsandguardian): ?>
            <tr>
                <td><?= $this->Number->format($miparentsandguardian->id) ?></td>
                <td><?= $this->Number->format($miparentsandguardian->user_id) ?></td>
                <td><?= h($miparentsandguardian->code_for_user) ?></td>
                <td><?= h($miparentsandguardian->first_name) ?></td>
                <td><?= h($miparentsandguardian->second_name) ?></td>
                <td><?= h($miparentsandguardian->surname) ?></td>
                <td><?= h($miparentsandguardian->second_surname) ?></td>
                <td><?= h($miparentsandguardian->family) ?></td>
                <td><?= h($miparentsandguardian->sex) ?></td>
                <td><?= h($miparentsandguardian->type_of_identification) ?></td>
                <td><?= h($miparentsandguardian->identidy_card) ?></td>
                <td><?= h($miparentsandguardian->guardian) ?></td>
                <td><?= h($miparentsandguardian->family_tie) ?></td>
                <td><?= h($miparentsandguardian->profession) ?></td>
                <td><?= h($miparentsandguardian->item) ?></td>
                <td><?= h($miparentsandguardian->work_phone) ?></td>
                <td><?= h($miparentsandguardian->workplace) ?></td>
                <td><?= h($miparentsandguardian->professional_position) ?></td>
                <td><?= h($miparentsandguardian->work_address) ?></td>
                <td><?= h($miparentsandguardian->cell_phone) ?></td>
                <td><?= h($miparentsandguardian->landline) ?></td>
                <td><?= h($miparentsandguardian->email) ?></td>
                <td><?= h($miparentsandguardian->address) ?></td>
                <td><?= h($miparentsandguardian->first_name_father) ?></td>
                <td><?= h($miparentsandguardian->second_name_father) ?></td>
                <td><?= h($miparentsandguardian->surname_father) ?></td>
                <td><?= h($miparentsandguardian->second_surname_father) ?></td>
                <td><?= h($miparentsandguardian->type_of_identification_father) ?></td>
                <td><?= h($miparentsandguardian->identidy_card_father) ?></td>
                <td><?= h($miparentsandguardian->address_father) ?></td>
                <td><?= h($miparentsandguardian->email_father) ?></td>
                <td><?= h($miparentsandguardian->landline_father) ?></td>
                <td><?= h($miparentsandguardian->cell_phone_father) ?></td>
                <td><?= h($miparentsandguardian->first_name_mother) ?></td>
                <td><?= h($miparentsandguardian->second_name_mother) ?></td>
                <td><?= h($miparentsandguardian->surname_mother) ?></td>
                <td><?= h($miparentsandguardian->second_surname_mother) ?></td>
                <td><?= h($miparentsandguardian->type_of_identification_mother) ?></td>
                <td><?= h($miparentsandguardian->identidy_card_mother) ?></td>
                <td><?= h($miparentsandguardian->address_mother) ?></td>
                <td><?= h($miparentsandguardian->email_mother) ?></td>
                <td><?= h($miparentsandguardian->landline_mother) ?></td>
                <td><?= h($miparentsandguardian->cell_phone_mother) ?></td>
                <td><?= h($miparentsandguardian->client) ?></td>
                <td><?= h($miparentsandguardian->type_of_identification_client) ?></td>
                <td><?= h($miparentsandguardian->identification_number_client) ?></td>
                <td><?= h($miparentsandguardian->fiscal_address) ?></td>
                <td><?= h($miparentsandguardian->tax_phone) ?></td>
                <td><?= $this->Number->format($miparentsandguardian->balance) ?></td>
                <td><?= h($miparentsandguardian->creative_user) ?></td>
                <td><?= h($miparentsandguardian->guardian_migration) ?></td>
                <td><?= h($miparentsandguardian->mi_id) ?></td>
                <td><?= $this->Number->format($miparentsandguardian->mi_children) ?></td>
                <td><?= h($miparentsandguardian->new_guardian) ?></td>
                <td><?= h($miparentsandguardian->profile_photo) ?></td>
                <td><?= h($miparentsandguardian->profile_photo_dir) ?></td>
                <td><?= h($miparentsandguardian->created) ?></td>
                <td><?= h($miparentsandguardian->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $miparentsandguardian->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $miparentsandguardian->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $miparentsandguardian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miparentsandguardian->id)]) ?>
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
