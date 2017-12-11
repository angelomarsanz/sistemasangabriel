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
                            <input type="checkbox" id="tr211" name="Sep 2017" value="35000" disabled="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button id="guardar-pagos" class="btn btn-success">Guardar pagos</button>

<div id="imprimir-mensualidades"></div>

<script>

var mensualidades = new Object();

var salidaMensualidades = "";

var padre = "Angel";
var studentAccountant = 0;
var shareAccountant = 0;
var estudiante1 = "Pedro";
var estudiante2 = "Juan";

/*

mensualidades.nameParent = padre;

mensualidades.students = new Array();

mensualidades.students[0] = new Object();

mensualidades.students[0].nameStudent = estudiante1;

mensualidades.students[0].transactionStudents = new Array();

mensualidades.students[0].transactionStudents[0] = new Object();

mensualidades.students[0].transactionStudents[0].mes = 'Diciembre 2017';

mensualidades.students[0].transactionStudents[0].monto = 2000;

*/

$(document).ready(function()
{
    $("#guardar-pagos").click(function () 
    {
        mensualidades.nameParent = padre;

        mensualidades.students = new Array();

        mensualidades.students[studentAccountant] = new Object();

        mensualidades.students[studentAccountant].nameStudent = estudiante1;
        
        mensualidades.students[studentAccountant].transactionStudents = new Array();
        
        $("#monthly-payment input").each(function (index) 
        { 
            if($(this).attr('value') != "Pagada")
            {
                if($(this).is(':checked')) 
                {
                    mensualidades.students[studentAccountant].transactionStudents[shareAccountant] = new Object();
                    idStudenttransactions = $(this).attr('id'); 
                    mensualidades.students[studentAccountant].transactionStudents[shareAccountant].id = idStudenttransactions.substring(2);
                    mensualidades.students[studentAccountant].transactionStudents[shareAccountant].share = $(this).attr('name');
                    mensualidades.students[studentAccountant].transactionStudents[shareAccountant].amount = $(this).attr('value');
                    shareAccountant++;
                }
            }
        }); 
    
        salidaMensualidades += "<p>Padre: " + mensualidades.nameParent + "</p>";
        
        $.each(mensualidades.students, function(indice, valor) 
        {
            $.each(valor, function(indice2, valor2)
            {
                if (indice2 == 'nameStudent')
                {
                    salidaMensualidades += "<p>Alumno: " + valor2 + "</p>";
                }
                if (indice2 == 'transactionStudents')
                {
                    salidaMensualidades += "<p>Mensualidades:</p>";
                    $.each(valor2, function(indice3, valor3)
                    {
                        $.each(valor3, function(indice4, valor4)
                        {
                            if (indice4 == 'mes')
                                salidaMensualidades += "<p>" + indice4 + ": " + valor4 + " ";
                            else
                                salidaMensualidades += indice4 + ": " + valor4 + "</p>";
                        });
                    });
                }
            });
        });
    
        $('#imprimir-mensualidades').html(salidaMensualidades);
    });

});

</script>