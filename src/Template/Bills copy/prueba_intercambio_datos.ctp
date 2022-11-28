<?php
    use Cake\Routing\Router; 
?>
<button id="prueba-intercambio" type=submit>Prueba Intercambio</button>
<script>
    var payments = new Object();
    payments.invoiceDate = " ";
    payments.client = " ";
    payments.identification = " ";
    payments.fiscalAddress = " ";
    payments.taxPhone = " ";
    payments.invoiceAmount = 0;
    
    var tbStudentTransactions = new Array();

    $(document).ready(function()
    {
        $('#prueba-intercambio').click(function(e) 
        {
            e.preventDefault();
            payments.invoiceDate = "05/04/2017";
            payments.client = "Carlos Sánchez";
            payments.identification = "1";
            payments.fiscalAddress = "El Trigal";
            payments.taxPhone = "1";
            payments.invoiceAmount = 100;

            for (var transactionCounter = 0, valor = 1; transactionCounter < 3; transactionCounter++)
            {
                tbStudentTransactions[transactionCounter] = new Object();
                tbStudentTransactions[transactionCounter].idTransaction = valor;
                tbStudentTransactions[transactionCounter].amountPayable = valor + 100;
                valor++;
            }            
           
            console.log(tbStudentTransactions);

            alert("idTransaction: " + tbStudentTransactions[0].idTransaction);
            alert("amountPayable: " + tbStudentTransactions[0].amountPayable);
            
            var stringStudentTransactions = JSON.stringify(tbStudentTransactions);
            
            console.log(stringStudentTransactions);

            alert(stringStudentTransactions);
            
//            $.redirect('http://localhost/sistemasangabriel/bills/recordInvoiceData', {cabecera: payments, studentTransactions : stringStudentTransactions});       
        });
    });
</script>