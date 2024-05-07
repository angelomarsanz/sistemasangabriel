<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Salesbook'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="salesbooks index large-9 medium-8 columns content">
    <h3><?= __('Salesbooks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha', 'Fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_documento', 'Tipo de Documento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cedula_rif', 'Cédula o RIF') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_razon_social', 'Nombre o Razón Social') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero_control', 'Número de Control') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero_factura', 'Número de Factura') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nota_debito', 'Nota de débito') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nota_credito', 'Nota de cŕedito') ?></th>
                <th scope="col"><?= $this->Paginator->sort('factura_afectada', 'Factura Afectada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_ventas_mas_impuestos', 'Total Ventas más Impuestos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descuento_recargo', 'Descuento/Recargo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ventas_exoneradas', 'Ventas Exoneradas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('base', 'Base') ?></th>
                <th scope="col"><?= $this->Paginator->sort('aliquota', 'Alicuota') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iva', 'IVA') ?></th>
                <th scope="col"><?= $this->Paginator->sort('igft', 'IGFT') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tasa_cambio', 'Tasa de Cambio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto_divisas', 'Monto Divisas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto_bolivares', 'Monto Bolívares') ?></th>
                <th scope="col"><?= $this->Paginator->sort('right_bill_number', 'right_bill_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('previous_control_number', 'previous_control_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id_documento', 'ID del documento') ?></th>
                th scope="col" class="actions"><?= __('Actions') ?></th>
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
                <td><?= $this->Number->format($salesbook->monto_divisas) ?></td>
                <td><?= $this->Number->format($salesbook->monto_bolivares) ?></td>
                <td><?= h($salesbook->right_bill_number) ?></td>
                <td><?= h($salesbook->previous_control_number) ?></td>
                <td><?= h($salesbook->id_documento) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $salesbook->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salesbook->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salesbook->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesbook->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>