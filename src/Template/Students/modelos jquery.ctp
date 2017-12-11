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
          <input type="text" class="form-control" id="family">
        </div>
        <br />
        <div>
            <button id="everyfamily" class="btn btn-success">Listar todas las familias</button>
        </div>
        <br />
        <div class="panel panel-default pre-scrollable" style="height:400px;">
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
        <div class="panel panel-default pre-scrollable" style="height:180px;">
            <div class="panel-body">
                <div id="family-group"></div>
            </div>
        </div>
        <p><b>Estudiantes relacionados:</b></p>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive" style="height:180px;">          
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
        <p><b>Cobro de mensualidad:</b></p>
        <div class="panel panel-default pre-scrollable" style="height:60px;">
            <div class="panel-body">
                <div id="student-data"></div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive" style="height:300px;">          
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
        <br />
        <div id="divRecorrer" style="border:1px Solid Red">
            <br/>
                <input name="checkbox" id="checkbox" type="checkbox" value="1" />  
                <input name="checkbox" id="checkbox" type="checkbox" value="1" />  
                <input name="checkbox" id="checkbox" type="checkbox" value="1" />  
                <input name="checkbox" id="checkbox" type="checkbox" value="1" />
            <br/>
        </div>
        
        <button id="mark-quotas" class="btn btn-success">Marcar cuotas</button>
        
        <button id="uncheck-quotas" class="btn btn-success" disabled>Reversar</button>
        
        <p id="parrafo">Lo logré. <span> por fin.</span></p>
 
        <p><input type="button" name="boton01" id="boton01" value="Obtener texto del párrafo"></p>
        
        <input name="checkbox" id="checkbox2" type="checkbox" value="1" />  
        <input name="checkbox_comprobar" id="checkbox_comprobar" type="button" value="Comprobar" />  
        <input name="checkbox_activar" id="checkbox_activar" type="button" value="Activar" />  
        <input name="checkbox_desactivar" id="checkbox_desactivar" type="button" value="Desactivar" />
        
        <p id="studentbalance"></p>
        
    </div>
