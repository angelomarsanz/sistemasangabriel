<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Miparentsandguardians'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="miparentsandguardians form large-9 medium-8 columns content">
    <?= $this->Form->create($miparentsandguardian) ?>
    <fieldset>
        <legend><?= __('Add Miparentsandguardian') ?></legend>
        <?php
            echo $this->Form->input('user_id');
            echo $this->Form->input('code_for_user');
            echo $this->Form->input('first_name');
            echo $this->Form->input('second_name');
            echo $this->Form->input('surname');
            echo $this->Form->input('second_surname');
            echo $this->Form->input('family');
            echo $this->Form->input('sex');
            echo $this->Form->input('type_of_identification');
            echo $this->Form->input('identidy_card');
            echo $this->Form->input('guardian');
            echo $this->Form->input('family_tie');
            echo $this->Form->input('profession');
            echo $this->Form->input('item');
            echo $this->Form->input('work_phone');
            echo $this->Form->input('workplace');
            echo $this->Form->input('professional_position');
            echo $this->Form->input('work_address');
            echo $this->Form->input('cell_phone');
            echo $this->Form->input('landline');
            echo $this->Form->input('email');
            echo $this->Form->input('address');
            echo $this->Form->input('first_name_father');
            echo $this->Form->input('second_name_father');
            echo $this->Form->input('surname_father');
            echo $this->Form->input('second_surname_father');
            echo $this->Form->input('type_of_identification_father');
            echo $this->Form->input('identidy_card_father');
            echo $this->Form->input('address_father');
            echo $this->Form->input('email_father');
            echo $this->Form->input('landline_father');
            echo $this->Form->input('cell_phone_father');
            echo $this->Form->input('first_name_mother');
            echo $this->Form->input('second_name_mother');
            echo $this->Form->input('surname_mother');
            echo $this->Form->input('second_surname_mother');
            echo $this->Form->input('type_of_identification_mother');
            echo $this->Form->input('identidy_card_mother');
            echo $this->Form->input('address_mother');
            echo $this->Form->input('email_mother');
            echo $this->Form->input('landline_mother');
            echo $this->Form->input('cell_phone_mother');
            echo $this->Form->input('client');
            echo $this->Form->input('type_of_identification_client');
            echo $this->Form->input('identification_number_client');
            echo $this->Form->input('fiscal_address');
            echo $this->Form->input('tax_phone');
            echo $this->Form->input('balance');
            echo $this->Form->input('creative_user');
            echo $this->Form->input('guardian_migration');
            echo $this->Form->input('mi_id');
            echo $this->Form->input('mi_children');
            echo $this->Form->input('new_guardian');
            echo $this->Form->input('profile_photo');
            echo $this->Form->input('profile_photo_dir');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
