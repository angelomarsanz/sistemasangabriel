export const indexUsers = () => 
{
    (function( $ ) {
        const funcionExternaIndexUsers = () => {
            console.log('Hola desde la función externa de indexUsers mejorada (jQuery)');
        }
        $(function() {
            if ($('#indexUsers').length > 0) 
            {
                console.log('indexUsers.length', $('#indexUsers').length)
                funcionExternaIndexUsers();
            }
        });
    })(jQuery);
}
indexUsers();