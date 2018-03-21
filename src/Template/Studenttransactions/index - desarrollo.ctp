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
                            <td><input id=<?= "tr" . $studenttransaction->id ?> type="number" value=<?= $studenttransaction->original_amount ?>></td>
                            <td><input type="number" value=<?= $studenttransaction->original_amount - $studenttransaction->amount ?> disabled></td>
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
                        alert('Error: En la cuota Nro. ' + transactionCounter + ' el monto abonado a la cuota: ' + tbTransactions[transactionCounter].amount + ' no puede ser mayor al nuevo monto de la cuota: ' + tbTransactions[transactionCounter].originalAmount + ', por favor verifique');
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
                                
                $.redirect('/desarrollosistemasangabriel/studenttransactions/adjustTransactions', {transactions : stringTransactions});
            } 
        });
    }); 

</script>