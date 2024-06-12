<br /><br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $excepcion->id],
                ['confirm' => __('Está usted seguro que desea eliminar la excepción con el ID # {0}?', $excepcion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('Lista de excepciones'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <?php $excepcionFormato = $excepcion; ?>
        <?= $this->Form->create($excepcion) ?>
        <fieldset>
            <legend><?= __('Editar excepción del libro de ventas') ?></legend>
            <?php
            echo $this->Form->input('anio', ["label" => 'Año', 'options' => 
                [
                    2023 => '2023',
                    2024 => '2024',
                    2025 => '2025',
                    2026 => '2026',
                    2027 => '2027',
                    2028 => '2028',
                    2029 => '2029',
                    2030 => '2030'
                ]]);
            echo $this->Form->input('mes', ["label" => 'Mes', 'options' => 
                [
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                ]]);
            echo $this->Form->input('identificador_asociado', ["label" => "Identificador asociado"]);
            echo $this->Form->input('consecutivo_identificador', ["label" => "Consecutivo identificador"]);
            echo $this->Form->input('accion', ["label" => 'Acción', 'options' => 
                [
                    'Agregar' => 'Agregar',
                    'Modificar' => 'Modificar',
                    'Omitir' => 'Omitir',
                    'Registrar' => 'Registrar'
                ]]);
            echo $this->Form->input('numero_control_secuencia', ["label" => "Nro. de control de secuencia", "placeholder" => "nnnnnn"]);
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
            echo $this->Form->input('zelle', ["label" => "Zelle"]);
            echo $this->Form->input('euros', ["label" => "Euros"]);
        ?>
        </fieldset>
        
        <?= $this->Form->button(__('Enviar')) ?>
        <?= $this->Form->end() ?>
        <br /><br />
    </div>
</div>