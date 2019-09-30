<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Cuotas del estudiante</h2>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="student">Por favor escriba el primer apellido del alumno</label>
                <br />
                <input type="text" class="form-control" id="student">
                <br />
                <p id="header-messages"></p>
                <br />
            </div>
        </div>
    </div>
</div>
<script>    
// Funciones Jquery

    $(document).ready(function() 
    {
        $('#student').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Students", "action" => "findStudent")); ?>',
            minLength: 3,
            select: function( event, ui ) {
				alert("Ángel");
				window.location.href="http://localhost/sistemasangabriel/users/home";
              }
        });
    });    

</script>