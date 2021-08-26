<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h4>Consultar datos de alumnos con condición distinta a regular</h4>
			<input type="hidden" id="ambiente" value=<?= $school->ambient ?>>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="student">Escriba el primer apellido del alumno</label>
                <br />
                <input type="text" class="form-control" id="student">
                <br />
                <p id="header-messages"></p>
                <br />
                <div class="panel panel-default pre-scrollable" style="height:220px;">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody id="response-container"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Declaración de variables
    var selectStudent = -1;
    var student = "";
    var idStudent = 0;
    
// Funciones

    function log(message) 
    {
        cleanPager();
        $("#response-container").html(message);
    }

    function cleanPager()
    {
        $('#student').val(" ");
        $("#response-container").html("");
    }
    
// Funciones Jquery

    $(document).ready(function() 
    {
        $('#student').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Students", "action" => "findStudentDelete")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=st" + ui.item.id + " class='student'><td>" + ui.item.value + "</td></tr>");
              }
        });

        $("#response-container").on("click", ".student", function()
        {
            idStudent = $(this).attr('id').substring(2);

            if (selectStudent > -1)
            {
                $('#st' + selectStudent).css('background-color', 'white');
            }
            
            selectStudent = idStudent;
            
            $('#st' + selectStudent).css('background-color', '#c2c2d6');  
    
            cleanPager();
            
            $("#header-messages").html("Por favor espere...");
			
			if ($("#ambiente").val() == "Producción")
			{                       
				$.redirect('/sistemasangabriel/students/viewStudent', {idStudent : idStudent}); 
			}
			else
			{
				$.redirect('/desarrollosistemasangabriel/students/viewStudent', {idStudent : idStudent}); 
			}
        });

// Final funciones Jquery
    });    

</script>