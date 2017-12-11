<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <p><?= $this->Html->link(__('Nuevo usuario'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('username', ['Usuario']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->full_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $user->id], ['class' => 'btn btn-sm btn-info']) ?>
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