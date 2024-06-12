<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $excepcion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $excepcion->id], ['confirm' => __('Está usted seguro que desea eliminar la excepción con el ID # {0}?', $excepcion->id)]) ?> </li>
        <li><?= $this->Html->link(__('Lista de excepciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nueva excepcion'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="excepciones view large-9 medium-8 columns content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($excepcion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Año') ?></th>
            <td><?= h($excepcion->anio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mes') ?></th>
            <td><?= h($excepcion->mes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identificador asociado') ?></th>
            <td><?= h($excepcion->identificador_asociado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Consecutivo identificador') ?></th>
            <td><?= h($excepcion->consecutivo_identificador) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Acción') ?></th>
            <td><?= h($excepcion->accion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de Control Secuencia&nbsp;&nbsp;') ?></th>
            <td><?= h($excepcion->numero_control_secuencia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($excepcion->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo de documento') ?></th>
            <td><?= h($excepcion->tipo_documento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cédula o RIF') ?></th>
            <td><?= h($excepcion->cedula_rif) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre o razón social') ?></th>
            <td><?= h($excepcion->nombre_razon_social) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de control') ?></th>
            <td><?= h($excepcion->numero_control) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de factura') ?></th>
            <td><?= h($excepcion->numero_factura) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota de débito') ?></th>
            <td><?= h($excepcion->nota_debito) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota de crédito') ?></th>
            <td><?= h($excepcion->nota_credito) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Factura afectada') ?></th>
            <td><?= h($excepcion->factura_afectada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total ventas más impuestos') ?></th>
            <td><?= $this->Number->format($excepcion->total_ventas_mas_impuestos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('descuento_recargo') ?></th>
            <td><?= $this->Number->format($excepcion->descuento_recargo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ventas exoneradas') ?></th>
            <td><?= $this->Number->format($excepcion->ventas_exoneradas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Base') ?></th>
            <td><?= h($excepcion->base) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alicuota') ?></th>
            <td><?= h($excepcion->alicuota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IVA') ?></th>
            <td><?= $this->Number->format($excepcion->iva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IGFT') ?></th>
            <td><?= $this->Number->format($excepcion->igft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tasa de cambio') ?></th>
            <td><?= $this->Number->format($excepcion->tasa_cambio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo bolívares') ?></th>
            <td><?= $this->Number->format($excepcion->efectivo_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transferencia bolívares') ?></th>
            <td><?= $this->Number->format($excepcion->transferencia_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('POS bolívares') ?></th>
            <td><?= $this->Number->format($excepcion->pos_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Depósito bolivares') ?></th>
            <td><?= $this->Number->format($excepcion->deposito_bolivares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo dólares') ?></th>
            <td><?= $this->Number->format($excepcion->efectivo_dolares) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Efectivo euros') ?></th>
            <td><?= $this->Number->format($excepcion->efectivo_euros) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zelle') ?></th>
            <td><?= $this->Number->format($excepcion->zelle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Euros') ?></th>
            <td><?= $this->Number->format($excepcion->euros) ?></td>
        </tr>
    </table>
    <br /><br />
</div>
