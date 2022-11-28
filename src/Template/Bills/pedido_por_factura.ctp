<?php
    use Cake\I18n\Time;
    use Cake\Routing\Router; 
?>
<style>
    .noverScreen
    {
		display:none;
    }
	.fontColor
	{
		color: #ff8080;
	}
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Sustituir Pedido Por Factura</h3>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <?= $this->Form->create() ?>
                    <fieldset>
                        <input type="hidden" name="monto_igtf_dolar" id="monto_igtf_dolar" value="0">
                        <input type="hidden" name="monto_igtf_euro" id="monto_igtf_euro" value="0"> 
                        <input type="hidden" name="monto_igtf_bolivar" id="monto_igtf_bolivar" value="0">  
                        <?php
                        echo $this->Form->input('numero_del_pedido', ['label' => 'Número del pedido*:', 'id' => 'numero_del_pedido']);
                        ?>
                        <div id="alerta_pedido" class="noverScreen">
                            <div class="alert alert-info">
                                <strong>Por favor espere mientras se busca el pedido</strong>
                            </div>
                        </div>
                        <div id='datos_pago_igtf' class='noverScreen fontColor'>
                            <div class="row">
                                <div class="col-md-4">                                                      
                                    <?= $this->Form->input('monto_igtf_dolar_visible', ['label' => 'Monto IGTF $:', 'id' => 'monto_igtf_dolar_visible', 'disabled' => 'disabled']); ?>
                                </div>
                                <div class="col-md-4">                                                      
                                    <?= $this->Form->input('monto_igtf_euro_visible', ['label' => 'Monto IGTF €', 'id' => 'monto_igtf_euro_visible', 'disabled' => 'disabled']); ?>
                                </div>
                                <div class="col-md-4">                                                      
                                    <?= $this->Form->input('monto_igtf_bolivar_visible', ['label' => 'Monto IGTF Bs.', 'id' => 'monto_igtf_bolivar_visible', 'disabled' => 'disabled']); ?>
                                </div>
                            </div>
                            <?php
                            echo $this->Form->input('moneda_de_pago', ['id' => 'moneda_de_pago', 'label' => 'Moneda de pago*:', 'required' => true, 'options' => 
                                [
                                    null => " ",
                                    "$" => "Dólar", 
                                    "€" => "Euro",
                                    "Bs." => "Bolívar"
                                ]]);
                            echo $this->Form->input('metodo_de_pago', ['id' => 'metodo_de_pago', 'label' => 'Método de pago*:', 'required' => true, 'options' => 
                            [
                                null => " ",
                                "Efectivo" => "Efectivo", 
                                "Depósito" => "Depósito",
                                "Tarjeta de débito" => "Tarjeta de débito", 
                                "Tarjeta de crédito" => "Tarjeta de crédito", 
                                "Transferencia" => "Transferencia" 
                            ]]);
                            echo $this->Form->input('banco_emisor', ['label' => 'Banco emisor:', 'id' => 'banco_emisor', 'options' => $banco_emisor]); 
                            echo $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco_receptor', 'options' => $banco_receptor]); 
                            echo $this->Form->input('cuenta_o_tarjeta', ['label' => 'Cuenta o tarjeta:', 'id' => 'cuenta_o_tarjeta']);
                            echo $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial']); 
                            ?>
                        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Facturar'), ['class' =>'btn btn-success', 'id' => 'facturar', 'disabled' => 'disabled']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#numero_del_pedido').change(function(e) 
        {
			e.preventDefault();

            var factura_con_igtf = 
                "<div class='alert alert-info'>" +
                    "<strong>Por favor complete los datos para el pago del IGTF</strong>" +
                "</div>";

            var factura_sin_igtf = 
            "<div class='alert alert-info'>" +
                "<strong>Esta factura está libre de pagos de IGTF</strong>" +
            "</div>";

            var error_consulta_pedido = 
            "<div class='alert alert-warning'>" +
                "<strong>Estimado usuario hubo un error al consultar el pedido en la base de datos</strong>" +
            "</div>";

            var servidor_no_responde = 
            "<div class='alert alert-warning'>" +
                "<strong>Estimado usuario el servidor no responde</strong>" +
            "</div>";

            $('#alerta_pedido').removeClass('noverScreen');
		
			$.post('<?php echo Router::url(["controller" => "Bills", "action" => "verificarPedido"]); ?>', {'numero_del_pedido' : $("#numero_del_pedido").val()}, null, "json")				
                     
            .done(function(response) 
            {                               
                if (response.satisfactorio) 
                {              
                    if (response.monto_igtf_dolar > 0)
                    {
                        $('#alerta_pedido').html(factura_con_igtf);
                        $('#facturar').attr('disabled', false);
                        $('#datos_pago_igtf').removeClass('noverScreen');
                        $('#monto_igtf_dolar').val(response.monto_igtf_dolar);
                        $('#monto_igtf_euro').val(response.monto_igtf_euro);
                        $('#monto_igtf_bolivar').val(response.monto_igtf_bolivar);
                        $('#monto_igtf_dolar_visible').val(response.monto_igtf_dolar);
                        $('#monto_igtf_euro_visible').val(response.monto_igtf_euro);
                        $('#monto_igtf_bolivar_visible').val(response.monto_igtf_bolivar);
                    }
                    else
                    {
                        $('#alerta_pedido').html(factura_sin_igtf);
                        $('#facturar').attr('disabled', false);
                        $('#moneda_de_pago').attr('required', false);
                        $('#metodo_de_pago').attr('required', false);
                    }
                }
                else
                {
                    $('#alerta_pedido').html(error_consulta_pedido);
                } 
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $('#alerta_pedido').html(servidor_no_responde);
            });  
        });			
		
        $('#save-student').click(function(e) 
        {
            $('#save-student').addClass("noverScreen");
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
        });
    });
</script>