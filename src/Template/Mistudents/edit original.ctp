<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $mistudent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $mistudent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Mistudents'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="mistudents form large-9 medium-8 columns content">
    <?= $this->Form->create($mistudent) ?>
    <fieldset>
        <legend><?= __('Edit Mistudent') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('familia');
            echo $this->Form->input('idd');
            echo $this->Form->input('apellidos');
            echo $this->Form->input('nombres');
            echo $this->Form->input('sexo');
            echo $this->Form->input('nacimiento');
            echo $this->Form->input('direccion');
            echo $this->Form->input('grado');
            echo $this->Form->input('seccion');
            echo $this->Form->input('condicion');
            echo $this->Form->input('escolaridad');
            echo $this->Form->input('cuota');
            echo $this->Form->input('saldo');
            echo $this->Form->input('sep');
            echo $this->Form->input('oct');
            echo $this->Form->input('nov');
            echo $this->Form->input('dic');
            echo $this->Form->input('ene');
            echo $this->Form->input('feb');
            echo $this->Form->input('mar');
            echo $this->Form->input('abr');
            echo $this->Form->input('may');
            echo $this->Form->input('jun');
            echo $this->Form->input('jul');
            echo $this->Form->input('ago');
            echo $this->Form->input('mensualidad');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
