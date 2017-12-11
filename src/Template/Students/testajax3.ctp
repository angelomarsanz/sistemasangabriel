<div>
    <button data-user="1">Dame los datos de la persona con ID = 1</button> - <button data-user="[1,2,3]">Dame los datos de las personas con ID = 1, ID = 2 e ID = 3.</button> - <button data-user="0">Ningún usuario</button>
</div>
<div id="response-container"></div>
<script>
    $(document).ready(function() {
    
    // getdeails será nuestra función para enviar la solicitud ajax    
    var getdetails = function(id) {
        
        return $.getJSON('http://localhost/sistemasangabriel/students/search', {
            
            "id": id
            
        });
        
    }
    
    // Al hacer click sobre cualquier elemento que tenga el atributo data-user.....
    $('[data-user]').click(function(e) {
        
        // Detenemos el comportamiento normal del evento click sobre el elemento clicado
        e.preventDefault();
        
        // Mostramos texto de que la solicitud está en curso
        $("#response-container").html("<p>Buscando...</p>");
        
        // this hace referencia al elemento que ha lanzado el evento click
        // con el método .data('user') obtenemos el valor del atributo data-user de dicho elemento y lo pasamos a la función getdetails definida anteriormente
        getdetails( $(this).data('user') )
        
        .done(function(response) {
            
            //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
            if (response.success) {
                
                var output = "<h1>" + response.data.message + "</h1>";
                
                // recorremos cada usuario
                $.each(response.data.users, function(key, value) {
                    
                    output += "<h2>Detalles del usuario " + value['ID'] + "</h2>";
                    
                    // recorremos los valores de cada usuario
                    $.each(value, function(userkey, uservalue) {
                        
                        output += '<ul>';
                        output += '<li>' + userkey + ': ' + uservalue + "</li>";
                        output += '</ul>';
                        
                    });
                    
                });
                
                // Actualizamos el HTML del elemento con id="#response-container"
                $("#response-container").html(output);
                
                } else {
                
                //response.success no es true
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
                
            }
            
        })
        
        .fail(function(jqXHR, textStatus, errorThrown) {
            
            $("#response-container").html("Algo ha fallado: " + textStatus);
            
        });
        
    });
    
});
</script>