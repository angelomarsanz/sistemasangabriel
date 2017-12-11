<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            Desea agregar una foto del alumno?&nbsp;&nbsp;
            <?= $this->Html->link('Sí', ['action' => 'editPhoto', $id], ['class' => 'btn btn-sm btn-info']) ?>
            <?= $this->Html->link('No', ['action' => 'index'], ['class' => 'btn btn-sm btn-info']) ?>
        </div>
    </div>
</div>