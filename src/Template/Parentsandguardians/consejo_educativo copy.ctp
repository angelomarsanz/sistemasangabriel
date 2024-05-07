<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="page-header">
            <h2>Consejo Educativo</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <p>
            Para visualizar los datos de una familia puedes hacer la búsqueda por los apellidos de la "familia" o del "representante" y luego podrás exonerarla del Consejo Educativo o también eliminar la exoneración.
        </p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4">
        <label for="family">Escriba los apellidos que identifican la familia</label>
        <input type="text" class="form-control" id="family">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <label for="guardian">Escriba el primer apellido del representante</label>
        <input type="text" class="form-control" id="guardian">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
    </div>
</div>
<div id="familiaConsejoEducativo" class="noVerEnPantalla row">
    <div id="datosFamilia" class="col-xs-12 col-sm-12 col-md-12">
    </div>
</div>
<br />
<div id="botonesReportes" class="row">
    <div class="col-xs-12 col-sm-12 col-md-4">
        <button type='button' id="familiasExoneradas" class='btn btn-success' style='margin-bottom: 5%;'>Familias exoneradas</button>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <button type='button' id="familiasRelacionadas" class='btn btn-success' style='margin-bottom: 5%;'>Familias relacionadas</button>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <button type='button' id="reporteGeneralConsejoEducativo" class='btn btn-success' style='margin-bottom: 5%;'>Reporte general de Consejo educativo</button>
    </div>
</div>
<?php 
if (isset($reporte))
{
    if ($reporte == "familiasRelacionadas")
    {
        include dirname(__DIR__) . '/Parentsandguardians/partes/reporte_familias_relacionadas.ctp';
    }
} ?> 
<br /><br /><br /><br /><br /><br /><br />
<script>
    // Variables globales
    var urlBase = window.location.hostname; 
    var nombreRuta = window.location.pathname;
    var rutaPagina = window.location.href;
    var idFamilia = 0;
    var reporte = "<?= $reporte ?>";
    
    // Funciones generales
    function datosFamilia()
    {
        crm_processing_modal('Por favor espere mientras se buscan los datos de la familia');
        ocultarAlertas();
        $.post('<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "datosFamilia"]); ?>', 
            {"idFamilia" : idFamilia}, null, "json")          
            .done(function(respuesta) 
            {
                if (respuesta.satisfactorio) 
                {
                    crm_processing_modal_close(); 
                    $("#datosFamilia").html(respuesta.html);
                    if ($("#familiaConsejoEducativo").hasClass("noVerEnPantalla") == true)
                    {
                        $("#familiaConsejoEducativo").removeClass("noVerEnPantalla");
                    }
                } 
                else 
                {
                    crm_processing_modal_close(); 
                    $("#mensajeAlertaPeligro").text(respuesta.mensajeDeError);
                    mostrarAlertaPeligro();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#header-messages").html("Algo ha fallado, los datos fiscales no pudieron ser actualizados: " + textStatus);
            });  
    }
    function editarExoneracion(accion)
    {
        crm_processing_modal('Por favor espere mientras se hacen los cambios');
        ocultarAlertas();
        $.post('<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "editarExoneracion"]); ?>', 
            {"idFamilia" : idFamilia, "accion" : accion}, null, "json")          
            .done(function(respuesta) 
            {
                if (respuesta.satisfactorio) 
                {
                    crm_processing_modal_close(); 
                    $("#mensajeAlertaSatisfactorio").text(respuesta.mensaje);
                    mostrarAlertaSatisfactorio();
                    if (accion == "exonerarFamilia")
                    {
                        $(".exoneracion").removeClass("exonerarFamilia");
                        $(".exoneracion").addClass("eliminarExoneracion");
                        $(".exoneracion").text("Eliminar exoneración");
                    }
                    else
                    {
                        $(".exoneracion").removeClass("eliminarExoneracion");
                        $(".exoneracion").addClass("exonerarFamilia");
                        $(".exoneracion").text("Exonerar");
                    }
                } 
                else 
                {
                    crm_processing_modal_close(); 
                    $("#mensajeAlertaPeligro").text(respuesta.mensaje);
                    mostrarAlertaPeligro();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#header-messages").html("Algo ha fallado, los datos fiscales no pudieron ser actualizados: " + textStatus);
            });  

    }
    $(document).ready(function() 
    {
        $('#family').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                idFamilia = ui.item.id;
			    datosFamilia();
            }
        });
        $('#guardian').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findGuardian")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                idFamilia = ui.item.id;
			    datosFamilia();
            }
        });
        $("#datosFamilia").on("click", ".exonerarFamilia", function()
        {
            editarExoneracion("exonerarFamilia");
        });
        $("#datosFamilia").on("click", ".eliminarExoneracion", function()
        {
            editarExoneracion("eliminarExoneracion");
        });
        $('#familiasRelacionadas').on( 'click', function(event) 
		{
			event.preventDefault();
            crm_processing_modal('Por favor espere mientras se emite el reporte...');
			location.href = rutaPagina+"/familiasRelacionadas";
		});
		$("#exportar-excel").click(function(){
			
            if (reporte == "familiasRelacionadas")
            {
                $("#reporteFamiliasRelacionadas").table2excel({
            
                    exclude: ".noExl",
                
                    name: "reporteFamiliasRelacionadas",
                
                    filename: $('#reporteFamiliasRelacionadas').attr('name') 
            
                });
            }
		});
    });    
</script>