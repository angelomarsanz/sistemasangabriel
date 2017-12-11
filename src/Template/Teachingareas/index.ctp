<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Nueva materia'), ['controller' => 'teachingareas', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
            <h2>Lista de materias</h2>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('description_teaching_area', ['Área de enseñanza']) ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachingareas as $teachingarea): ?>
                    <tr>
                        <td><?= h($teachingarea->description_teaching_area) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $teachingarea->id], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Editar', ['action' => 'edit', $teachingarea->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $teachingarea->id], ['confirm' => 'Eliminar?', 'class' => 'btn btn-sm btn-danger']) ?>
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