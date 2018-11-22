<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-8">
        <div class="page-header">
            <h3>Alumno: <?= $student ?></h3>
            <p><?= $this->Html->link(__('Volver'), ['controller' => 'Students', 'action' => 'modifyTransactions'], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Cuota</th>
                        <th scope="col">Monto de la cuota</th>
                        <th scope="col">Monto abonado a esta cuota</th>
                    </tr>
                </thead>
                <tbody id="transactions">
                    <?php $accountant = 0; ?>
                    <?php foreach ($studenttransactions as $studenttransaction): ?>
                        <tr>
                            <td><?= $accountant ?></td>
                            <td><?= $studenttransaction->transaction_description ?></td>
							<?php if ($studenttransaction->transaction_type == "Mensualidad"): ?>
								<?php if (substr($studenttransaction->transaction_description, 0, 3) != 'Ago'): ?>
									<?php if ($studenttransaction->paid_out == 0): ?>
										<td><input id=<?= "tr" . $studenttransaction->id ?> type="number" value=<?= $amountMonthly ?>></td>
									<?php else: ?>
										<td><input id=<?= "tr" . $studenttransaction->id ?> type="number" value=<?= $studenttransaction->original_amount ?>></td>
									<?php endif; ?>
								<?php else: ?>
									<td><input id=<?= "tr" . $studenttransaction->id ?> type="number" value=<?= $studenttransaction->original_amount ?>></td>
								<?php endif; ?>
							<?php else: ?>
								<td><input id=<?= "tr" . $studenttransaction->id ?> type="number" value=<?= $studenttransaction->original_amount ?>></td>
							<?php endif; ?>
                            <td><input type="number" value=<?= $studenttransaction->amount ?> disabled></td>
                        </tr>
                        <?php $accountant++; ?>    
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br />
        <button id="save-invoices" class="btn btn-success">Guardar</button>
    </div>
</div>
<script>
//  Declaración de variables

    var tbTransactions = new Array();
    var errorIndicator = 0;

// Funciones Jquery

    $(document).ready(function() 
    {
        $("#save-invoices").click(function(e) 
        {
            var transactionCounter = 0;
            var indicator = 0;
			errorIndicator = 0;

            e.preventDefault();
            
            $("#transactions input").each(function (index) 
            {
                if (indicator == 0)
                {
                    tbTransactions[transactionCounter] = new Object();
                    tbTransactions[transactionCounter].idTransaction = $(this).attr('id').substring(2);
                    tbTransactions[transactionCounter].originalAmount = parseFloat($(this).val());
                    indicator = 1;    
                }
                else
                {
                    tbTransactions[transactionCounter].amount = parseFloat($(this).val());
                    if (tbTransactions[transactionCounter].amount > tbTransactions[transactionCounter].originalAmount)
                    {
                        alert('Error: En la cuota Nro. ' + transactionCounter + ' el monto de la cuota: ' + tbTransactions[transactionCounter].originalAmount + ' no puede ser menor al monto abonado: ' + tbTransactions[transactionCounter].amount + ', por favor verifique');
                        errorIndicator = 1;
                        $('#tr' + tbTransactions[transactionCounter].idTransaction).css('background-color', '#ff5050');  
                        return false;    
                    }
                    else
                    {
                        indicator = 0;    
                        transactionCounter++;
                    }
                }
            });
            if (errorIndicator == 0)
            {
                var stringTransactions = JSON.stringify(tbTransactions);
                                
                $.redirect('<?php echo Router::url(array("controller" => "studenttransactions", "action" => "adjustTransactions")); ?>', {transactions : stringTransactions});
            } 
        });
    }); 

</script>