<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <p><?= $this->Html->link(__('Nuevo alumno'), ['action' => 'addAdmin'], ['class' => 'btn btn-sm btn-default']) ?></p>
            <p><?= $this->Html->link('Pagar Matrícula', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Facturar']) ?></p>
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
                            <?= $this->Html->link('Ver', ['action' => 'view', $student->id], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Editar', ['controller' => 'Users', 'action' => 'editAdmin', $student->user_id, $idFamily], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $student->id], ['confirm' => 'Eliminar alumno ?', 'class' => 'btn btn-sm btn-danger']) ?>
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