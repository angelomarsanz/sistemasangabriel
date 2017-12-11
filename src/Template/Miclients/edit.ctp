<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $miclient->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $miclient->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Miclients'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="miclients form large-9 medium-8 columns content">
    <?= $this->Form->create($miclient) ?>
    <fieldset>
        <legend><?= __('Edit Miclient') ?></legend>
        <?php
            echo $this->Form->input('clave_familia');
            echo $this->Form->input('familia');
            echo $this->Form->input('cimadre');
            echo $this->Form->input('apmadre');
            echo $this->Form->input('nomadre');
            echo $this->Form->input('dirmadre');
            echo $this->Form->input('emailmadre');
            echo $this->Form->input('telfmadre');
            echo $this->Form->input('celmadre');
            echo $this->Form->input('cipadre');
            echo $this->Form->input('appadre');
            echo $this->Form->input('nopadre');
            echo $this->Form->input('dirpadre');
            echo $this->Form->input('emailpadre');
            echo $this->Form->input('telfpadre');
            echo $this->Form->input('celpadre');
            echo $this->Form->input('nombre');
            echo $this->Form->input('ci');
            echo $this->Form->input('direccion');
            echo $this->Form->input('telefono');
            echo $this->Form->input('hijos');
            echo $this->Form->input('deuda');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
