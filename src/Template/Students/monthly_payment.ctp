<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="page-header">
        <h2>Búsqueda y selección por familia</h2>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
          <label for="family">Familia:</label>
          <br />
          <input type="text" class="form-control" id="family" onclick="checkCharges()">
        </div>
        <br />
        <div>
            <button id="everyfamily" class="btn btn-success">Listar todas las familias</button>
        </div>
        <br />
        <div class="panel panel-default pre-scrollable" style="height:300px;">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tbody id="response-container"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <p><b>Grupo familiar:</b></p>
        <div class="panel panel-default pre-scrollable" style="height:100px;">
            <div class="panel-body">
                <div id="family-group"></div>
            </div>
        </div>
        <p><b>Estudiantes relacionados:</b></p>
        <div class="panel panel-default pre-scrollable" style="height:265px;">
            <div class="panel-body">
                <div class="table-responsive">          
                    <table class="table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">apellido</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Sección</th>
                            </tr>
                        </thead>
                        <tbody id="related-students"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <p><b>Cobro de mensualidades:</b></p>
        <div class="panel panel-default pre-scrollable" style="height:60px;">
            <div class="panel-body">
                <div id="student-data"></div>
            </div>
        </div>
        <div class="panel panel-default pre-scrollable" style="height:200px;">
            <div class="panel-body">
                <div class="table-responsive">          
                    <table class="table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th scope="col">Concepto</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody id="monthly-payment"></tbody>
                    </table>
                </div>
            </div>
        </div> 
        <div>
            <p><b id="student-concept">Saldo alumno: </b></p>
            
            <p><b>Bs. <spam id="student-balance">0</spam></b></p>
            
            <p><b>Total saldo a pagar: Bs. <spam id="total-balance"></spam></b></p>            
        </div>
        <div>
            <button id="mark-quotas" class="btn btn-success" disabled>Cobrar</button>
            
            <button id="uncheck-quotas" class="btn btn-success" disabled>Reversar</button>            
    
            <button id="save-payments" class="btn btn-success" disabled>Guardar</button>
                
            <button id="charge" class="btn btn-success" disabled>Facturar</button>
            
            <div id="print-dues"></div>
                    
        </div>  
    </div>
