<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            Desea agregar una foto de perfil?&nbsp;&nbsp;
            <?= $this->Html->link('Sí', ['action' => 'editPhoto', $id], ['class' => 'btn btn-sm btn-info']) ?>
            <?= $this->Html->link('No', ['controller' => 'Students', 'action' => 'index'], ['class' => 'btn btn-sm btn-info']) ?>
        </div>
    </div>
</div>