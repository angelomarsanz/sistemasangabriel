<div class="page-header">
    <p><?= $this->Html->link(__('Volver'), ['controller' => 'Parentsandguardians', 'action' => 'consultFamily'], ['class' => 'btn btn-sm btn-default']) ?></p>
    <h4>Familia: <?= $family ?></h4>
</div>
<?= $this->Html->link('Ver datos de la familia', ['action' => 'view', $idFamily], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Ver alumnos', ['controller' => 'Students', 'action' => 'indexConsult', $idFamily, $family], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Ver facturas', ['controller' => 'Bills' , 'action' => 'index', $idFamily, $family], ['class' => 'btn btn-success']); ?>
<br />
<br />