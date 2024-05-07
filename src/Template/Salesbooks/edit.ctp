<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salesbook->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salesbook->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Salesbooks'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="salesbooks form large-9 medium-8 columns content">
    <?= $this->Form->create($salesbook) ?>
    <fieldset>
        <legend><?= __('Edit Salesbook') ?></legend>
        <?php
           echo $this->Form->input('fecha', ['empty' => true]);
           echo $this->Form->input('tipo_documento');
           echo $this->Form->input('cedula_rif');
           echo $this->Form->input('nombre_razon_social');
           echo $this->Form->input('numero_control');
           echo $this->Form->input('numero_factura');
           echo $this->Form->input('nota_debito');
           echo $this->Form->input('nota_credito');
           echo $this->Form->input('factura_afectada');
           echo $this->Form->input('total_ventas_mas_impuestos');
           echo $this->Form->input('descuento_recargo');
           echo $this->Form->input('ventas_exoneradas');
           echo $this->Form->input('base');
           echo $this->Form->input('aliquota');
           echo $this->Form->input('iva');
           echo $this->Form->input('igft');
           echo $this->Form->input('tasa_cambio');
           echo $this->Form->input('monto_divisas');
           echo $this->Form->input('monto_bolivares');
           echo $this->Form->input('right_bill_number');
           echo $this->Form->input('previous_control_number');
           echo $this->Form->input('id_documento');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
