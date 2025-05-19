export const addUsers = () => 
{
    (function( $ ) {
        $(function() {
            if ($('#addUsers').length > 0) 
            {
                $("#save-user").on("click", function(e)
                {
                    console.log('addUsers, save-user');
                    $('#first-name').val($('#first-name').val().toUpperCase());
                    $('#second-name').val($('#second-name').val().toUpperCase());
                    $('#surname').val($('#surname').val().toUpperCase());
                    $('#second-surname').val($('#second-surname').val().toUpperCase());
                    $('#email').val($('#email').val().toLowerCase());
                });
            }
        });
    })(jQuery);
}
addUsers();