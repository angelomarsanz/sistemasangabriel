export const servicioEducativo = () => 
{
    (function( $ ) {
        function funcionExternaServicioEducativo () 
        {
            console.log('Hola desde la función externa de Servicio Educativo');
        }
        $(function() {
            if ($('#servicio-educativo').length > 0) 
            {
                console.log('servicio-educativo.length', $('#servicio-educativo').length);
                var rutaServicioEducativo = $('#ruta-servicio-educativo').text();
                var rutaBusquedaFamilia = $('#ruta-busqueda-familia').text();

                $('#periodo-escolar').on('change', function(event) 
                {
                    window.location = rutaServicioEducativo + '/' + $('#periodo-escolar').val();
                });

                $('#familia').autocomplete(
                {
                    source: rutaBusquedaFamilia,
                    minLength: 3,
                    select: function( event, ui ) {
                        window.location = rutaServicioEducativo + '/' + null + '/' + ui.item.id;
                    }
                });
            }
        });
    })(jQuery);
}
servicioEducativo();