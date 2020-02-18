<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Becas especiales</h2>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="student">Escriba el primer apellido del alumno</label>
                <br />
                <input type="text" class="form-control" id="student">
                <br />
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#student').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Students", "action" => "findStudent")); ?>',
            minLength: 3,
            select: function( event, ui ) {
				window.location = '<?php echo Router::url(["controller" => "Students", "action" => "aplicarBecaEspecial"]); ?>' + '/' + ui.item.id + '/students/buscar_alumno';
              }
        });
    });    
</script>