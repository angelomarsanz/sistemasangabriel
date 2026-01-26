export const indexCuentasPorCobrar = () => 
{
    (function( $ ) {
        const funcionExternaIndexCuentasPorCobrar = () => {
            console.log('Hola desde la función externa de indexCuentasPorCobrar mejorada (jQuery)');
        }
        $(function() {
            if ($('#indexCuentasPorCobrar').length > 0) 
            {
                console.log('indexCuentasPorCobrar.length', $('#indexCuentasPorCobrar').length)
                funcionExternaIndexCuentasPorCobrar();
            }
        });
    })(jQuery);
}
indexCuentasPorCobrar();