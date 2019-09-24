<div class="row">
    <div class="col-md-12">
        <div class="page-header">
        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Parentsandguardians', 'action' => 'viewData', $idFamily, $family ], ['class' => 'btn btn-sm btn-default']) ?></p>
        <h3>Familia:&nbsp;<?= h($family) ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Fecha') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Número de factura') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Anulada') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Monto') ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?= $bill->date_and_time->format('d-m-Y') ?></td>
                        <td><?= h($bill->bill_number) ?></td>
                        <td>
                            <?php if ($bill->annulled == 1): ?>
                                Sí
                            <?php else: ?>
                                No
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($bill->amount_paid, 2, ",", ".") ?></td>
                        <td class="actions">
                            <?= $this->Html->link('Ver factura', ['action' => 'invoice', $bill->id, 1, $idFamily, 'index'], ['class' => 'btn btn-success']); ?>							
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