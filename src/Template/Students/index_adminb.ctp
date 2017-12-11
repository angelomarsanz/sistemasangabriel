<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <p><?= $this->Html->link(__('Registrar otro alumno'), ['action' => 'addAdminb', $idFamilyP], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Alumno']) ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= h($student->full_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'viewAdminb', $student->id, $idFamilyP], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Modificar', ['action' => 'editAdminb', $student->id, $idFamilyP], ['class' => 'btn btn-sm btn-info']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Anterior') ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next('Siguiente >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>