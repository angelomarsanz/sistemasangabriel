<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Nueva Excepcion'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div name="excepciones" id="excepciones" class="container" style="font-size: 12px; line-height: 14px;">
    <div class="row">
        <div class="col-md-12">					
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center;"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('anio', 'Año') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('mes', 'Mes') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('identificador_asociado', 'Identificador Asociado') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('consecutivo_identificador', 'Consecutivo Identificador') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('accion', 'Acción') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('numero_control_secuencia', 'Nro Control Secuencia') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('fecha', 'Fecha') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('tipo_documento', 'Tipo Documento') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('cedula_rif', 'Cédula/RIF') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nombre_razon_social', 'Nombre o Razón Social') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('numero_control', 'Número Control') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('numero_factura', 'Número Factura') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nota_debito', 'Nota débito') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('nota_credito', 'Nota Crédito') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('factura_afectada', 'Factura Afectada') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('tota_ventas_mas_impuestos', 'Total Ventas Más Impuestos') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('descuento_recargo', 'Descuento/Recargo') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('ventas_exoneradas', 'Ventas Exoneradas') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('base', 'Base') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('alicuota', 'Aliquota') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('iva', 'IVA') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('igft', 'IGFT') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('tasa_cambio', 'Tasa Cambio') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('efectivo_bolivares', 'Efectivo Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('transferencia_bolivares', 'Transferencia Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('pos_bolivares', 'POS Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('deposito_bolivares', 'Depósito Bolívares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('efectivo_dolares', 'Efectivo Dólares') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('zelle', 'Zelle') ?></th>
                        <th style="text-align:center;"><?= $this->Paginator->sort('euros', 'Euros') ?></th>
                        <th style="text-align: center;"></th>
                        <th style="text-align: center;"></th>
                        <th style="text-align: center;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($excepciones as $excepcion): ?>
                    <tr>
                        <td><?= $this->Number->format($excepcion->id) ?></td>
                        <td><?= h($excepcion->anio) ?></td>
                        <td><?= h($excepcion->mes) ?></td>
                        <td><?= h($excepcion->identificador_asociado) ?></td>
                        <td><?= h($excepcion->consecutivo_identificador) ?></td>
                        <td><?= h($excepcion->accion) ?></td>
                        <td><?= h($excepcion->numero_control_secuencia) ?></td>
                        <td><?= h($excepcion->fecha) ?></td>
                        <td><?= h($excepcion->tipo_documento) ?></td>
                        <td><?= h($excepcion->cedula_rif) ?></td>
                        <td><?= h($excepcion->nombre_razon_social) ?></td>
                        <td><?= h($excepcion->numero_control) ?></td>
                        <td><?= h($excepcion->numero_factura) ?></td>
                        <td><?= h($excepcion->nota_debito) ?></td>
                        <td><?= h($excepcion->nota_credito) ?></td>
                        <td><?= h($excepcion->factura_afectada) ?></td>
                        <td><?= $this->Number->format($excepcion->total_ventas_mas_impuestos) ?></td>
                        <td><?= $this->Number->format($excepcion->descuento_recargo) ?></td>
                        <td><?= $this->Number->format($excepcion->ventas_exoneradas) ?></td>
                        <td><?= h($excepcion->base) ?></td>
                        <td><?= h($excepcion->alicuota)?></td>
                        <td><?= $this->Number->format($excepcion->iva) ?></td>
                        <td><?= $this->Number->format($excepcion->igft) ?></td>
                        <td><?= $this->Number->format($excepcion->tasa_cambio) ?></td>
                        <td><?= $this->Number->format($excepcion->efectivo_bolivares) ?></td>
                        <td><?= $this->Number->format($excepcion->transferencia_bolivares) ?></td>
                        <td><?= $this->Number->format($excepcion->pos_bolivares) ?></td>
                        <td><?= $this->Number->format($excepcion->deposito_bolivares) ?></td>
                        <td><?= $this->Number->format($excepcion->efectivo_dolares) ?></td>
                        <td><?= $this->Number->format($excepcion->efectivo_euros) ?></td>
                        <td><?= $this->Number->format($excepcion->zelle) ?></td>
                        <td><?= $this->Number->format($excepcion->euros) ?></td>
                        <td style="text-align: center;">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $excepcion->id]) ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $excepcion->id]) ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $excepcion->id], ['confirm' => __('Está seguro de que desea eliminar la excepción con el ID # {0}?', $excepcion->id)]) ?>
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