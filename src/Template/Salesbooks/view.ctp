<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $salesbook->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $salesbook->id], ['confirm' => __('Está usted seguro que desea eliminar el registro con el ID # {0}?', $salesbook->id)]) ?> </li>
        <li><?= $this->Html->link(__('Listado de registros del libro de ventas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nuevo registro de libro de ventas'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="salesbooks view large-9 medium-8 columns content">
    <h3><?= h($salesbook->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($salesbook->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($salesbook->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo de documento') ?></th>
            <td><?= h($salesbook->tipo_documento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cédula o RIF') ?></th>
            <td><?= h($salesbook->cedula_rif) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre o razón social') ?></th>
            <td><?= h($salesbook->nombre_razon_social) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de control') ?></th>
            <td><?= h($salesbook->numero_control) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de factura') ?></th>
            <td><?= h($salesbook->numero_factura) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota de débito') ?></th>
            <td><?= h($salesbook->nota_debito) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota de crédito') ?></th>
            <td><?= h($salesbook->nota_credito) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Factura afectada') ?></th>
            <td><?= h($salesbook->factura_afectada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total ventas más impuestos') ?></th>
            <td><?= $this->Number->format($salesbook->total_ventas_mas_impuestos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('descuento_recargo') ?></th>
            <td><?= $this->Number->format($salesbook->descuento_recargo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ventas exoneradas') ?></th>
            <td><?= $this->Number->format($salesbook->ventas_exoneradas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Base') ?></th>
            <td><?= h($salesbook->base) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alicuota') ?></th>
            <td><?= h($salesbook->alicuota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IVA') ?></th>
            <td><?= $this->Number->format($salesbook->iva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IGFT') ?></th>
            <td><?= $this->Number->format($salesbook->igft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tasa de cambio') ?></th>
            <td><?= $this->Number->format($salesbook->tasa_cambio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo bolívares') ?></th>
            <td><?= $this->Number->format($salesbook->efectivo_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transferencia bolívares') ?></th>
            <td><?= $this->Number->format($salesbook->transferencia_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('POS bolívares') ?></th>
            <td><?= $this->Number->format($salesbook->pos_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Depósito bolivares') ?></th>
            <td><?= $this->Number->format($salesbook->deposito_bolívares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo dólares') ?></th>
            <td><?= $this->Number->format($salesbook->efectivo_dolares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo euros') ?></th>
            <td><?= $this->Number->format($salesbook->efectivo_euros) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zelle') ?></th>
            <td><?= $this->Number->format($salesbook->zelle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Euros') ?></th>
            <td><?= $this->Number->format($salesbook->euros) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('right_bill_number') ?></th>
            <td><?= h($salesbook->right_bill_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('previous_control_number') ?></th>
            <td><?= h($salesbook->previous_control_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ID del documento') ?></th>
            <td><?= $this->Number->format($salesbook->id_documento) ?></td>
        </tr>
    </table>
</div>
