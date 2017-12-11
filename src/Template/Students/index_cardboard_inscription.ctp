<div class="row">
    <div class="col-md-12">
        <div class="page-header">
        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Bills', 'action' => 'printInvoice', $billNumber, $idParentsandguardian], ['class' => 'btn btn-sm btn-default']) ?></li>
        <h2>Familia:&nbsp;<?= h($family) ?></h2>
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
                            <?php echo $this->Html->link('Imprimir cartón de cuotas', ['action' => 'cardboardpdf', $student->id, '_ext' => 'pdf'], ['class' => 'btn btn-sm btn-info']); ?>
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