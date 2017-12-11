<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Nueva sección'), ['controller' => 'sections', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
    	</div>
    	<div class="table-responsive">
            <table class="table table-striped table-hover">  
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Sección') ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= h($section->full_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $section->id], ['class' => 'btn btn-sm btn-info']) ?>
                            <?= $this->Html->link('Editar', ['action' => 'edit', $section->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $section->id], ['confirm' => 'Eliminar?', 'class' => 'btn btn-sm btn-danger']) ?>
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
</div