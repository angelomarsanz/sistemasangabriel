// Funciones generales

function crm_processing_modal(msg) 
{
    var process_modal ='<div class="modal fade" id="fave_modal" tabindex="-1" role="dialog" aria-labelledby="faveModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body houzez_messages_modal">'+msg+'</div></div></div></div></div>';
    $('body').append(process_modal);
    $('#fave_modal').modal();
}

function crm_processing_modal_close() 
{
    $('#fave_modal').modal('hide');
}

function ocultarAlertas()
{
    if ($("#alertaSatisfactorio").hasClass("noVerEnPantalla") == false)
    {
        $("#alertaSatisfactorio").addClass("noVerEnPantalla");
    }
    if ($("#alertaAdvertencia").hasClass("noVerEnPantalla") == false)
    {
        $("#alertaAdvertencia").addClass("noVerEnPantalla");
    }
    if ($("#alertaPeligro").hasClass("noVerEnPantalla") == false)
    {
        $("#alertaPeligro").addClass("noVerEnPantalla");
    }
}

function mostrarAlertaSatisfactorio()
{
    if ($("#alertaSatisfactorio").hasClass("noVerEnPantalla") == true)
    {
        $("#alertaSatisfactorio").removeClass("noVerEnPantalla");
    }
}

function mostrarAlertaAdvertencia()
{
    if ($("#alertaAdvertencia").hasClass("noVerEnPantalla") == true)
    {
        $("#alertaAdvertencia").removeClass("noVerEnPantalla");
    }
}

function mostrarAlertaPeligro()
{
    if ($("#alertaPeligro").hasClass("noVerEnPantalla") == true)
    {
        $("#alertaPeligro").removeClass("noVerEnPantalla");
    }
}
$(document).ready(function() 
{
    $(".alertasGenerales").on("click", function()
    {
        ocultarAlertas();
    });
});