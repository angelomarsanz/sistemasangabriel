<div>
    <p>testComunicationSend</p>
</div>
<script>
    $.post('http://138.186.179.63/sistemasangabriel/teachingareas/testComunicationReceives', {"descriptionTeachingArea" : 'Arte' }, null, "json")
            
    .done(function(response) 
    {
        if (response.success) 
        {
            alert('El área de enseñanza se creo exitosamente');
        } 
        else 
        {
            alert('No se pudo crear el área de enseñanza');
        }
            
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
            
        alert('Falló la comunicación');
        
    });
</script>