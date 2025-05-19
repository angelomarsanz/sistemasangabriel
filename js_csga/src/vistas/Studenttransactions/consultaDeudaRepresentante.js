export const consultaDeudaRepresentante = () => 
{
    (function( $ ) {
        const funcionExternaIndexBills = () => {
            console.log('Hola desde la función externa de indexBills mejorada (jQuery)');
        }
        $(function() {
            if ($('#consulta-deuda-representante').length > 0) 
            {
                console.log('consulta-deuda-representante.length', $('#consulta-deuda-representante').length);
                var rutaPrograma = $('#ruta-programa').text();
                
                $('#estudiante').autocomplete(
                    {
                        source: rutaPrograma,
                        minLength: 3,
                        select: function( event, ui ) {
                            $('#id-estudiante').val(ui.item.id);
                          }
                    });
            }
        });
    })(jQuery);
}
consultaDeudaRepresentante();