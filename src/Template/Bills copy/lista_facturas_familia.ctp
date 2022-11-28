<div class="row">
    <div class="col-md-12">
        <div class="page-header">
        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Bills', 'action' => 'notaContable'], ['class' => 'btn btn-sm btn-default']) ?></p>
        <h3>Facturas fiscales de la familia:&nbsp;<?= h($familia) ?></h3>
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
                    <?php foreach ($facturasFamilia as $factura): ?>
                    <tr>
                        <td><?= $factura->date_and_time->format('d-m-Y') ?></td>
                        <td><?= h($factura->bill_number) ?></td>
                        <td>
                            <?php if ($factura->annulled == 1): ?>
                                Sí
                            <?php else: ?>
                                No
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
                        <td class="actions">
							<?php if ($factura->annulled == 0): ?>
                            <?= $this->Html->link('Crear nota contable', 
								['controller' => 'Bills', 'action' => 'conceptosNotaContable', 'Bills', 'listaFacturasFamilia', $factura->id, $idFamilia, $familia], 
								['class' => 'btn btn-success']); ?>
							<?php endif; ?>
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