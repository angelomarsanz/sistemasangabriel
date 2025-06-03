export const consultaDeudaRepresentante = () => 
{
    (function( $ ) {
        const funcionExternaIndexBills = () => {
            console.log('Hola desde la función externa de indexBills mejorada (jQuery)');
        }
        $(function() {
            if ($('#consulta-deuda-representante').length > 0) 
            {
                console.log('consulta-deuda-representante.length', $('#consulta-deuda-representante').length);
                
                var idUsuario = $('#id-usuario').text(); 
                var rolUsuario = $('#rol-usuario').text(); 
                var rutaBusquedaFamilia = $('#ruta-busqueda-familia').text();
                var rutaBusquedaRepresentante = $('#ruta-busqueda-representante').text();  
                var rutaConsultaDeudaRepresentante = $('#ruta-consulta-deuda-representante').text();                
                var rutaBusquedaEstudiantesRepresentante = $('#ruta-busqueda-estudiantes-representante').text();
                var vectorEstudiantes = JSON.parse($('#vector-estudiantes').text());
                console.log('vectorEstudiantes', vectorEstudiantes);

                $('#familia').autocomplete(
                {
                    source: rutaBusquedaFamilia,
                    minLength: 3,
                    select: function( event, ui ) {
                        window.location = rutaConsultaDeudaRepresentante + '/' + idUsuario + '/' + rolUsuario + '/' + ui.item.id;
                    }
                });
        
                $('#representante').autocomplete(
                {
                    source: rutaBusquedaRepresentante,
                    minLength: 3,
                    select: function( event, ui ) {
                        window.location = rutaConsultaDeudaRepresentante + '/' + idUsuario + '/' + rolUsuario + '/' + ui.item.id;
                    }
                });
                            
                $('#estudiante').autocomplete(
                {
                    source: rutaBusquedaEstudiantesRepresentante,
                    minLength: 3,
                    select: function( event, ui ) {
                        $('#id-estudiante').val(ui.item.id);
                        }
                });

                $('.periodo-escolar').on('change', function(event) {
                    var idInput = $(this).attr('id');
                    var anioInicioPeriodoEscolar = parseInt($(this).val());
                    var finInicioPeriodoEscolar = anioInicioPeriodoEscolar + 1;
                    var vectorId = idInput.split("-");
                    var idEstudiante = parseInt(vectorId[2]);
                    var indicadorAnioEstudiante = 0;
                    for (var i = 0; i < vectorEstudiantes[idEstudiante].anios_estudiante.length; i++) 
                    {
                        if (vectorEstudiantes[idEstudiante].anios_estudiante[i] == anioInicioPeriodoEscolar)
                        {
                            indicadorAnioEstudiante = 1;
                            break;
                        }
                    }
                    if (indicadorAnioEstudiante == 1)
                    {
                        $(`#total-deuda-estudiante-anio-${idEstudiante}`).val(vectorEstudiantes[idEstudiante].anios[anioInicioPeriodoEscolar].total_deuda_estudiante_anio);
                    }
                    else
                    {
                        $(`#total-deuda-estudiante-anio-${idEstudiante}`).val(0);
                        alert(`No existe cuotas del estudiante para el período ${anioInicioPeriodoEscolar}-${finInicioPeriodoEscolar}`);
                    }
                    $(`#indicador-detalle-${idEstudiante}`).val(0);
                    $(`#ver-detalle-${idEstudiante}`).text('Ver detalle');
                    $(`#detalle-cuotas-${idEstudiante}`).html('');
                });

                $('.ver-detalle').on('click', function(event) 
                {
                    var idBotonDetalle = $(this).attr('id');
                    var vectorIdBotonDetalle = idBotonDetalle.split("-");
                    var idEstudianteDetalle = parseInt(vectorIdBotonDetalle[2]);
                    var anioInicioPeriodoEscolarDetalle = parseInt($(`#periodo-escolar-${idEstudianteDetalle}`).val());
                    var anioFinPeriodoEscolarDetalle = anioInicioPeriodoEscolarDetalle + 1;
                    if ($(`#indicador-detalle-${idEstudianteDetalle}`).val() == 0)
                    {
                        if ($(`#cuotas-${idEstudianteDetalle}-${anioInicioPeriodoEscolarDetalle}`).length > 0) 
                        {
                            $(`#indicador-detalle-${idEstudianteDetalle}`).val(1);
                            $(`#ver-detalle-${idEstudianteDetalle}`).text('Ocultar detalle');
                            $(`#detalle-cuotas-${idEstudianteDetalle}`).html($(`#cuotas-${idEstudianteDetalle}-${anioInicioPeriodoEscolarDetalle}`).html());
                        }
                        else
                        {
                            $(`#ver-detalle-${idEstudianteDetalle}`).text('Ver detalle');
                            $(`#indicador-detalle-${idEstudianteDetalle}`).val(0);
                            $(`#detalle-cuotas-${idEstudianteDetalle}`).html('');
                            alert(`No existen cuotas del estudiante para el período escolar ${anioInicioPeriodoEscolarDetalle}-${anioFinPeriodoEscolarDetalle}`);
                        }
                    }
                    else
                    {
                        $(`#ver-detalle-${idEstudianteDetalle}`).text('Ver detalle');
                        $(`#indicador-detalle-${idEstudianteDetalle}`).val(0);
                        $(`#detalle-cuotas-${idEstudianteDetalle}`).html('');
                    }
                });
            }
        });
    })(jQuery);
}
consultaDeudaRepresentante();