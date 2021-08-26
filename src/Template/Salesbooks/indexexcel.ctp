<div class="row">
<h3>Libro de Ventas</h3>
</div>
<div name="libro_ventas" id="libro-ventas" class="container" style="font-size: 12px; line-height: 14px;">
    <div class="row">
        <div class="col-md-12">					
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td style=" text-align: center;">Item</td>
                        <td style=" text-align: center;">Fecha</td>
                        <td style=" text-align: center;">Tipo de documento</td>
                        <td style=" text-align: center;">Cedula o RIF</td>
                        <td style=" text-align: center;">Nombre o razon social</td>
                        <td style=" text-align: center;">Número de control</td>
                        <td style=" text-align: center;">Número de factura</td>
                        <td style=" text-align: center;">Nota de débito</td>
                        <td style=" text-align: center;">Nota de crédito</td>
                        <td style=" text-align: center;">Factura afectada</td>
                        <td style=" text-align: center;">Descuento o recargo</td>
                        <td style=" text-align: center;">Total ventas más impuesto</td>
                        <td style=" text-align: center;">Ventas_exoneradas</td>
                        <td style=" text-align: center;">Base</td>
                        <td style=" text-align: center;">Alicuota</td>
                        <td style=" text-align: center;">IVA</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($invoicesMonth as $invoice)
                    { ?>
                        <tr>
                            <td><?= $invoice->id ?></td>
                            <td><?= $invoice->fecha ?></td>
                            <td><?= $invoice->tipo_documento ?></td>
                            <td><?= $invoice->cedula_rif ?></td>
                            <td><?= $invoice->nombre_razon_social ?></td>
                            <td><?= $invoice->numero_control ?></td>
                            <td><?= $invoice->numero_factura ?></td>
                            <td><?= $invoice->nota_debito ?></td>
                            <td><?= $invoice->nota_credito ?></td>
                            <td><?= $invoice->factura_afectada ?></td>
                            <td><?= number_format($invoice->descuento_recargo, 2, ",", ".") ?></td>
                            <td><?= number_format($invoice->total_ventas_mas_impuesto, 2, ",", ".") ?></td>
                            <td><?= number_format($invoice->ventas_exoneradas, 2, ",", ".") ?></td>
                            <td><?= $invoice->base ?></td>
                            <td><?= $invoice->alicuota ?></td>
                            <td><?= $invoice->iva ?></td>
                        </tr>
                    <?php 
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#libro-ventas").table2excel({
		
				exclude: ".noExl",
			
				name: "libro_ventas",
			
				filename: $('#libro-ventas').attr('name') 
		
			});
		});
    });
        
</script>