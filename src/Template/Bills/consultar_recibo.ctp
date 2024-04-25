<div class="row">
    <div class="col-md-4">
    	<div class="page-header">
            <p><?= $this->Html->link(__('Volver'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-default']) ?></p>
    		<h3>Consulta de recibo o pedido</h3>
        </div>
    	<div>
            <?= $this->Form->create() ?>
                <fieldset>
                    <?php
                        echo $this->Form->input('billNumber', ['label' => 'Número de recibo o pedido: *', 'required' => 'true', 'type' => 'number']);
                        echo $this->Form->input('tipo_documento', ['label' => 'Tipo de documento: ', 'options' => 
                        ["" => "",
                        'Pedido' => 'Pedido',
                        'Recibo de anticipo' => 'Recibo de anticipo',
                        'Recibo de compra' => 'Recibo de compra',
                        'Recibo de compra de pedido' => 'Recibo de compra de pedido',
                        'Recibo de Consejo Educativo' => 'Recibo de Consejo Educativo',
                        'Recibo de reintegro' => 'Recibo de reintegro',
                        'Recibo de reintegro de pedido' => 'Recibo de reintegro de pedido',
                        'Recibo de seguro' => 'Recibo de seguro',
                        'Recibo de servicio educativo' => 'Recibo de servicio educativo',
                        'Recibo de sobrante' => 'Recibo de sobrante',
                        'Recibo de sobrante de pedido' => 'Recibo de sobrante de pedido',
                        'Recibo de vuelto de compra' => 'Recibo de vuelto de compra',
                        'Recibo de vuelto de compra de pedido' => 'Recibo de vuelto de compra de pedido']]); 
                    ?>
                </fieldset>   
                <?= $this->Form->button(__('Buscar'), ['class' =>'btn btn-success']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>