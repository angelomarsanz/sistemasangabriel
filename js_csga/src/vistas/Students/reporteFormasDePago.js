// La constante principal ahora utiliza "formas" en plural
export const reporteFormasDePago = () => 
{
    (function( $ ) {
        
        $(function() {
            // Se actualizó el ID para el elemento contenedor principal
            if ($('#reporte-formas-de-pago').length > 0) 
            {
                // Funciones para los modales de notificación
                const createModal = (title, body, footer, isDismissible = true) => {
                    const modalHtml = `
                        <div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="customAlertModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customAlertModalLabel">${title}</h5>
                                        ${isDismissible ? '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' : ''}
                                    </div>
                                    <div class="modal-body">
                                        ${body}
                                    </div>
                                    ${footer ? `<div class="modal-footer">${footer}</div>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                    // Eliminar cualquier modal existente y añadir el nuevo
                    $('#customAlertModal').remove();
                    $('body').append(modalHtml);

                    const modal = $('#customAlertModal');
                    // Agregamos un evento para eliminar el backdrop cuando el modal se oculte
                    modal.on('hidden.bs.modal', function () {
                        $('.modal-backdrop').remove();
                    });
                    
                    return modal;
                };

                const showLoading = (message = 'Por favor, espere...') => {
                    const loadingBody = `
                        <div class="text-center">
                            <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                <style>
                                    @keyframes spin {
                                        to { transform: rotate(360deg); }
                                    }
                                    .spinner {
                                        animation: spin 1s linear infinite;
                                        transform-origin: center;
                                        stroke: #007bff;
                                        stroke-width: 4;
                                        fill: none;
                                    }
                                </style>
                                <circle class="spinner" cx="20" cy="20" r="18" stroke-dasharray="80" />
                            </svg>
                            <h4 style="margin-top: 15px;">${message}</h4>
                        </div>
                    `;
                    const loadingModal = createModal('Cargando...', loadingBody, null, false);
                    loadingModal.modal('show');
                };

                const hideLoading = () => {
                    $('#customAlertModal').modal('hide');
                };

                const showAlertModal = (title, message, isError = false) => {
                    const icon = isError 
                        ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-danger" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .964.448.964 1v3.504c0 .584-.448.964-.964.964s-.964-.448-.964-.964V6c0-.552.429-1 .964-1zm0 7.5a.964.964 0 1 1 0-1.928.964.964 0 0 1 0 1.928z"/>
                           </svg>`
                        : `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                           </svg>`;
                    
                    const modalBody = `
                        <div class="text-center">
                            ${icon}
                            <h4 class="mt-2">${message}</h4>
                        </div>
                    `;
                    const modalFooter = `<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
                    const alertModal = createModal(title, modalBody, modalFooter);
                    alertModal.modal('show');
                };

                // Función para renderizar dinámicamente el formulario de filtros
                const renderFilterForm = () => {
                    const currentYear = new Date().getFullYear();
                    let yearOptionsHtml = '';
                    for (let i = 0; i < 5; i++) {
                        const year = currentYear - i;
                        const isSelected = (i === 0) ? 'selected' : '';
                        yearOptionsHtml += `<option value="${year}" ${isSelected}>${year}</option>`;
                    }

                    const formHtml = `
                        <style>
                            .reporte-panel-body {
                                padding: 20px;
                            }
                            .reporte-column-spacing {
                                padding-left: 15px; /* Restaurado el padding original para las columnas principales */
                                padding-right: 15px;
                            }
                            .year-select-width {
                                width: 100px;
                            }
                            .meses-padding .row {
                                margin-left: -5px; /* Ajuste para el margen de las filas de los meses */
                                margin-right: -5px;
                            }
                            .meses-padding .col-xs-2 {
                                padding-left: 5px; /* Ajuste del padding para los meses */
                                padding-right: 5px;
                            }
                        </style>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title">Filtros para el reporte de formas de pago</h4>
                                <span>Estudiantes regulares</span>
                            </div>
                            <div class="panel-body reporte-panel-body">
                                <form id="reporte-filtros-form">
                                    <div class="row">
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Tipo de documento:</label>
                                                <div class="radio">
                                                    <label><input type="radio" name="documentType" value="facturas" checked> Facturas</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="documentType" value="pedidos"> Pedidos</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Tipo de persona:</label>
                                                <div class="radio">
                                                    <label><input type="radio" name="personType" value="juridica" checked> Persona jurídica</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="personType" value="natural"> Persona natural</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="personType" value="ambas"> Persona jurídica y natural</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Formas de pago:</label>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="efectivo_dolar"> Efectivo $</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="efectivo_euro"> Efectivo €</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="efectivo_bolivar"> Efectivo Bs.</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="punto_venta"> Punto de venta</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="zelle"> Zelle</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="euros_transf"> Euros (transf.)</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="transferencia_bs"> Transferencia Bs.</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="paymentForms[]" value="todas" id="todas-las-formas-de-pago-checkbox"> Todas las formas de pago</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Mes y año en que se emitió la factura o pedido:</label>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="months[]" value="all" id="todos-los-meses-checkbox"> Todos</label>
                                                </div>
                                                <div class="meses-padding">
                                                    <div class="row">
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="01" class="month-checkbox"> Ene</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="02" class="month-checkbox"> Feb</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="03" class="month-checkbox"> Mar</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="04" class="month-checkbox"> Abr</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="05" class="month-checkbox"> May</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="06" class="month-checkbox"> Jun</label></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="07" class="month-checkbox"> Jul</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="08" class="month-checkbox"> Ago</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="09" class="month-checkbox"> Sep</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="10" class="month-checkbox"> Oct</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="11" class="month-checkbox"> Nov</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="12" class="month-checkbox"> Dic</label></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control year-select-width" id="year-select" name="year">
                                                    ${yearOptionsHtml}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Ordenado por:</label>
                                                <div class="radio">
                                                    <label><input type="radio" name="orderBy" value="familia_agrupado" checked> Familia (agrupado)</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="orderBy" value="familia"> Familia</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="orderBy" value="factura"> Factura</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="aplicar-filtros-btn">Aplicar Filtros</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    `;
                    $('#formulario-formas-de-pago').html(formHtml);
                };
                
                // Función auxiliar para formatear números con separador de miles
                const formatNumber = (number) => {
                    return new Intl.NumberFormat('es-ES', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(number);
                };

                // Función auxiliar para formatear la lista de estudiantes
                const formatStudents = (studentsArray) => {
                    if (studentsArray.length === 0) {
                        return '';
                    }
                    if (studentsArray.length === 1) {
                        return studentsArray[0];
                    }
                    const lastStudent = studentsArray.pop();
                    return studentsArray.join(', ') + ' Y ' + lastStudent;
                };

                const renderReport = (reportData, filters, totals, cantidad) => {
                    let tableHtml = `
                        <style>
                            .report-table-header {
                                font-weight: bold;
                                background-color: #f2f2f2;
                            }
                            @media print {
                                .noVerEnPantalla {
                                    display: none;
                                }
                            }
                            @media screen {
                                .noVerImpreso {
                                    display: none;
                                }
                            }
                        </style>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Reporte de Formas de Pago</h4>
                                <div class="report-info">
                                    <p><strong>Tipo de Documento:</strong> ${filters.documentType === 'facturas' ? 'Facturas' : 'Pedidos'}</p>
                                    <p><strong>Tipo de Persona:</strong> ${filters.personType === 'juridica' ? 'Persona Jurídica' : (filters.personType === 'natural' ? 'Persona Natural' : 'Persona Jurídica y Natural')}</p>
                                    <p><strong>Formas de Pago:</strong> ${filters.paymentForms.includes('todas') ? 'Todas' : filters.paymentForms.join(', ')}</p>
                                    <p><strong>Periodo:</strong> Año ${filters.year} - Meses: ${filters.months.includes('all') ? 'Todos' : filters.months.join(', ')}</p>
                                    <p><strong>Ordenado por:</strong> ${
                                        filters.orderBy === 'familia' 
                                            ? 'Familia' 
                                            : filters.orderBy === 'familia_agrupado'
                                                ? 'Familia (agrupado)'
                                                : 'Factura'
                                    }</p>
                                </div>
                            </div>
                            <div class="panel-body">
                                <h5>Resumen de Totales</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Cantidad de operaciones</strong></td>
                                            <td>${cantidad}</td>
                                        </tr>
                                        ${Object.keys(totals).map(key => {
                                            // Se modifica esta condición para excluir 'totalGeneral'
                                            if (key !== 'totalGeneral') {
                                                return `<tr><td><strong>Total monto por ${key}</strong></td><td>${formatNumber(totals[key])}</td></tr>`;
                                            }
                                        }).join('')}
                                    </tbody>
                                </table>
                                <hr>
                                <h5>Detalle del Reporte</h5>
                                <table class="table table-striped table-bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Nro.</th>
                                            ${filters.orderBy === 'familia_agrupado'
                                                ? `
                                                    <th>Familia</th>
                                                    <th>Estudiantes</th>
                                                    <th>Cédula/RIF</th>
                                                    <th>Nombre/Razón Social</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Monto</th>
                                                  `
                                                : filters.orderBy === 'familia' 
                                                ? `
                                                    <th>Familia</th>
                                                    <th>Estudiantes</th>
                                                    <th>Nro. Factura/Control</th>
                                                    <th>Cédula/RIF</th>
                                                    <th>Nombre/Razón Social</th>
                                                    <th>Fecha Factura</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Monto</th>
                                                  `
                                                : `
                                                    <th>Nro. Factura/Control</th>
                                                    <th>Familia</th>
                                                    <th>Estudiantes</th>
                                                    <th>Cédula/RIF</th>
                                                    <th>Nombre/Razón Social</th>
                                                    <th>Fecha Factura</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Monto</th>
                                                  `
                                            }
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${reportData.map((item, index) => `
                                            <tr>
                                                <td>${index + 1}</td>
                                                ${filters.orderBy === 'familia_agrupado'
                                                    ? `
                                                        <td>${item.familia}</td>
                                                        <td>${formatStudents(item.students)}</td>
                                                        <td>${item.cedulaRif}</td>
                                                        <td>${item.razonSocial}</td>
                                                        <td>${item.formaPago}</td>
                                                        <td>${formatNumber(item.monto)}</td>
                                                      `
                                                    
                                                    : filters.orderBy === 'familia' 
                                                    ? `
                                                        <td>${item.familia}</td>
                                                        <td>${formatStudents(item.students)}</td>
                                                        <td>${item.facturaControl}</td>
                                                        <td>${item.cedulaRif}</td>
                                                        <td>${item.razonSocial}</td>
                                                        <td>${item.fechaFactura}</td>
                                                        <td>${item.formaPago}</td>
                                                        <td>${formatNumber(item.monto)}</td>
                                                      `
                                                    : `
                                                        <td>${item.facturaControl}</td>
                                                        <td>${item.familia}</td>
                                                        <td>${formatStudents(item.students)}</td>
                                                        <td>${item.cedulaRif}</td>
                                                        <td>${item.razonSocial}</td>
                                                        <td>${item.fechaFactura}</td>
                                                        <td>${item.formaPago}</td>
                                                        <td>${formatNumber(item.monto)}</td>
                                                      `
                                                }
                                            </tr>
                                        `).join('')}
                                        ${reportData.length === 0 ? `<tr><td colspan="${filters.orderBy === 'familia_agrupado' ? 7 : 9}" class="text-center">No se encontraron datos para los filtros seleccionados.</td></tr>` : ''}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    $('#reporte-formas-de-pago').html(tableHtml);
                };
                
                const fetchReportData = () => {
                    const selectedFilters = {
                        documentType: $('input[name="documentType"]:checked').val(),
                        personType: $('input[name="personType"]:checked').val(),
                        orderBy: $('input[name="orderBy"]:checked').val(),
                        year: $('#year-select').val(),
                        paymentForms: [],
                        months: []
                    };
                    
                    $('input[name="paymentForms[]"]:checked').each(function() {
                        selectedFilters.paymentForms.push($(this).val());
                    });
                    
                    $('input[name="months[]"]:checked').each(function() {
                        selectedFilters.months.push($(this).val());
                    });
                    
                    if (selectedFilters.paymentForms.length === 0) {
                        showAlertModal('Error de Validación', "Debes seleccionar al menos una forma de pago.", true);
                        return;
                    }

                    if (!selectedFilters.months.includes('all') && selectedFilters.months.length === 0) {
                        showAlertModal('Error de Validación', "Debes seleccionar al menos un mes o la opción 'Todos'.", true);
                        return;
                    }
                    
                    showLoading('Cargando reporte...');
                    
                    const reportUrl = $('#ruta-datos-reporte-formas-de-pago').text();

                    $.ajax({
                        url: reportUrl,
                        type: 'POST',
                        data: selectedFilters,
                        dataType: 'json',
                        success: function(response) {
                            console.log('response', response);
                            hideLoading();
                            if (response.success) {
                                renderReport(
                                    response.data.details,
                                    response.data.filters,
                                    response.data.totals,
                                    response.data.cantidad
                                );
                                showAlertModal('Reporte Generado', "El reporte se ha generado correctamente.", false);
                            } else {
                                console.error('Error al obtener el reporte:', response.message);
                                showAlertModal('Error', 'Ocurrió un error al generar el reporte. Por favor, inténtalo de nuevo más tarde.', true);
                                renderReport([], {}, {}, 0);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            hideLoading();
                            console.error('Error en la llamada AJAX:', textStatus, errorThrown);
                            showAlertModal('Error de conexión', 'No se pudo conectar con el servidor. Verifica tu conexión y vuelve a intentarlo.', true);
                            renderReport([], {}, {}, 0);
                        }
                    });
                };
        
                // Lógica principal
                renderFilterForm();

                // Manejadores de eventos
                $(document).on('click', '#aplicar-filtros-btn', function() {
                    fetchReportData();
                });
                
                $(document).on('change', 'input[name="paymentForms[]"]', function() {
                    const todasLasFormasDePagoCheckbox = $('#todas-las-formas-de-pago-checkbox');
                    if ($(this).attr('id') === 'todas-las-formas-de-pago-checkbox' && $(this).is(':checked')) {
                        $('input[name="paymentForms[]"]').not(this).prop('checked', false);
                    } else if ($(this).attr('id') !== 'todas-las-formas-de-pago-checkbox' && $(this).is(':checked')) {
                        todasLasFormasDePagoCheckbox.prop('checked', false);
                    }
                });

                // --- Lógica Corregida para los meses ---
                $(document).on('change', 'input[name="months[]"]', function() {
                    const todosLosMesesCheckbox = $('#todos-los-meses-checkbox');
                    const mesesIndividualesCheckboxes = $('input[name="months[]"]').not(todosLosMesesCheckbox);
                    
                    // Si se hace clic en "Todos", desmarca los demás
                    if ($(this).attr('id') === 'todos-los-meses-checkbox' && $(this).is(':checked')) {
                        mesesIndividualesCheckboxes.prop('checked', false);
                    }
                    // Si se hace clic en cualquier otro mes, desmarca "Todos"
                    else if ($(this).attr('id') !== 'todos-los-meses-checkbox' && $(this).is(':checked')) {
                        todosLosMesesCheckbox.prop('checked', false);
                    }
                });

            }
        });

    })(jQuery);
};
reporteFormasDePago();