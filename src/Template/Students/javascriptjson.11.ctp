<div id="imprimir-mensualidades"></div>

<script>

var mensualidades = new Object();

var salidaMensualidades = "";

var padre = "Angel";
var estudiante1 = "Pedro";
var estudiante2 = "Juan";

mensualidades.nameParent = padre;

mensualidades.students = new Array();

mensualidades.students[0] = new Object();

mensualidades.students[0].nameStudent = estudiante1;

mensualidades.students[0].transactionStudents = new Array();

mensualidades.students[0].transactionStudents[0] = new Object();

mensualidades.students[0].transactionStudents[0].mes = 'Diciembre 2017';

mensualidades.students[0].transactionStudents[0].monto = 2000;

$(document).ready(function()
{
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

</script>