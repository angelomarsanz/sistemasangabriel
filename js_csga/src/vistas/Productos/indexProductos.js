export const indexProductos = () => 
{
    (function( $ ) {
        const funcionExternaIndexProductos = () => {
            console.log('Hiciste clic en una card de producto');
        }
        $(function() {
            if ($('#indexProductos').length > 0) 
            {
                console.log('indexProductos.length', $('#indexProductos').length)
                $("#indexProductos").on("click", ".panel", function() 
                {
                    funcionExternaIndexProductos();
                });   
                console.log('Módulo de productos cargado correctamente.');     
            }
        });
    })(jQuery);
}
indexProductos();