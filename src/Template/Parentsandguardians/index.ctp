<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <p><?= $this->Html->link(__('Nuevo padre o representante'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Padre o Representante') ?></th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parentsandguardians as $parentsandguardian): ?>
                    <tr>
                        <td><?= h($parentsandguardian->full_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver', ['action' => 'view', $parentsandguardian->id], ['class' => 'btn btn-sm btn-info']) ?>
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