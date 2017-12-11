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
                <tbody id="monthly-payment">
                    <tr>
                        <td>Matrícula 2017</td>
                        <td>30000</td>
                        <td>
                            <input type="checkbox" id="tr209" name="Matrícula 2017" value="Pagada" checked="checked" disabled=""> (Pag)
                        </td>
                    </tr>
                    <tr>
                        <td>Ago 2018</td>
                        <td>20000</td>
                        <td>
                            <input type="checkbox" id="tr210" name="Ago 2018" value="20000" disabled="" checked="checked">
                        </td>
                    </tr>
                    <tr>
                        <td>Sep 2017</td>
                        <td>35000</td>
                        <td>
                            <input type="checkbox" id="tr211" name="Sep 2017" value="35000" disabled="" checked="checked">
                        </td>
                    </tr>
                    <tr>
                        <td>Oct 2017</td>
                        <td>35000</td>
                        <td>
                            <input type="checkbox" id="tr212" name="Oct 2017" value="35000" disabled="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button id="guardar-pagos" class="btn btn-success">Guardar pagos</button>

<div id="imprimir-dues"></div>

<script>

var dues = new Object();

var printCuotas = "";

var padre = "Angel";
var studentAccountant = 0;
var shareAccountant = 0;
var studentBalance = 30000;
var totalBalance = 50000;

var estudiante1 = "Pedro";
var estudiante2 = "Juan";


$(document).ready(function()
{
    $("#guardar-pagos").click(function () 
    {
        dues.nameParent = padre;
        
        dues.totalBalance = totalBalance;

        dues.students = new Array();

        dues.students[studentAccountant] = new Object();

        dues.students[studentAccountant].nameStudent = estudiante1;
        
        dues.students[studentAccountant].studentBalance = studentBalance;
        
        dues.students[studentAccountant].transactionStudents = new Array();
        
        $("#monthly-payment input").each(function (index) 
        { 
            if($(this).attr('value') != "Pagada")
            {
                if($(this).is(':checked')) 
                {
                    dues.students[studentAccountant].transactionStudents[shareAccountant] = new Object();
                    idStudenttransactions = $(this).attr('id'); 
                    dues.students[studentAccountant].transactionStudents[shareAccountant].id = idStudenttransactions.substring(2);
                    dues.students[studentAccountant].transactionStudents[shareAccountant].share = $(this).attr('name');
                    dues.students[studentAccountant].transactionStudents[shareAccountant].amount = $(this).attr('value');
                    shareAccountant++;
                }
            }
        }); 
    
        printCuotas += "<p>Padre: " + dues.nameParent + "</p>";
        
        printCuotas += "<p>Saldo total factura: " + dues.totalBalance + "</p>";
        
        $.each(dues.students, function(indice, valor) 
        {
            $.each(valor, function(indice2, valor2)
            {
                if (indice2 == 'nameStudent')
                {
                    printCuotas += "<p>Alumno: " + valor2 + "</p>";
                }
                if (indice2 == 'studentBalance')
                {
                    printCuotas += "<p>Saldo alumno: " + valor2 + "</p>";
                }
                if (indice2 == 'transactionStudents')
                {
                    printCuotas += "<p>dues:</p>";
                    $.each(valor2, function(indice3, valor3)
                    {
                        $.each(valor3, function(indice4, valor4)
                        {
                            if (indice4 == 'id')
                                printCuotas += "<p> id: " + valor4 + "</p>";
                            else if (indice4 == 'share')
                                printCuotas += "<p> Cuota: " + valor4 + "</p>";
                            else
                                printCuotas += "<p> Monto: " + valor4 + "</p>";
                        });
                    });
                }
            });
        });
    
        $('#imprimir-dues').html(printCuotas);
    });

});

</script>