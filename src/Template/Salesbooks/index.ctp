<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Nuevo registro'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div name="excepciones" id="excepciones" class="container" style="font-size: 12px; line-height: 14px;">
    <div class="row">
        <div class="col-md-12">					
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center;"><?= $this->Paginator->sort('id', 'Id') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('fecha', 'Fecha') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('tipo_documento', 'Tipo de Documento') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('cedula_rif', 'Cédula o RIF') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nombre_razon_social', 'Nombre o Razón Social') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('numero_control', 'Número de Control') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('numero_factura', 'Número de Factura') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nota_debito', 'Nota de débito') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nota_credito', 'Nota de cŕedito') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('factura_afectada', 'Factura Afectada') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('total_ventas_mas_impuestos', 'Total Ventas más Impuestos') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('descuento_recargo', 'Descuento/Recargo') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('ventas_exoneradas', 'Ventas Exoneradas') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('base', 'Base') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('aliquota', 'Alicuota') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('iva', 'IVA') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('igft', 'IGFT') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('tasa_cambio', 'Tasa de Cambio') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('efectivo_bolivares', 'Efectivo Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('transferencia_bolivares', 'Transferencia Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('pos_bolivares', 'POS Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('deposito_bolivares', 'Depósito Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('efectivo_dolares', 'Efectivo Dólares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('efectivo_euros', 'Efectivo Euros') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('zelle', 'Zelle') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('euros', 'Euros') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('right_bill_number', 'Right Bill Number') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('previous_control_number', 'Previous Control Number') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('id_documento', 'ID del documento') ?></th>
                        <th style="text-align: center;"></th>
                        <th style="text-align: center;"></th>
                        <th style="text-align: center;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salesbooks as $salesbook): ?>
                    <tr>
                        <td><?= $this->Number->format($salesbook->id) ?></td>
                        <td><?= h($salesbook->fecha) ?></td>
                        <td><?= h($salesbook->tipo_documento) ?></td>
                        <td><?= h($salesbook->cedula_rif) ?></td>
                        <td><?= h($salesbook->nombre_razon_social) ?></td>
                        <td><?= h($salesbook->numero_control) ?></td>
                        <td><?= h($salesbook->numero_factura) ?></td>
                        <td><?= h($salesbook->nota_debito) ?></td>
                        <td><?= h($salesbook->nota_credito) ?></td>
                        <td><?= h($salesbook->factura_afectada) ?></td>
                        <td><?= $this->Number->format($salesbook->total_ventas_mas_impuestos) ?></td>
                        <td><?= $this->Number->format($salesbook->descuento_recargo) ?></td>
                        <td><?= $this->Number->format($salesbook->ventas_exoneradas) ?></td>
                        <td><?= h($salesbook->base) ?></td>
                        <td><?= h($salesbook->aliquota)?></td>
                        <td><?= $this->Number->format($salesbook->iva) ?></td>
                        <td><?= $this->Number->format($salesbook->igft) ?></td>
                        <td><?= $this->Number->format($salesbook->tasa_cambio) ?></td>
                        <td><?= $this->Number->format($salesbook->efectivo_bolivares) ?></td>
                        <td><?= $this->Number->format($salesbook->transferencia_bolivares) ?></td>
                        <td><?= $this->Number->format($salesbook->pos_bolivares) ?></td>
                        <td><?= $this->Number->format($salesbook->deposito_bolivares) ?></td>
                        <td><?= $this->Number->format($salesbook->efectivo_dolares) ?></td>
                        <td><?= $this->Number->format($salesbook->efectivo_euros) ?></td>
                        <td><?= $this->Number->format($salesbook->zelle) ?></td>
                        <td><?= $this->Number->format($salesbook->euros) ?></td>
                        <td><?= h($salesbook->right_bill_number) ?></td>
                        <td><?= h($salesbook->previous_control_number) ?></td>
                        <td><?= h($salesbook->id_documento) ?></td>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $salesbook->id]) ?>
                        </td>
                        <td>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $salesbook->id]) ?>
                        </td>
                        <td>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $salesbook->id], ['confirm' => __('Está seguro de que desea eliminar el registro con el ID # {0}?', $salesbook->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>