</div>
<script>
    var studentBalance = 0;
    var totalBalance = 0;
    var dues = new Object();
    dues.id = 0;
    dues.parentsandguardian_id = " ";
    dues.family = " ";
    dues.nameParent = " ";
    dues.identificationCard = " ";
    dues.fiscalAddress = " ";
    dues.taxPhone = " ";
    dues.totalBalance = 0;
    dues.students = new Array();
    var parentsandguardianId = " ";
    var nameRepresentative = " ";
    var nameFamily = " ";
    var studentName = " ";
    var idStudent = -1;
    var studentAccountant = 0;
    var shareAccountant = 0;
    var idFamily = -1;
    var idStudentTransactions = " ";
    var identificationCard = " ";
    var fiscalAddress = " ";
    var taxPhone = " ";
    var concept = " ";

    function checkCharges()
    {
        if (totalBalance > 0)
        {    
            alert("Si busca otra familia, perderá los datos del cobro realizado a la familia: " + nameFamily );
        }
    }
    
    function log(message) 
    {
        $("#response-container").html("");
        $("<tbody>").html( message ).prependTo("#response-container");
        $("#response-container").scrollTop( 0 );
        $("#family-group").html("");
        $("#related-students").html("");
        $("#student-data").html("");
        $("#monthly-payment").html("");
        
        $("#student-concept").text('Saldo alumno: ');
                
        studentBalance = 0;
                
        $("#student-balance").html("");
                
        totalBalance = 0;
            
        $("#total-balance").html("");
                
        disableButtons();
    }
            
    function familyData(id)
    {
        if (totalBalance > 0)
        {    
            var r = confirm("Si selecciona otra familia, perderá los datos de pago de la familia: " + nameFamily );
            if (r == true)
            {
                if (idFamily > -1)
                {
                    $('#fa' + idFamily).css('background-color', 'white');
                }
                idFamily = id;
                $('#fa' + id).css('background-color', '#c2c2d6');  
                selectFamily(id);
            }
        }
        else
        {
            if (idFamily > -1)
            {
                $('#fa' + idFamily).css('background-color', 'white');
            }
            idFamily = id;
            $('#fa' + id).css('background-color', '#c2c2d6');  
            selectFamily(id);
        }
    }
    
    function selectFamily(id)
    {
        $("#student-data").html("");
            
        totalBalance = 0;
        
        $("#total-balance").html("");
        
        $("#student-concept").text('Saldo alumno: ');
            
        studentBalance = 0;
            
        $("#student-balance").html("");
            
        $("#monthly-payment").html("");
            
        disableButtons();
            
        $("#family-group").html("<p>Buscando...</p>");
                   
            $.post('/students/relatedstudents', {"id" : id}, null, "json")        
                 
            .done(function(response) 
            {
                    
                //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                if (response.success) 
                {
                    var guardian = "<p>Familia: " + response.data.family + "</p><p>Representante: " + response.data.first_name + ' ' + response.data.surname + "</p>" +
                         "<p>Teléfono celular: " + response.data.cell_phone + "</p><p>Email: " + response.data.email; 
            
                    // Actualizamos el HTML del elemento con id="#response-container"
                    $("#family-group").html(guardian);
                    
                    parentsandguardianId = response.data.parentsandguardian_id;
                            
                    nameFamily = response.data.family;
                            
                    nameRepresentative = response.data.first_name + ' ' + response.data.surname;
            
                    students = " ";
                    
                    identificationCard = response.data.type_of_identification + ' ' + response.data.identidy_card;

                    fiscalAddress = response.data.address;
                    
                    taxPhone = response.data.cell_phone;
                    
                    // recorremos cada estudiante
                    $.each(response.data.students, function(key, value) 
                    {
                        // recorremos los valores de cada usuario
                        $.each(value, function(userkey, uservalue) 
                        {
                            if (userkey == 'id')
                            {
                                students += "<tr id=st" + uservalue + " onclick='studentData(" + uservalue + ")'>";
                            }
                            else 
                                if (userkey == 'section')
                                    students += "<td>" + uservalue + "</td></tr>";
                                else
                                    students += "<td>" + uservalue + "</td>";
                        });
                    });
            
                    // Actualizamos el HTML del elemento con id="#response-container"
                    $("#related-students").html(students);
                                 
                } 
                else 
                {
                    //response.success no es true
                    $("#family-group").html('No ha habido suerte: ' + response.message);
                            
                }
                        
            })
            
            .fail(function(jqXHR, textStatus, errorThrown) {
                        
                $("#family-group").html("Algo ha fallado: " + textStatus);
                        
            });  
    }

    function studentData(id)
    {
        if (studentBalance > 0)
        {    
            var r = confirm("Si selecciona otro estudiante, no se guardarán los pagos de: " + studentName);
            if (r == true)
            {
                if (idStudent > -1)
                {
                    uncheckStudent(idStudent);
                }
                idStudent = id;
                markStudent(idStudent); 
                $("#student-concept").text('Saldo alumno: ');
                studentBalance = 0;
                $("#student-balance").html("");
                if (dues.totalBalance == 0)
                {
                    totalBalance = 0;
                    $("#total-balance").html("");
                }
                searchForStudent(id);
            }
        }
        else
        {
            if (idStudent > -1)
            {
                uncheckStudent(idStudent);
            }
            idStudent = id;
            markStudent(idStudent); 
            searchForStudent(id);
        }
    }
    
    function searchForStudent(id)
    {
    
        $("#monthly-payment").html("<p>Buscando...</p>");
           
        $.post('/students/searchForStudent', {"id" : id}, null, "json") 
         
        .done(function(response) {
                
            //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
            if (response.success) 
            {    
                var student = "<p><b>Alumno: </b>" + response.data.first_name + " " + response.data.surname + ", <b> Grado: </b>" + response.data.sublevel + ", <b>Sección: </b>" + response.data.section; 
    
                studentName = response.data.first_name + " " + response.data.surname;
                
                if (response.data.scholarship == 0)
                    student += ", <b>Condición: </b>Regular</p>";
                else
                    student += ", <b>Condición: </b>Becado</p>";
                
                $("#student-data").html(student); 
    
                var studentTransactions = "";
    
                var transactionIdentifier = 0;
                
                var monthlyPayment = " ";
                
                var nextPayment = "";
    
                var transactionAmount = 0;
    
                var indicatorPaid = 0;
                
                    // recorremos cada estudiante
                    $.each(response.data.studenttransactions, function(key, value) 
                    {
                        // recorremos los valores de cada usuario
                        $.each(value, function(userkey, uservalue) 
                        {
                            if (userkey == 'id')
                            {
                                transactionIdentifier = uservalue;
                            }
                            else if (userkey == 'transaction_description')
                            {
                                monthlyPayment = uservalue;
                                studentTransactions += "<tr id='tra" + transactionIdentifier + "'><td>" + uservalue + "</td>";
                            }
                            else if (userkey == 'amount')
                            {
                                transactionAmount = uservalue;
                                studentTransactions += "<td>" + uservalue;
                            }
                            else if (userkey == 'paid_out' && uservalue == 0)
                            {
                                if (indicatorPaid == 0)
                                {
                                    nextPayment = monthlyPayment;
                                    indicatorPaid = 1;
                                }
                                studentTransactions += "<td><input type='checkbox' id='tr" + transactionIdentifier + "' name='" + monthlyPayment + "' value=" + transactionAmount + " disabled></td></tr>";
                            }
                            else if (userkey == 'paid_out' && uservalue == 1)
                                studentTransactions += "<td><input type='checkbox' id='tr" + transactionIdentifier + "' name='" + monthlyPayment + "' value='Pagada' checked='checked' disabled> (Pag)</td></tr>";
                        });
                    });
    
                // Actualizamos el HTML del elemento con id="#response-container"
                $("#monthly-payment").html(studentTransactions);  
                if (nextPayment == "")
                {
                    disableButtons();
                    alert('No existen cuotas a pagar para el alumno: ' + studentName);
                }
                else
                {
                    $("#mark-quotas").html(nextPayment);  
                    $("#mark-quotas").attr('disabled', false);
                }
            }
            else 
            {                
                $("#monthly-payment").html('No ha habido suerte: ' + response.message);    
            }   
        })
    
        .fail(function(jqXHR, textStatus, errorThrown) {
                
            $("#monthly-payment").html("Algo ha fallado: " + textStatus);
                
        });        
    }
    
    function disableButtons()
    {
        $("#mark-quotas").text("cobrar");
        $("#mark-quotas").attr('disabled', true);
        $("#uncheck-quotas").attr('disabled', true);
        $("#save-payments").attr('disabled', true);
        $("#charge").attr('disabled', true);
    }
    
    function markStudent(id)
    {
        $('#st' + id + ' td').each(function ()
        {
            $(this).css('background-color', '#c2c2d6'); 
        });
    }
    
    function uncheckStudent(id)
    {
        $('#st' + id + ' td').each(function ()
        {
            $(this).css('background-color', 'white'); 
        });
    }
    
    function markTransaction(id)
    {
        $('#tra' + id + ' td').each(function ()
        {
            $(this).css('background-color', '#c2c2d6'); 
        });
    }
    
    function uncheckTransaction(id)
    {
        $('#tra' + id + ' td').each(function ()
        {
            $(this).css('background-color', 'white'); 
        });
    }
    
    $(document).ready(function() 
    {
        var postdetails = function() 
        {
            return $.post('/students/everyfamily', null, null, "json") 
        }
     
        $('#family').autocomplete({
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=" + ui.item.id + " onclick='familyData(" + ui.item.id + ")'><td>" + ui.item.value + "</td></tr>");
              }
        });

        $('#everyfamily').click(function(e) {

            // Detenemos el comportamiento normal del evento click sobre el elemento clicado
            e.preventDefault();
            
            if (totalBalance > 0)
            {    
                var r = confirm("Si selecciona otra familia, perderá los datos del cobro realizado a la familia: " + nameFamily );
                if (r == false)
                {
                    return false;
                }
            }

            $("#family-group").html("");
            $("#related-students").html("");
            $("#student-data").html("");
            $("#monthly-payment").html("");
            $("#student-concept").text('Saldo alumno: ');
                
            studentBalance = 0;
                
            $("#student-balance").html("");
                
            totalBalance = 0;
            
            $("#total-balance").html("");
                
            disableButtons();
            
            // Mostramos texto de que la solicitud está en curso
            $("#response-container").html("<p>Buscando...</p>");
            
            // this hace referencia al elemento que ha lanzado el evento click
            // con el método .data('user') obtenemos el valor del atributo data-user de dicho elemento y lo pasamos a la función getdetails definida anteriormente
            postdetails()
            
            .done(function(response) {
                
                //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                if (response.success) {
                    
                    var output = " "; 
    
                    // recorremos cada familia
                    $.each(response.data.families, function(key, value) 
                    {
                           
                        // recorremos los valores de cada usuario
                        $.each(value, function(userkey, uservalue) 
                        {
                            if (userkey == 'id')
                                output += "<tr id=" + uservalue + " onclick='familyData(" + uservalue + ")'><td id=fa" + uservalue + ">";
                            else if (userkey == 'family')
                                output += uservalue + " (";
                                else if (userkey == 'first_name')
                                    output += uservalue + " ";
                                    else
                                    output += uservalue + ")</td></tr>";
                        });
    
                    });
                    
                    // Actualizamos el HTML del elemento con id="#response-container"
                    $("#response-container").html(output);
    
                    } else {
                    
                    //response.success no es true
                    $("#response-container").html('No ha habido suerte: ' + response.data.message);
                    
                }
                
            })
            
            .fail(function(jqXHR, textStatus, errorThrown) {
                
                $("#response-container").html("Algo ha fallado: " + textStatus);
                
            });
            
        });
    
        $("#mark-quotas").click(function () 
        {
            var firstInstallment = " ";
            var lastInstallment = " ";
            
            $("#monthly-payment input").each(function (index) 
            { 
                if($(this).attr('value') != "Pagada")
                {
                    if(!($(this).is(':checked'))) 
                    {
                        $(this).attr('checked', true);
                        idStudentTransactions = $(this).attr('id'); 
                        markTransaction(idStudentTransactions.substring(2));
                        $("#mark-quotas").html($('input').eq(index+2).attr('name'));
                        $('#uncheck-quotas').attr('disabled', false);
                        $('#save-payments').attr('disabled', false);
                        $('#charge').attr('disabled', false);
                        if (firstInstallment == " ")
                        {
                            firstInstallment = $(this).attr('name');
                        }
                        lastInstallment = $(this).attr('name');
                        $("#student-concept").text('Saldo alumno (' + firstInstallment + ' - ' + lastInstallment + '):');
                        concept = firstInstallment + ' - ' + lastInstallment;
                        studentBalance = studentBalance + parseInt($(this).attr('value'));
                        $("#student-balance").html(studentBalance);
                        totalBalance = totalBalance + parseInt($(this).attr('value'));
                        $("#total-balance").html(totalBalance);
                        return false; 
                    }
                    else
                    {
                        if (firstInstallment == " ")
                        {
                            firstInstallment = $(this).attr('name');
                        }
                    }
                }
            }); 
        });
    
        $("#uncheck-quotas").click(function () 
        {
            var transactionDescription = "";
            var transactionAmount = 0;
            var firstInstallment = " ";
            var lastInstallment = " ";
            var markedQuotaCounter = 0;
            idStudentTransactions = " ";

            $("#monthly-payment input").each(function (index) 
            { 
                if($(this).attr('value') != "Pagada")
                {
                    if($(this).is(':checked'))
                    {
                        if (firstInstallment == " ")
                        {
                            firstInstallment = $(this).attr('name');
                        }
                        if (lastInstallment == " ")
                        {
                            lastInstallment = $(this).attr('name');
                        }
                        else
                        {
                            lastInstallment = transactionDescription;
                        }
                        
                        markedQuotaCounter++;
                        
                        idStudentTransactions = $(this).attr('id');
                        transactionDescription = $(this).attr('name');
                        transactionAmount = parseInt($(this).attr('value'));

                    }
                    else 
                    {
                        if (idStudentTransactions != "")
                        {
                            $('#' + idStudentTransactions).attr('checked', false);
                            uncheckTransaction(idStudentTransactions.substring(2));
                            
                            $("#mark-quotas").html(transactionDescription);
                            if (markedQuotaCounter == 1)
                            {
                                firstInstallment = " ";
                                lastInstallment = " ";
                                $("#student-concept").text('Saldo alumno: ');
                            }
                            else
                            {
                                $("#student-concept").text('Saldo alumno (' + firstInstallment + ' - ' + lastInstallment + '):');
                                concept = firstInstallment + ' - ' + lastInstallment;
                            }
                            studentBalance = studentBalance - transactionAmount;
                            $("#student-balance").html(studentBalance);
                            totalBalance = totalBalance - transactionAmount;
                            $("#total-balance").html(totalBalance);
                        }
                        return false;
                    }
                }
            });
            if (transactionIndex == "")
                alert("Debe cobrar al menos una cuota para poder reversar");
        }); 
    
        $("#save-payments").click(function () 
        {
            if (studentBalance > 0)
            {
                var printDues = " ";
                
                dues.parentsandguardian_id = parentsandguardianId;
                
                dues.family = nameFamily;
                
                dues.nameParent = nameRepresentative;
                
                dues.identificationCard = identificationCard;
                
                dues.fiscalAddress = fiscalAddress;
                
                dues.taxPhone = taxPhone;
                
                dues.totalBalance = totalBalance;
                
                dues.students[studentAccountant] = new Object();
        
                dues.students[studentAccountant].nameStudent = studentName;
                
                dues.students[studentAccountant].concept = "Mensualidad: " + concept + " " + studentName;
                
                dues.students[studentAccountant].studentBalance = studentBalance;
                
                dues.students[studentAccountant].transactionStudents = new Array();
                
                shareAccountant = 0;
                
                $("#monthly-payment input").each(function (index) 
                { 
                    if($(this).attr('value') != "Pagada")
                    {
                        if($(this).is(':checked')) 
                        {
                            dues.students[studentAccountant].transactionStudents[shareAccountant] = ($(this).attr('id')).substring(2);
                            shareAccountant++;
                        }
                    }
                }); 
                
                studentAccountant++;
                
                $('#st' + idStudent).attr('onclick', "");
                $("#student-data").html("");
                $("#monthly-payment").html("");
                $("#student-concept").text('Saldo alumno: ');
                $("#student-balance").html
                concept = " ";
                studentBalance = 0;

                alert('El cobro de las mensualidades del alumno ' + studentName + ' se guardó con éxito');
                
            }
            else
                alert("No existen pagos para guardar");
        });
        
        $("#charge").click(function () 
        {
            var r= confirm('¿Está seguro de facturar? Luego no podrá agregar nuevos cobros');
            if (r == false)
            {
                return false;
            }
            $.redirect('/bills/createInvoice', dues);
        });
    });

</script>