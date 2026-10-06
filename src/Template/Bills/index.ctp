<?php
/**
 * Vista del listado de comprobantes y facturas por familia (Bills/index).
 *
 * Muestra el historial completo de documentos emitidos a una familia o representante:
 * fecha de emisión, número de documento, número de control fiscal o interno, tipo de documento
 * (Factura, Pedido, Recibo de anticipo, Recibo de Consejo Educativo, notas contables, etc.),
 * indicador de anulación, monto de descuento/recargo en dólares, y montos totales en divisas
 * ($) y moneda nacional (Bs.), aplicando el tratamiento particular correspondiente según la
 * naturaleza del documento (incluyendo la lógica invertida de divisa en Recibos de Consejo Educativo).
 */
?>
<div id='indexBills'></div>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Parentsandguardians', 'action' => 'viewData', $idFamily, $family ], ['class' => 'btn btn-sm btn-default']) ?></p>
        <h3 id='familia'>Familia:&nbsp;<?= h($family) ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('date_and_time', 'Fecha') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('bill_number', 'Nro. documento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('control_number', 'Nro. Control') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('tipo_documento', 'Tipo de Documento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('annulled', 'Anulada') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('amount_paid', 'Monto $') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('amount', 'Descuento/Recargo $') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('amount_paid', 'Monto Bs.') ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bills as $bill): ?>
                    <?php
                        $esConsejoEducativo = (stripos($bill->tipo_documento, 'Consejo Educativo') !== false);

                        if ($esConsejoEducativo) {
                            $montoDolar = $bill->amount_paid;
                            $montoBs = round($bill->amount_paid * $bill->tasa_cambio, 2);
                        } else {
                            $montoDolar = ($bill->tasa_cambio > 0) ? round($bill->amount_paid / $bill->tasa_cambio, 2) : 0;
                            $montoBs = $bill->amount_paid;
                        }

                        $descuentoRecargoDolar = ($bill->tasa_cambio > 0 && $bill->amount != 0) ? round($bill->amount / $bill->tasa_cambio, 2) : 0;
                    ?>
                    <tr>
                        <td><?= $bill->date_and_time ? $bill->date_and_time->format('d-m-Y') : '' ?></td>
                        <td><?= h($bill->bill_number) ?></td>
                        <td><?= h($bill->control_number) ?></td>
                        <td><?= h($bill->tipo_documento) ?></td>
                        <td>
                            <?php if ($bill->annulled == 1): ?>
                                Sí
                            <?php else: ?>
                                No
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($montoDolar, 2, ",", ".") ?></td>
                        <td><?= number_format($descuentoRecargoDolar, 2, ",", ".") ?></td>
                        <td><?= number_format($montoBs, 2, ",", ".") ?></td>
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
