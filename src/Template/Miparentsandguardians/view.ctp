<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Miparentsandguardian'), ['action' => 'edit', $miparentsandguardian->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Miparentsandguardian'), ['action' => 'delete', $miparentsandguardian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $miparentsandguardian->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Miparentsandguardians'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Miparentsandguardian'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="miparentsandguardians view large-9 medium-8 columns content">
    <h3><?= h($miparentsandguardian->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Code For User') ?></th>
            <td><?= h($miparentsandguardian->code_for_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($miparentsandguardian->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Name') ?></th>
            <td><?= h($miparentsandguardian->second_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Surname') ?></th>
            <td><?= h($miparentsandguardian->surname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Surname') ?></th>
            <td><?= h($miparentsandguardian->second_surname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Family') ?></th>
            <td><?= h($miparentsandguardian->family) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sex') ?></th>
            <td><?= h($miparentsandguardian->sex) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Of Identification') ?></th>
            <td><?= h($miparentsandguardian->type_of_identification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identidy Card') ?></th>
            <td><?= h($miparentsandguardian->identidy_card) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Family Tie') ?></th>
            <td><?= h($miparentsandguardian->family_tie) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profession') ?></th>
            <td><?= h($miparentsandguardian->profession) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= h($miparentsandguardian->item) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Work Phone') ?></th>
            <td><?= h($miparentsandguardian->work_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Workplace') ?></th>
            <td><?= h($miparentsandguardian->workplace) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Professional Position') ?></th>
            <td><?= h($miparentsandguardian->professional_position) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Work Address') ?></th>
            <td><?= h($miparentsandguardian->work_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Phone') ?></th>
            <td><?= h($miparentsandguardian->cell_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Landline') ?></th>
            <td><?= h($miparentsandguardian->landline) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($miparentsandguardian->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($miparentsandguardian->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name Father') ?></th>
            <td><?= h($miparentsandguardian->first_name_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Name Father') ?></th>
            <td><?= h($miparentsandguardian->second_name_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Surname Father') ?></th>
            <td><?= h($miparentsandguardian->surname_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Surname Father') ?></th>
            <td><?= h($miparentsandguardian->second_surname_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Of Identification Father') ?></th>
            <td><?= h($miparentsandguardian->type_of_identification_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identidy Card Father') ?></th>
            <td><?= h($miparentsandguardian->identidy_card_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Father') ?></th>
            <td><?= h($miparentsandguardian->address_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email Father') ?></th>
            <td><?= h($miparentsandguardian->email_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Landline Father') ?></th>
            <td><?= h($miparentsandguardian->landline_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Phone Father') ?></th>
            <td><?= h($miparentsandguardian->cell_phone_father) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name Mother') ?></th>
            <td><?= h($miparentsandguardian->first_name_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Name Mother') ?></th>
            <td><?= h($miparentsandguardian->second_name_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Surname Mother') ?></th>
            <td><?= h($miparentsandguardian->surname_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Second Surname Mother') ?></th>
            <td><?= h($miparentsandguardian->second_surname_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Of Identification Mother') ?></th>
            <td><?= h($miparentsandguardian->type_of_identification_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identidy Card Mother') ?></th>
            <td><?= h($miparentsandguardian->identidy_card_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Mother') ?></th>
            <td><?= h($miparentsandguardian->address_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email Mother') ?></th>
            <td><?= h($miparentsandguardian->email_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Landline Mother') ?></th>
            <td><?= h($miparentsandguardian->landline_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Phone Mother') ?></th>
            <td><?= h($miparentsandguardian->cell_phone_mother) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= h($miparentsandguardian->client) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Of Identification Client') ?></th>
            <td><?= h($miparentsandguardian->type_of_identification_client) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identification Number Client') ?></th>
            <td><?= h($miparentsandguardian->identification_number_client) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fiscal Address') ?></th>
            <td><?= h($miparentsandguardian->fiscal_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Phone') ?></th>
            <td><?= h($miparentsandguardian->tax_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creative User') ?></th>
            <td><?= h($miparentsandguardian->creative_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mi Id') ?></th>
            <td><?= h($miparentsandguardian->mi_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profile Photo') ?></th>
            <td><?= h($miparentsandguardian->profile_photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profile Photo Dir') ?></th>
            <td><?= h($miparentsandguardian->profile_photo_dir) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($miparentsandguardian->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($miparentsandguardian->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Balance') ?></th>
            <td><?= $this->Number->format($miparentsandguardian->balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mi Children') ?></th>
            <td><?= $this->Number->format($miparentsandguardian->mi_children) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($miparentsandguardian->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($miparentsandguardian->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guardian') ?></th>
            <td><?= $miparentsandguardian->guardian ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Guardian Migration') ?></th>
            <td><?= $miparentsandguardian->guardian_migration ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New Guardian') ?></th>
            <td><?= $miparentsandguardian->new_guardian ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
