<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Listado de registros del libro de ventas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <?= $this->Form->create($salesbook) ?>
        <fieldset>
            <legend><?= __('Agregar registro de libro de ventas') ?></legend>
            <?php
            echo $this->Form->input('fecha', ["label" => "Fecha", "placeholder" => "dd/mm/aaaa"]);
            echo $this->Form->input('tipo_documento', ["label" => 'Tipo de documento', 'options' => 
            [
                '' => '',
                'Fact' => 'Factura',
                'NC' => 'Nota de crédito',
                'ND' => 'Nota de débito'
            ]]);
            echo $this->Form->input('cedula_rif', ["label" => "Cédula/RIF", "placeholder" => "V - nnnnn ó J - nnnnnn"]);
            echo $this->Form->input('nombre_razon_social', ["label" => "Nombre o razón social"]);
            echo $this->Form->input('numero_control', ["label" => "Nro. de Control", "placeholder" => "nnnnnn"]);
            echo $this->Form->input('numero_factura', ["label" => "Nro. de factura", "placeholder" => "nnnnnn"]);
            echo $this->Form->input('nota_debito', ["label" => "Nota de débito"]);
            echo $this->Form->input('nota_credito', ["label" => "Nota de crédito"]);
            echo $this->Form->input('factura_afectada', ["label" => "Factura afectada", "placeholder" => "nnnnnn"]);
            echo $this->Form->input('total_ventas_mas_impuestos', ["label" => "Total ventas más impuestos"]);
            echo $this->Form->input('descuento_recargo', ["label" => "Descuento/Recargo"]);
            echo $this->Form->input('ventas_exoneradas', ["label" => "Ventas Exoneradas"]);
            echo $this->Form->input('base', ["label" => "Base"]);
            echo $this->Form->input('alicuota', ["label" => 'Alicuota', 'options' => 
                [
                    '16%' => '16%'
                ]]);
            echo $this->Form->input('iva', ["label" => "IVA"]);
            echo $this->Form->input('igft', ["label" => "IGFT"]);
            echo $this->Form->input('tasa_cambio', ["label" => "Tasa de cambio"]);
            echo $this->Form->input('efectivo_bolivares', ["label" => "Efectivo bolívares"]);
            echo $this->Form->input('transferencia_bolivares', ["label" => "Transferencia bolívares"]);
            echo $this->Form->input('pos_bolivares', ["label" => "POS bolívares"]);
            echo $this->Form->input('deposito_bolivares', ["label" => "Depósito bolívares"]);
            echo $this->Form->input('efectivo_dolares', ["label" => "Efectivo dólares"]);
            echo $this->Form->input('efectivo_euros', ["label" => "Efectivo euros"]);
            echo $this->Form->input('zelle', ["label" => "zelle"]);
            echo $this->Form->input('euros', ["label" => "euros"]); 
            echo $this->Form->input('right_bill_number', ["label" => "right_bill_number"]);
            echo $this->Form->input('previous_control_number', ["label" => "previous_control_number"]);
            echo $this->Form->input('id_documento', ["label" => "id_documento"]); 
            ?>
        </fieldset>
    <?= $this->Form->button(__('Enviar')) ?>
    <?= $this->Form->end() ?>
</div>
