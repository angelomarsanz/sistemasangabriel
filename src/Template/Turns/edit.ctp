<?php
    use Cake\Routing\Router; 
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
</style>
<div id="page-turn" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h3 id="Turno" value=<?= $turn->id ?>><b>Cerrar Turno: <?= $turn->turn ?></b></h3>
                    <h4>Fecha: <?= $turn->start_date->format('d-m-Y') ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
                </div>
            </div>
			<div id='factura-control' class='row'>
				<div class="col-md-3">
					<p>Por favor introduzca el Nro. de control de la factura <b><?= $lastNumber ?></b></p>	
					<?= $this->Form->input('control_number', ['label' => 'Nro. Control:']) ?>
					<button id="verificar" class="btn btn-success">Verificar si se saltó el número de control</button>
				</div>
			</div>
            <br />
			<div id='contadores'>
				<b>Efectivo:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('initial_cash', ['label' => 'Efectivo al inicio del turno:', 'value' => $turn->initial_cash, 'disabled' => 'disabled']) ?>
						
						<?= $this->Form->input('cash_received', ['label' => 'Pagos recibidos en efectivo:', 'value' => $turn->cash_received, 'disabled' => 'disabled']) ?>
						
						<?= $this->Form->input('registered_cash', ['label' => 'Total efectivo registrado en el sistema:', 'value' => $turn->initial_cash + $turn->cash_received, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_cash', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('cash_difference', ['label' => 'Diferencia:', 'value' => $turn->initial_cash + $turn->cash_received, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Tarjeta de débito:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('debit_card_amount', ['label' => 'Pagos registrados en el sistema:', 'value' => $turn->debit_card_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_debit_card_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('debit_difference', ['label' => 'Diferencia:', 'value' => $turn->debit_card_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Tarjeta de Crédito:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('credit_card_amount', ['label' => 'Pagos registrados en el sistema:', 'value' => $turn->credit_card_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_credit_card_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('credit_difference', ['label' => 'Diferencia:', 'value' => $turn->credit_card_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Transferencias:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('transfer_amount', ['label' => 'Registradas en el sistema:', 'value' => $turn->transfer_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_transfer_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('transfer_difference', ['label' => 'Diferencia:', 'value' => $turn->transfer_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Depósitos:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('deposit_amount', ['label' => 'Registrados en el sistema:', 'value' => $turn->deposit_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_deposit_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('deposit_difference', ['label' => 'Diferencia:', 'value' => $turn->deposit_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Cheques:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('check_amount', ['label' => 'Registrados en el sistema:', 'value' => $turn->check_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_check_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('check_difference', ['label' => 'Diferencia:', 'value' => $turn->check_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<b>Retenciones:</b>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('retention_amount', ['label' => 'Registradas en el sistema:', 'value' => $turn->retention_amount, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('real_retention_amount', ['label' => 'En caja:', 'class' => 'caja', 'value' => 0, 'type' => 'number']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('retention_difference', ['label' => 'Diferencia:', 'value' => $turn->retention_amount, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<h3><b>Totales:</b></h3>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-4">
						<?= $this->Form->input('total_system', ['label' => 'Total registrado en el sistema:', 'value' => $totalAmounts, 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?= $this->Form->input('total_box', ['label' => 'Total en caja:', 'value' => 0, 'type' => 'number', 'disabled' => 'disabled']) ?>
					</div>
					<div class="col-md-4">
						<?=$this->Form->input('total_difference', ['label' => 'Total diferencia:', 'value' => $totalAmounts, 'disabled' => 'disabled']) ?>
					</div>
				</div>
				<br />
				<h3><b>Detalle de los pagos fiscales:</b></h3>
				<div class="row panel panel-default">
					<br />
					<div class="col-md-12">
						<?php 
						$paymentType = " ";
						$totalType = 0;
						$grandTotal = 0;
						foreach ($paymentsTurn as $paymentsTurns): 
							if ($paymentsTurns->fiscal == 1):
								if ($paymentType == " "):
									$paymentType = $paymentsTurns->payment_type; ?>
									<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 15%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Nro. Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Monto Bs.</th>
													<th scope="col" style="width: 10%;">Banco</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
											</thead>
											<tbody id="payments-turn">
								<?php
								elseif ($paymentType != $paymentsTurns->payment_type): ?>
											</tbody>
										</table>
									</div>
									<p style="border-top: 1px solid #c2c2d6;"></p> 
									<p style="text-align: right; "><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
									<br />
									<?php $paymentType = $paymentsTurns->payment_type; ?>
									<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col" style="width: 15%;">Fecha y hora</th>
													<th scope="col" style="width: 10%;">Factura</th>
													<th scope="col" style="width: 10%;">Nro. Control</th>
													<th scope="col" style="width: 10%;">Familia</th>
													<th scope="col" style="width: 10%;">Monto Bs.</th>
													<th scope="col" style="width: 10%;">Banco</th>
													<th scope="col" style="width: 10%;">Tarjeta o serial</th>
												</tr>
											</thead>
											<tbody id="payments-turn">
									<?php 
									$totalType = 0; 
								endif; 
								$totalType = $totalType + $paymentsTurns->amount;
								$grandTotal = $grandTotal + $paymentsTurns->amount; ?>                            
								<tr id=<?= $paymentsTurns->id ?>>
									<td style="width: 15%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->bill_number) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->bill_id) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
									<td style="width: 10%;"><?= h(number_format($paymentsTurns->amount, 2, ",", ".")) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
									<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
								</tr>
							<?php
							endif;
						endforeach; ?>
										</tbody>
									</table>
								</div>
								<p style="border-top: 1px solid #c2c2d6;"></p> 
								<p style="text-align: right;"><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
								<h4 style="text-align: right;"><b>Total General Bs. <?= (number_format($grandTotal, 2, ",", ".")) ?></b></h4>
					</div>
				</div>
				<?php if ($receipt == 1): ?>
					<h3><b>Detalle de los pagos no fiscales:</b></h3>
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php 
							$paymentType = " ";
							$totalType = 0;
							$grandTotal = 0;
							foreach ($paymentsTurn as $paymentsTurns): 
								if ($paymentsTurns->fiscal == 0):
									if ($paymentType == " "):
										$paymentType = $paymentsTurns->payment_type; ?>
										<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
										<div class="table-responsive">
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 15%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura</th>
														<th scope="col" style="width: 10%;">Nro. Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Monto Bs.</th>
														<th scope="col" style="width: 10%;">Banco</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
												</thead>
												<tbody id="payments-turn">
									<?php
									elseif ($paymentType != $paymentsTurns->payment_type): ?>
												</tbody>
											</table>
										</div>
										<p style="border-top: 1px solid #c2c2d6;"></p> 
										<p style="text-align: right; "><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
										<br />
										<?php $paymentType = $paymentsTurns->payment_type; ?>
										<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
										<div class="table-responsive">
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 15%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura</th>
														<th scope="col" style="width: 10%;">Nro. Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Monto Bs.</th>
														<th scope="col" style="width: 10%;">Banco</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
												</thead>
												<tbody id="payments-turn">
										<?php 
										$totalType = 0; 
									endif; 
									$totalType = $totalType + $paymentsTurns->amount;
									$grandTotal = $grandTotal + $paymentsTurns->amount; ?>                            
									<tr id=<?= $paymentsTurns->id ?>>
										<td style="width: 15%;"><?= h($paymentsTurns->created->format('d-m-Y H:i:s')) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->bill_number) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->bill_id) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->name_family) ?></td>
										<td style="width: 10%;"><?= h(number_format($paymentsTurns->amount, 2, ",", ".")) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->bank) ?></td>
										<td style="width: 10%;"><?= h($paymentsTurns->serial) ?></td>
									</tr>
								<?php
								endif;
							endforeach; ?>
											</tbody>
										</table>
									</div>
									<p style="border-top: 1px solid #c2c2d6;"></p> 
									<p style="text-align: right;"><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
									<h4 style="text-align: right;"><b>Total General Bs. <?= (number_format($grandTotal, 2, ",", ".")) ?></b></h4>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorServicioEducativo == 1): ?>
					<h3><b>Detalle de los pagos de servicio educativo:</b></h3>
					<div class="row panel panel-default">
						<br />
						<div class="col-md-12">
							<?php 
							$paymentType = "";
							$totalType = 0;
							$grandTotal = 0;
							foreach ($pagosServicioEducativo as $servicio): 
								if ($servicio['tipoPago'] != ''):
									if ($paymentType == ""):
										$paymentType = $servicio['tipoPago']; ?>
										<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
										<div class="table-responsive">
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 15%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura</th>
														<th scope="col" style="width: 10%;">Nro. Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Monto Bs.</th>
														<th scope="col" style="width: 10%;">Banco</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
												</thead>
												<tbody id="payments-turn">
									<?php
									elseif ($paymentType != $servicio['tipoPago']): ?>
												</tbody>
											</table>
										</div>
										<p style="border-top: 1px solid #c2c2d6;"></p> 
										<p style="text-align: right; "><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
										<br />
										<?php $paymentType = $servicio['tipoPago']; ?>
										<h4><b>Pagos en: <?= $paymentType ?></b></h4> 
										<div class="table-responsive">
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th scope="col" style="width: 15%;">Fecha y hora</th>
														<th scope="col" style="width: 10%;">Factura</th>
														<th scope="col" style="width: 10%;">Nro. Control</th>
														<th scope="col" style="width: 10%;">Familia</th>
														<th scope="col" style="width: 10%;">Monto Bs.</th>
														<th scope="col" style="width: 10%;">Banco</th>
														<th scope="col" style="width: 10%;">Tarjeta o serial</th>
													</tr>
												</thead>
												<tbody id="payments-turn">
										<?php 
										$totalType = 0; 
									endif; 
									$totalType = $totalType + $servicio['monto'];
									$grandTotal = $grandTotal + $servicio['monto']; ?>                            
									<tr id=<?= $servicio['id'] ?>>
										<td style="width: 15%;"><?= h($servicio['fecha']) ?></td>
										<td style="width: 10%;"><?= h($servicio['nroFactura']) ?></td>
										<td style="width: 10%;"><?= h($servicio['nroControl']) ?></td>
										<td style="width: 10%;"><?= h($servicio['familia']) ?></td>
										<td style="width: 10%;"><?= h(number_format($servicio['monto'], 2, ",", ".")) ?></td>
										<td style="width: 10%;"><?= h($servicio['banco']) ?></td>
										<td style="width: 10%;"><?= h($servicio['serial']) ?></td>
									</tr>
								<?php
								endif;
							endforeach; ?>
											</tbody>
										</table>
									</div>
									<p style="border-top: 1px solid #c2c2d6;"></p> 
									<p style="text-align: right;"><b>Total <?= $paymentType . " Bs. " . (number_format($totalType, 2, ",", ".")) ?></b></p>
									<h4 style="text-align: right;"><b>Total General Bs. <?= (number_format($grandTotal, 2, ",", ".")) ?></b></h4>
						</div>
					</div>
				<?php endif; ?>				
				<div class="row">
					<div class="col-md-12">
						<button id="close-turn" class="btn btn-success">Cerrar turno</button>
						<br />
						<br />
					</div>
				</div>
			</div>
        </div>
    </div>            