<script>

    var studentbalance = 0;

    $( function() {
        function log( message ) {
            $("#response-container").html("");
            $( "<tbody>" ).html( message ).prependTo( "#response-container" );
            $( "#response-container" ).scrollTop( 0 );
            $("#family-group").html("");
            $("#related-students").html("");
            $("#student-data").html("");
            $("#monthly-payment").html("");
            studentbalance = studentbalance + 1000;
            $("#studentbalance").html(studentbalance);
        }
         
        $('#family').autocomplete({
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=" + ui.item.id + " onclick='updateResult(" + ui.item.id + ")'><td>" + ui.item.value + "</td></tr>");
              }
        });
    });

    $(document).ready(function() {
    
    // getdeails será nuestra función para enviar la solicitud ajax    
    var getdetails = function(id) {
        
        return $.getJSON('/students/everyfamily'); 
        
    }

    $("#boton01").click(function(){
        var textoparrafo = $("#parrafo").text();
    	    
    	alert(textoparrafo);
    });
    
    $("#checkbox_comprobar").click(function() {  
        if($("#checkbox2").is(':checked')) {  
            alert("Está activado");  
        } else {  
            alert("No está activado");  
        }  
    });  
   
    $("#checkbox_activar").click(function() {  
        $("#checkbox2").attr('checked', true);  
    });  
  
    $("#checkbox_desactivar").click(function() {  
        $("#checkbox2").attr('checked', false);  
    });   
   
    $("#mark-quotas").click(function () 
    {
        $("#monthly-payment input").each(function (index) 
        { 
            if($(this).attr('value') != "Pagada")
            {
                if(!($(this).is(':checked'))) 
                {
                    $(this).attr('checked', true);
                    $("#mark-quotas").html($('input').eq(index+2).attr('name'));
                    $('#uncheck-quotas').attr('disabled', false);
                    return false; 
                }
            }
        }); 
    });

    $("#uncheck-quotas").click(function () 
    {
        var transactionIndex = "";
        var transactionDescription = "";
        
        $("#monthly-payment input").each(function (index) 
        { 
            
            if($(this).attr('value') != "Pagada")
            {
                if($(this).is(':checked'))
                {
                    transactionIndex = $(this).attr('id');
                    transactionDescription = $(this).attr('name');
                }
                else 
                {
                    if (transactionIndex != "")
                    {
                        $('#' + transactionIndex).attr('checked', false);
                        $("#mark-quotas").html(transactionDescription);
                    }
                    return false;
                }
            }
        });
        if (transactionIndex == "")
            alert("Debe marcar al menos una cuota para poder reversar");
    }); 

    $('#everyfamily').click(function(e) {
        
        // Detenemos el comportamiento normal del evento click sobre el elemento clicado
        e.preventDefault();

        $("#family-group").html("");
        $("#related-students").html("");
        $("#student-data").html("");
        $("#monthly-payment").html("");
        
        // Mostramos texto de que la solicitud está en curso
        $("#response-container").html("<p>Buscando...</p>");
        
        // this hace referencia al elemento que ha lanzado el evento click
        // con el método .data('user') obtenemos el valor del atributo data-user de dicho elemento y lo pasamos a la función getdetails definida anteriormente
        getdetails()
        
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
                            output += "<tr id=" + uservalue + " onclick='updateResult(" + uservalue + ")'><td>";
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
                studentbalance = studentbalance + 1000;
                $("#studentbalance").html(studentbalance);

                } else {
                
                //response.success no es true
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
                
            }
            
        })
        
        .fail(function(jqXHR, textStatus, errorThrown) {
            
            $("#response-container").html("Algo ha fallado: " + textStatus);
            
        });
        
    });

});

function updateResult(id){

    $("#details-payment").html("<p>Buscando...</p>");
       
    $.getJSON('/students/relatedstudents', {"id": id})
     
        .done(function(response) {
            
            //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
            if (response.success) {
                
                var guardian = "<p>Familia: " + response.data.family + "</p><p>Representante: " + response.data.first_name + ' ' + response.data.surname + "</p>" +
                     "<p>Teléfono celular: " + response.data.cell_phone + "</p><p>Email: " + response.data.email; 

                // Actualizamos el HTML del elemento con id="#response-container"
                $("#family-group").html(guardian);

                students = " ";

                // recorremos cada estudiante
                $.each(response.data.students, function(key, value) 
                {
                    // recorremos los valores de cada usuario
                    $.each(value, function(userkey, uservalue) 
                    {
                        if (userkey == 'id')
                            students += "<tr id=" + uservalue + " onclick='searchForStudent(" + uservalue + ")'>";
                        else 
                            if (userkey == 'section')
                                    students += "<td>" + uservalue + "</td></tr>";
                                else
                                    students += "<td>" + uservalue + "</td>";
                    });
                });

                // Actualizamos el HTML del elemento con id="#response-container"
                $("#related-students").html(students);
                     
                } else {
                
                //response.success no es true
                $("#details-payment").html('No ha habido suerte: ' + response.message);
                
            }
            
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            
            $("#details-payment").html("Algo ha fallado: " + textStatus);
            
        });        
}

function searchForStudent(id){

    $("#monthly-payment").html("<p>Buscando...</p>");
       
    $.getJSON('/students/searchForStudent', {"id": id})
     
    .done(function(response) {
            
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if (response.success) 
        {    
            var student = "<p><b>Alumno: </b>" + response.data.first_name + " " + response.data.surname + ", <b> Grado: </b>" + response.data.sublevel + ", <b>Sección: </b>" + response.data.section; 

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
                            studentTransactions += "<tr><td>" + uservalue + "</td>";
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
            $("#mark-quotas").html(nextPayment);
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
</script>