<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Schools'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="schools form large-9 medium-8 columns content">
    <?= $this->Form->create($school, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Agregar colegio') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('rif');
            echo $this->Form->input('fiscal_address');
            echo $this->Form->input('tax_phone');
            echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil:'));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
