<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            Desea registrar otra transferencia?&nbsp;&nbsp;
            <?= $this->Html->link('Sí', ['action' => 'add', $idParentsAndGuardian], ['class' => 'btn btn-sm btn-info']) ?>
            <?= $this->Html->link('No', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian], ['class' => 'btn btn-sm btn-info']) ?>
        </div>
    </div>
</div>