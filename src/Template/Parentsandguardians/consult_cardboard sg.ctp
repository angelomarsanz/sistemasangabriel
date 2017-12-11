<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Buscar familia para imprimir cartón de pagos de cuotas</h2>
            <p>Puede buscar por el apellido del padre o el apellido de la madre, como usted prefiera...</p>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="family">Escriba el primer apellido del padre</label>
                <br />
                <input type="text" class="form-control" id="family-father">
                <br />
                <label for="family">Escriba el primer apellido de la madre</label>
                <br />
                <input type="text" class="form-control" id="family-mother">
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
    var selectFamily = -1;
    
// Funciones

    function log(message) 
    {
        cleanPager();
        $("#response-container").html(message);
    }

    function cleanPager()
    {
        $('#family-father').val(" ");
        $('#family-mother').val(" ");
        $("#response-container").html("");
    }
    
// Funciones Jquery

    var family = "";

    $(document).ready(function() 
    {
        $('#family-father').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + "</td></tr>");
                family = ui.item.value;
              }
        });

        $('#family-mother').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamilyMother")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + "</td></tr>");
                family = ui.item.value;
              }
        });

        $("#response-container").on("click", ".family", function()
        {
            idFamily = $(this).attr('id').substring(2);

            if (selectFamily > -1)
            {
                $('#fa' + selectFamily).css('background-color', 'white');
            }
            
            selectFamily = idFamily;
            
            $('#fa' + selectFamily).css('background-color', '#c2c2d6');  
    
            cleanPager();
            
            $("#header-messages").html("Por favor espere...");
                       
            $.redirect('/sistemasangabriel/students/previousCardboard', {idFamily : idFamily, family: family}); 

        });

// Final funciones Jquery
    });    

</script>