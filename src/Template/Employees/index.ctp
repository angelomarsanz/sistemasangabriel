<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Nuevo empleado'), ['controller' => 'Employees', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('classification', ['Clasificación']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('position', ['Puesto de trabajo']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                         <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= h($employee->classification) ?></td>
                        <td><?= h($employee->position->position) ?></td>
                        <td><?= h($employee->full_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $employee->id], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Modificar', ['action' => 'edit', $employee->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $employee->id], ['confirm' => 'Eliminar este empleado?', 'class' => 'btn btn-sm btn-danger']) ?>                        </td>
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