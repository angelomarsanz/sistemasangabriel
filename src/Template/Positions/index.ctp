<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Nuevo puesto de trabajo'), ['controller' => 'positions', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('position', ['Puesto de trabajo']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('short_name', ['Nombre corto']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('type_of_salary', ['Tipo de sueldo']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('minimum_wage', ['Sueldo básico']) ?></th>

                        <th scope="col" class="actions" style="width: 35%;"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($positions as $position): ?>
                    <tr>
                        <td><?= h($position->position) ?></td>
                        <td><?= h($position->short_name) ?></td>
                        <td><?= h($position->type_of_salary) ?></td>
                        <td><?= h(number_format($position->minimum_wage, 2, ",", ".")) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $position->id], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Editar', ['action' => 'edit', $position->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $position->id], ['confirm' => 'Eliminar?', 'class' => 'btn btn-sm btn-danger']) ?>
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