export const indexProductos = () => 
{
    (function( $ ) {
        const funcionExternaIndexProductos = () => {
            console.log('Hola desde la función externa de indexProductos mejorada (jQuery)');
        }
        $(function() {
            if ($('#indexProductos').length > 0) 
            {
                console.log('indexProductos.length', $('#indexProductos').length)
                $("#indexProductos").on("click", function()
                {
                    funcionExternaIndexProductos();
                });        
            }
        });
    })(jQuery);
}
indexProductos();