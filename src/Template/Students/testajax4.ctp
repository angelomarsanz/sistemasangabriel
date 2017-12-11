<?php
    use Cake\Routing\Router; 
?>
<form id='userForm'>
    <div><input type='text' name='firstname' placeholder='Firstname' /></div>
    <div><input type='text' name='lastname' placeholder='Lastname' /></div>
    <div><input type='text' name='email' placeholder='Email' /></div>
    <div><input type='submit' value='Submit' /></div>
</form>
 
<!-- where the response will be displayed -->
<div id='response'></div>

<script>
$(document).ready(function(){
    $('#userForm').submit(function(){
     
        // show that something is loading
        $('#response').html("<b>Loading response...</b>");
         
        /*
         * 'post_receiver.php' - where you will pass the form data
         * $(this).serialize() - to easily read form data
         * function(data){... - data contains the response from post_receiver.php
         */
        $.ajax({
            type: 'POST',
            url: '<?php echo Router::url(array("controller" => "Students", "action" => "prueba")); ?>', 
            data: $(this).serialize()
        })
        .done(function(data){
             
            // show the response
            $('#response').html(data);
             
        })
        .fail(function() {
         
            // just in case posting your form failed
            alert( "Posting failed." );
             
        });
 
        // to prevent refreshing the whole page page
        return false;
 
    });
});
</script>