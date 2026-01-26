export const indexProveedors = () => 
{
    (function( $ ) {
        const funcionExternaIndexBills = () => {
            console.log('Hola desde la función externa de indexProveedors mejorada (jQuery)');
        }
        $(function() {
            if ($('#indexProveedors').length > 0) 
            {
                console.log('indexProveedors.length', $('#indexProveedors').length)
                $("#indexProveedors").on("click", function()
                {
                    funcionExternaIndexBills();
                });        
            }
        });
    })(jQuery);
}
indexProveedors();