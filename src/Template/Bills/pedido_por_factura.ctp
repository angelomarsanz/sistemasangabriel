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
                <?= $this->Form->create("pedido-por-factura", ["id" => "formulario_pedido_por_factura"]) ?>
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
                    <div id="mensaje_usuario"></div>
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
                "<div class='alert alert-danger'>" +
                    "<strong>Por favor complete los datos del pago del IGTF de acuerdo con la forma de pago usada por el representante</strong>" +
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
		
        $("#formulario_pedido_por_factura").on("submit", function(evento) 
        {
            $('#mensaje_usuario').html("");
            let resultado_division = 0;
            let monto_divisas_con_decimales = 0;
            let monto_divisas_sin_decimales = 0;
            let moneda = "";

            if ($("#moneda_de_pago").val() != "Bs." && $("#metodo_de_pago").val() == "Efectivo")
            {
                if ($("#moneda_de_pago").val() == "$")
                {
                    monto_divisas_con_decimales = $('#monto_igtf_dolar_visible').val();
                    monto_divisas_sin_decimales = Math.trunc($('#monto_igtf_dolar_visible').val());
                    moneda = "dólares";
                }
                else
                {
                    monto_divisas_con_decimales = $('#monto_igtf_euro_visible').val();
                    monto_divisas_sin_decimales = Math.trunc($('#monto_igtf_euro_visible').val());
                    moneda = "euros";
                }
                resultado_division = monto_divisas_con_decimales / monto_divisas_sin_decimales;

                if (resultado_division != 1)
                {
                    let r = confirm("Estimado usuario has seleccionado pago en EFECTIVO para cancelar "+monto_divisas_con_decimales+" "+moneda+" de IGTF ¿ Estás seguro de que es correcto ?");
                    if (r == false)
                    {
                        evento.preventDefault();
                    }
                }
                else
                {
                    $('#facturar').hide();
                }
            }
            else
            {
                $('#facturar').hide();
            }
        });
    });
</script>