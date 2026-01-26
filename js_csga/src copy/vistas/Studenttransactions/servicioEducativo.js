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

                function actualizarUrl() {
                    var periodo = $('#periodo-escolar').val();
                    var filtro = $('#filtro-estudiantes').val();
                    
                    if (periodo) {
                        window.location = rutaServicioEducativo + '/' + periodo + '?filtro_estudiantes=' + filtro;
                    }
                }

                $('#periodo-escolar').on('change', function(event) 
                {
                    actualizarUrl();
                });

                $('#filtro-estudiantes').on('change', function(event)
                {
                    actualizarUrl();
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