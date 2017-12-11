<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Pago de Inscripción y mensualidades</h3>
            <h4><?= __('Saldo factura Bs. ' . number_format($balance, 2, ",", ".")) ?></h4>
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
                            <?= $this->Html->link('Facturar', ['controller' => 'Studenttransactions', 'action' => 'installmentsPayable', $student->parentsandguardian_id, $student->id, $student->full_name, $description, $balance], ['class' => 'btn btn-sm btn-info']) ?>
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