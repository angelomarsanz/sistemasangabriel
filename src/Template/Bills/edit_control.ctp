<?php
    use Cake\Routing\Router; 
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h3><b>Modificar número de control a la(s) factura(s): </b></h3>
                </div>
            </div>
            <div class="row panel panel-default" style="padding: 0% 1% 0% 1%;">
                <br />
                <p><b>Por favor escriba el número de la factura a partir de la cual se modificará el número de control: </b></p>
                <div class="col-md-2">
                    <br />
                    <label for="invoice-from">Primera factura: </label>
                    <br />
                    <input type="text" class="form-control" id="invoice-from">
                    <br />
                    <button id="search-invoices" class="btn btn-success">Buscar</button>
                    <br />
                    <br />
                </div>    
                <div class="col-md-8" id="messages"></div>
            </div>
            <div class="row">
                <div class="col-md-12 panel panel-default">
                    <br />
                    <p><b>Facturas a modificar:</b><spam id="invoice-messages"></spam></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="table-responsive">          
                                    <table class="table table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th scope="col">Factura</th>
                                                <th scope="col">Nro. Control</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Nombre o razón social</th>
                                                <th scope="col">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice-lines"></tbody>
                                    </table>
                                </div>
                                <br />
                                <button id="save-invoices" class="btn btn-success" disabled>Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//  Declaración de variables

    var tbBills = new Array();

// Funciones Jquery

    $(document).ready(function() 
    {       
        $('#search-invoices').click(function(e) 
        {
            var decAmount = 0.00;
            
            e.preventDefault();

            $("#messages").html("Por favor espere...");

            $.post('<?php echo Router::url(["controller" => "Bills", "action" => "searchInvoice"]); ?>', 
                { "invoiceFrom" : $('#invoice-from').val() }, null, "json")          

            .done(function(response) 
            {
                if (response.success) 
                {
                    $("#messages").html(response.data.message);

                    var output = ''; 
                    var idBill = '';
					var swFrom = 0;

                    $.each(response.data.invoices, function(key, value) 
                    {
                        $.each(value, function(userkey, uservalue) 
                        {
                        if (userkey == 'id')
                        {
                            output += "<tr id=inv" + uservalue + " class='invoice'>";
                            idBill = uservalue;     
                        }
                        else if (userkey == 'bill_number')
						{
							if (uservalue == $('#invoice-from').val())
							{
								swFrom = 1;
							}
							else
							{
								swFrom = 0;
							}
							output += "<td>" + uservalue + "</td>";
						}
                        else if (userkey == 'control_number')
							if (swFrom == 0)
							{
								output += "<td><input type='number' disabled class='control-number' id=in" + idBill + " name='" + idBill + "' value=" + uservalue + "></td>";								
							}
							else
							{
								output += "<td><input type='number' class='control-number' id=in" + idBill + " name='" + idBill + "' value=" + uservalue + "></td>";
							}
                        else if (userkey == 'amount_paid')
                        {
                            decAmount = parseFloat(uservalue).toFixed(2);
                        
                            output += "<td style='text-align: right;'>" + decAmount + "</td></tr>";
                        }
						else
						{
                            output += "<td>" + uservalue + "</td>";
						}
                        });
                    });
                    $("#invoice-lines").html(" ");
                    $("#invoice-lines").html(output);
                    $('#save-invoices').attr('disabled', false);
                } 
                else 
                {
                    $("#messages").html(response.data.message);
                    $("#invoice-lines").html(" ");
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#messages").html("Algo ha fallado, los números de factura no fueron encontrados: " + textStatus);
            });  
        });			
			
        $("#save-invoices").click(function(e) 
        {
            var transactionCounter = 0;

            e.preventDefault();
            
            $("#invoice-lines input").each(function (index) 
            {
                tbBills[transactionCounter] = new Object();
                tbBills[transactionCounter].idBill = $(this).attr('id').substring(2);
                tbBills[transactionCounter].controlNumber = $(this).val();
            
                transactionCounter++;
            });
            
            var stringBills = JSON.stringify(tbBills);
                                
            $.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "adjustInvoice"]); ?>', {controlNumber : stringBills}); 
    
        });
		
        $('#invoice-lines').on("keydown", ".control-number", function(e) 
        {
            if (e.which == 13)
			{
				var transactionCounter = 0;

				e.preventDefault();
				
				$("#invoice-lines input").each(function (index) 
				{
					tbBills[transactionCounter] = new Object();
					tbBills[transactionCounter].idBill = $(this).attr('id').substring(2);
					tbBills[transactionCounter].controlNumber = $(this).val();
				
					transactionCounter++;
				});
				
				var stringBills = JSON.stringify(tbBills);
									
				$.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "adjustInvoice"]); ?>', {controlNumber : stringBills});
			}
		});
			
// fin funciones Jquery

    }); 

</script>