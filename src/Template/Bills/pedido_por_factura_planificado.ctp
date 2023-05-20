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
            <h3>Sustituir Pedido Por Factura Planificado (Contabilidad)</h3>
        </div>
        <div class='alert alert-warning'>
            <strong>Esta opción es únicamente para convertir pedidos a facturas para conciliar la contabilidad</strong>
        </div>";
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <?= $this->Form->create() ?>
                    <fieldset>
                        <input type="hidden" name="monto_igtf_dolar" id="monto_igtf_dolar" value="0">
                        <input type="hidden" name="monto_igtf_euro" id="monto_igtf_euro" value="0"> 
                        <input type="hidden" name="monto_igtf_bolivar" id="monto_igtf_bolivar" value="0">
                        <input type="hidden" name="moneda_de_pago" id="moneda_de_pago" value="$"> 
                        <input type="hidden" name="metodo_de_pago" id="metodo_de_pago" value="Efectivo">  
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

            var pedido_con_igtf = 
                "<div class='alert alert-info'>" +
                    "<strong>Por favor pulse el botón 'Facturar' para continuar</strong>" +
                "</div>";

            var pedido_sin_igtf = 
            "<div class='alert alert-info'>" +
                "<strong>Este pedido no tiene pagos en divisas y no se puede facturar por esta opción</strong>" +
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
                        $('#alerta_pedido').html(pedido_con_igtf);
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
                        $('#alerta_pedido').html(pedido_sin_igtf);
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
		
        $('#facturar').click(function(e) 
        {
            $('#facturar').hide();
        });
    });
</script>