</div>   
<script>
    var turnValues = new Object();
    turnValues.id = 0;
    turnValues.cashReceived = 0;
    turnValues.realCash = 0;
    turnValues.debitCardAmount = 0;
    turnValues.realDebitCardAmount = 0;
    turnValues.creditCardAmount = 0;
    turnValues.realCreditCardAmount = 0;
    turnValues.transferAmount = 0;
    turnValues.realTransferAmount = 0;
    turnValues.depositAmount = 0;
    turnValues.realDepositAmount = 0;
    turnValues.checkAmount = 0;
    turnValues.realCheckAmount = 0;
    turnValues.retentionAmount = 0;
    turnValues.realRetentionAmount = 0;
    turnValues.totalSystem = 0;
    turnValues.totalBox = 0;
    turnValues.totalDifference = 0;
    
    var paymentsTurn = new Array(); 

    $(document).ready(function() 
    {
		if ('<?= $lastNumber ?>' == 0)
		{
			$('#factura-control').addClass('noverScreen');
		}
		else
		{
			$('#contadores').addClass('noverScreen');
		}
		$('#verificar').click(function(e) 
        {
			if ($('#control-number').val() == '<?= $lastControl ?>')
			{
				alert('Felicidades ! Los números de control están correctos, puede continuar con el cierre de turno')
				$('#factura-control').addClass('noverScreen');
				$('#contadores').removeClass('noverScreen');
			}
			else
			{
				$.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "editControl"]); ?>', {turn : '<?= $turn->id ?>'});
			}
		});
        var totalDifference = function()
        {
            var totalBox = 0;
            
            $('.caja').each(function()
            {
                totalBox = totalBox + parseFloat($(this).val());
            });

            $("#total-box").val(totalBox);
                
            $("#total-difference").val( ($("#total-system").val()) - ($("#total-box").val()) ); 
        };
        
        $('#real-cash').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                var totalCash = parseFloat($("#initial-cash").val()) + parseFloat($("#cash-received").val());
                
                $("#cash-difference").val(totalCash - parseFloat($("#real-cash").val())); 
                
                totalDifference();
            }
        });    
        
        $('#real-cash').focusout(function(e) 
        {
            e.preventDefault();

            var totalCash = parseFloat($("#initial-cash").val()) + parseFloat($("#cash-received").val());
                
            $("#cash-difference").val(totalCash - parseFloat($("#real-cash").val())); 
                
            totalDifference();
        });
        
        $('#real-debit-card-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#debit-difference").val( ($("#debit-card-amount").val()) - ($("#real-debit-card-amount").val()) );            

                totalDifference();
            }
        });   
        
        $('#real-debit-card-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#debit-difference").val( ($("#debit-card-amount").val()) - ($("#real-debit-card-amount").val()) );            

            totalDifference();
        });   

        $('#real-credit-card-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#credit-difference").val( ($("#credit-card-amount").val()) - ($("#real-credit-card-amount").val()) );            

                totalDifference();
            }
        });  
        
        $('#real-credit-card-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#credit-difference").val( ($("#credit-card-amount").val()) - ($("#real-credit-card-amount").val()) );            

            totalDifference();
        });        
        
        $('#real-transfer-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#transfer-difference").val( ($("#transfer-amount").val()) - ($("#real-transfer-amount").val()) );            
    
                totalDifference();
            }
        });    
        
        $('#real-transfer-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#transfer-difference").val( ($("#transfer-amount").val()) - ($("#real-transfer-amount").val()) );            
    
            totalDifference();
        });        

        $('#real-deposit-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#deposit-difference").val( ($("#deposit-amount").val()) - ($("#real-deposit-amount").val()) );            

                totalDifference();
            }
        });    
        
        $('#real-deposit-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#deposit-difference").val( ($("#deposit-amount").val()) - ($("#real-deposit-amount").val()) );            

            totalDifference();
        });        
        
        $('#real-check-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#check-difference").val( ($("#check-amount").val()) - ($("#real-check-amount").val()) );            

                totalDifference();
            }
        });  
        
        $('#real-check-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#check-difference").val( ($("#check-amount").val()) - ($("#real-check-amount").val()) );            

            totalDifference();
        });        
        
        $('#real-retention-amount').on("keydown", function(e) 
        {
            if (e.which == 9 || e.which == 13)
            {
                $("#retention-difference").val( ($("#retention-amount").val()) - ($("#real-retention-amount").val()) );            
    
                totalDifference();
            }
        });  
        
        $('#real-retention-amount').focusout(function(e) 
        {
            e.preventDefault();

            $("#retention-difference").val( ($("#retention-amount").val()) - ($("#real-retention-amount").val()) );            
    
            totalDifference();
        });  
        
        $('#close-turn').click(function(e) 
        {
            e.preventDefault();
            
            turnValues.id = $("#Turno").attr('value');
            turnValues.cashReceived = parseFloat($("#cash-received").val());
            turnValues.realCash = parseFloat($("#real-cash").val());
            turnValues.debitCardAmount = parseFloat($("#debit-card-amount").val());
            turnValues.realDebitCardAmount = parseFloat($("#real-debit-card-amount").val());
            turnValues.creditCardAmount = parseFloat($("#credit-card-amount").val());
            turnValues.realCreditCardAmount = parseFloat($("#real-credit-card-amount").val());
            turnValues.transferAmount = parseFloat($("#transfer-amount").val());
            turnValues.realTransferAmount = parseFloat($("#real-transfer-amount").val());
            turnValues.depositAmount = parseFloat($("#deposit-amount").val());
            turnValues.realDepositAmount = parseFloat($("#real-deposit-amount").val());
            turnValues.checkAmount = parseFloat($("#check-amount").val());
            turnValues.realCheckAmount = parseFloat($("#real-check-amount").val());
            turnValues.retentionAmount = parseFloat($("#retention-amount").val());
            turnValues.realRetentionAmount = parseFloat($("#real-retention-amount").val());
            turnValues.totalSystem = parseFloat($("#total-system").val());
            turnValues.totalBox = parseFloat($("#total-box").val());
            turnValues.totalDifference = parseFloat($("#total-difference").val());

/* 
            var accountPaid = 0;

            $("#payments-turn tr").each(function (index) 
            { 
                paymentsTurn[accountPaid] = $(this).attr('id');
                accountPaid++;
            });
            
            var stringPaymentsTurn = JSON.stringify(paymentsTurn);

            $.redirect('/turns/closeTurn', {turnData : turnValues, paymentsData : stringPaymentsTurn }); 

*/            
            $("#page-turn").html("");
                                
            $.redirect('/sistemasangabriel/turns/closeTurn', {turnData : turnValues}); 

        });
    });
        
</script>