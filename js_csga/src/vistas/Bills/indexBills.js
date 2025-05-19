export const indexBills = () => 
{
    (function( $ ) {
        const funcionExternaIndexBills = () => {
            console.log('Hola desde la función externa de indexBills mejorada (jQuery)');
        }
        $(function() {
            if ($('#indexBills').length > 0) 
            {
                console.log('indexBills.length', $('#indexBills').length)
                $("#familia").on("click", function()
                {
                    funcionExternaIndexBills();
                });        
            }
        });
    })(jQuery);
}
indexBills();