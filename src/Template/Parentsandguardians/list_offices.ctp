<div class="row">
    <div class="col-md-12">
        <div class="page-header">
			<h3>Padres y/o representantes que se dedican a: <?= $office ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Padre o representante']) ?></th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($officeP as $officePs): ?>
	                    <tr>
	                        <td><?= h($officePs->full_name) ?></td>
	                        <td class="actions">
	                            <?= $this->Html->link('Ver', ['action' => 'view', $officePs->id], ['class' => 'btn btn-sm btn-info']) ?>
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