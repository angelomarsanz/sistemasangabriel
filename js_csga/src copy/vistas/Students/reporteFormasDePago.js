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

                const hideLoading = (callback) => {
                    const modal = $('#customAlertModal');
                    // Verificar si el modal existe y está visible
                    if (modal.length && modal.data('bs.modal') && modal.data('bs.modal').isShown) {
                        // Usar .one() para que el evento se ejecute solo una vez y se elimine automáticamente
                        modal.one('hidden.bs.modal', function () {
                            if (callback && typeof callback === 'function') {
                                callback();
                            }
                        }).modal('hide');
                    } else if (callback && typeof callback === 'a function') {
                        // Si no hay modal o ya está oculto, ejecutar el callback inmediatamente
                        callback();
                    }
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
                    // Dentro de la función donde generas el HTML dinámico en reporteFormasDePago.js
                    const today = new Date();
                    const currentMonthForYear = today.getMonth() + 1; // Enero es 1
                    const currentYearCalendar = today.getFullYear();

                    // Si estamos de Septiembre (9) en adelante, el periodo escolar empezó este año.
                    // Si estamos entre Enero y Agosto, el periodo empezó el año pasado.
                    let baseYear = (currentMonthForYear >= 9) ? currentYearCalendar : currentYearCalendar - 1;

                    let yearOptionsHtml = '';
                    // Generamos los últimos 5 períodos escolares
                    for (let i = 0; i < 5; i++) {
                        let yearStart = baseYear - i;
                        let yearEnd = yearStart + 1;
                        // El primero de la lista (el más reciente) queda seleccionado por defecto
                        let selected = (i === 0) ? 'selected' : '';
                        yearOptionsHtml += `<option value="${yearStart}" ${selected}>${yearStart}-${yearEnd}</option>`;
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
                            #contadores-section .form-group {
                                margin-bottom: 0; /* Reduce el espacio debajo de los contadores */
                            }
                            #contadores-section fieldset[disabled] .checkbox label {
                                cursor: not-allowed; /* Cambia el cursor cuando está deshabilitado */
                            }
                        </style>
                        <div class="panel panel-info noVerImpreso">
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
                                                <label>Período en que se emitió la factura o pedido:</label>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="months[]" value="all" id="todos-los-meses-checkbox"> Todos los meses del período</label>
                                                </div>
                                                <div class="meses-padding">
                                                    <div class="row">
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="09" class="month-checkbox"> Sep</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="10" class="month-checkbox"> Oct</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="11" class="month-checkbox"> Nov</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="12" class="month-checkbox"> Dic</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="01" class="month-checkbox"> Ene</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="02" class="month-checkbox"> Feb</label></div>
                                                    </div>
                                                    <div class="row" style="margin-top: 10px;">
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="03" class="month-checkbox"> Mar</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="04" class="month-checkbox"> Abr</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="05" class="month-checkbox"> May</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="06" class="month-checkbox"> Jun</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="07" class="month-checkbox"> Jul</label></div>
                                                        <div class="col-xs-2"><label class="checkbox-inline"><input type="checkbox" name="months[]" value="08" class="month-checkbox"> Ago</label></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-top: 20px;">
                                                <label for="year-select">Período escolar:</label>
                                                <select class="form-control" id="year-select" name="year" style="width: auto; min-width: 150px; display: block;">
                                                    ${yearOptionsHtml}
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div class="form-group">
                                                <label>Condición del estudiante:</label>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="studentConditions[]" value="Regular" checked> Regulares</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="studentConditions[]" value="Egresado"> Egresados</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="studentConditions[]" value="Otros"> Otros</label>
                                                </div>
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 reporte-column-spacing">
                                            <div id="contadores-section">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Agregar contadores:</label>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" name="countFamily" value="1"> Familia</label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" name="countStudents" value="1"> Estudiantes</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 reporte-column-spacing text-center" style="padding-top: 25px;">
                                            <button type="button" class="btn btn-primary btn-lg" id="aplicar-filtros-btn">Aplicar Filtros</button>
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

                const renderReport = (reportData, filters, totals) => {
                    let tableHtml = `
                        <style>
                            .report-table-header {
                                font-weight: bold;
                                background-color: #f2f2f2;
                            }
                        </style>
                        <div name="reporte_formas_de_pago_generado" id="reporte-formas-de-pago-generado" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Reporte de Formas de Pago</h4>
                                <div class="report-info">
                                    <p><strong>Tipo de Documento:</strong> ${filters.documentType === 'facturas' ? 'Facturas' : 'Pedidos'}</p>
                                    <p><strong>Tipo de Alumnos:</strong> ${(filters.studentConditions || []).map(c => c === 'Otros' ? 'Otros' : c + 's').join(', ')}</p>
                                    <p><strong>Tipo de Persona:</strong> ${filters.personType === 'juridica' ? 'Persona Jurídica' : (filters.personType === 'natural' ? 'Persona Natural' : 'Ambas')}</p>
                                    <p><strong>Formas de Pago:</strong> ${(filters.paymentForms && filters.paymentForms.includes('todas')) ? 'Todas' : (filters.paymentForms || []).join(', ')}</p>
                                    <p><strong>Periodo:</strong> Año ${filters.year} - Meses: ${(filters.months && filters.months.includes('all')) ? 'Todos' : (filters.months || []).join(', ')}</p>
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
                                            <td><strong>Cantidad de ${filters.orderBy === 'familia_agrupado' ? 'familias' : 'operaciones'}</strong></td>
                                            <td>${totals.cantidadOperaciones || 0}</td>
                                        </tr>
                                        ${ (filters.orderBy !== 'familia_agrupado') ? `
                                        <tr>
                                            <td><strong>Total Familias</strong></td>
                                            <td>${totals.totalFamilies || 0}</td>
                                        </tr>` : '' }
                                        <tr>
                                            <td><strong>Total Estudiantes</strong></td>
                                            <td>${totals.totalStudents || 0}</td>
                                        </tr>
                                        ${Object.keys(totals).map(key => {
                                            // Excluir los totales que no son de montos de pago
                                            if (!['totalGeneral', 'totalFamilies', 'totalStudents', 'cantidadOperaciones'].includes(key)) {
                                                return `<tr><td><strong>Total monto por ${key}</strong></td><td>${formatNumber(totals[key] || 0)}</td></tr>`;
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
                                            ${filters.countFamily ? '<th>Cont. Fam.</th>' : ''}
                                            ${filters.orderBy === 'familia_agrupado'
                                                ? `
                                                    <th>Familia</th>
                                                    <th>Estudiantes</th>
                                                    ${filters.countStudents ? '<th>Cont. Estud.</th>' : ''}
                                                    <th>Cédula/RIF</th>
                                                    <th>Nombre/Razón Social</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Monto</th>
                                                  `
                                                : filters.orderBy === 'familia' 
                                                ? `
                                                    <th>Familia</th>
                                                    <th>Estudiantes</th>
                                                    ${filters.countStudents ? '<th>Cont. Estud.</th>' : ''}
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
                                                    ${filters.countStudents ? '<th>Cont. Estud.</th>' : ''}
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
                                                ${filters.countFamily ? `<td>${item.familyCount || ''}</td>` : ''}
                                                ${filters.orderBy === 'familia_agrupado'
                                                    ? `
                                                        <td>${item.familia}</td>
                                                        <td>${formatStudents(item.students)}</td>
                                                        ${filters.countStudents ? `<td>${item.studentCount || ''}</td>` : ''}
                                                        <td>${item.cedulaRif}</td>
                                                        <td>${item.razonSocial}</td>
                                                        <td>${item.formaPago}</td>
                                                        <td>${formatNumber(item.monto)}</td>
                                                      `
                                                    
                                                    : filters.orderBy === 'familia' 
                                                    ? `
                                                        <td>${item.familia}</td>
                                                        <td>${formatStudents(item.students)}</td>
                                                        ${filters.countStudents ? `<td>${item.studentCount || ''}</td>` : ''}
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
                                                        ${filters.countStudents ? `<td>${item.studentCount || ''}</td>` : ''}
                                                        <td>${item.cedulaRif}</td>
                                                        <td>${item.razonSocial}</td>
                                                        <td>${item.fechaFactura}</td>
                                                        <td>${item.formaPago}</td>
                                                        <td>${formatNumber(item.monto)}</td>
                                                      `
                                                }
                                            </tr>
                                        `).join('')}
                                        ${reportData.length === 0 ? `<tr><td colspan="${
                                            (filters.orderBy === 'familia_agrupado' ? 7 : 9) 
                                            + (filters.countFamily ? 1 : 0) 
                                            + (filters.countStudents ? 1 : 0)
                                        }" class="text-center">No se encontraron datos para los filtros seleccionados.</td></tr>` : ''}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    $('#reporte-formas-de-pago').html(tableHtml);
                };
                
                const exportToExcel = () => {
                    if (typeof XLSX === 'undefined') {
                        showAlertModal('Error', 'La librería de exportación (SheetJS) no está cargada.', true);
                        return;
                    }

                    const reportContainer = $('#reporte-formas-de-pago-generado');
                    if (reportContainer.length === 0) {
                        showAlertModal('Información', 'No hay reporte generado para exportar.', false);
                        return;
                    }

                    const wb = XLSX.utils.book_new();
                    const ws_data = [];

                    // 1. Título del reporte
                    ws_data.push(['Reporte de Formas de Pago']);
                    ws_data.push([]); // Fila vacía

                    // 2. Información de filtros
                    const reportInfo = reportContainer.find('.report-info p');
                    reportInfo.each(function() {
                        const strongText = $(this).find('strong').text();
                        const fullText = $(this).text();
                        const valueText = fullText.replace(strongText, '').trim();
                        ws_data.push([strongText, valueText]);
                    });
                    ws_data.push([]); // Fila vacía

                    // 3. Resumen de Totales
                    ws_data.push(['Resumen de Totales']);
                    // Se hace el selector más específico para no incluir la tabla de detalles
                    const totalsTable = reportContainer.find('.table-bordered:not(.table-striped)');
                    totalsTable.find('tr').each(function() {
                        const rowData = [];
                        $(this).find('td').each(function() {
                            rowData.push($(this).text().trim());
                        });
                        ws_data.push(rowData);
                    });
                    ws_data.push([]); // Fila vacía

                    // 4. Detalle del Reporte
                    ws_data.push(['Detalle del Reporte']);
                    const detailsTable = reportContainer.find('.table-striped');
                    const headerData = [];
                    detailsTable.find('thead th').each(function() {
                        headerData.push($(this).text().trim());
                    });
                    ws_data.push(headerData);

                    detailsTable.find('tbody tr').each(function() {
                        const rowData = [];
                        $(this).find('td').each(function() {
                            // Si la celda contiene un número, lo convertimos para que Excel lo reconozca como tal
                            const text = $(this).text().trim();
                            const number = parseFloat(text.replace(/\./g, '').replace(',', '.'));
                            if (!isNaN(number) && text.includes(',')) { // Heurística para detectar números formateados
                                rowData.push(number);
                            } else {
                                rowData.push(text);
                            }
                        });
                        ws_data.push(rowData);
                    });

                    const ws = XLSX.utils.aoa_to_sheet(ws_data);

                    // 5. Unir celdas y definir anchos de columna
                    const merges = [
                        { s: { r: 0, c: 0 }, e: { r: 0, c: 4 } } // Título
                    ];
                    ws['!merges'] = merges;

                    // Ajustar anchos de columna (valores aproximados, puedes ajustarlos)
                    const colWidths = [
                        { wch: 5 },   // Nro.
                        { wch: 30 },  // Familia / Nro. Factura
                        { wch: 40 },  // Estudiantes
                        { wch: 15 },  // Cédula/RIF
                        { wch: 40 },  // Nombre/Razón Social
                        { wch: 15 },  // Fecha / Forma de Pago
                        { wch: 20 },  // Forma de Pago / Monto
                        { wch: 15 },  // Monto
                        { wch: 15 }   // Columna extra por si acaso
                    ];
                    ws['!cols'] = colWidths;

                    // Formato para celdas de montos
                    detailsTable.find('tbody tr').each(function(rowIndex) {
                        $(this).find('td').each(function(colIndex) {
                            const text = $(this).text().trim();
                            const isNumeric = !isNaN(parseFloat(text.replace(/\./g, '').replace(',', '.'))) && text.includes(',');
                            if (isNumeric) {
                                const cellAddress = XLSX.utils.encode_cell({r: ws_data.length - detailsTable.find('tbody tr').length + rowIndex, c: colIndex});
                                if(ws[cellAddress]) {
                                    ws[cellAddress].z = '#,##0.00'; // Formato de número con 2 decimales
                                }
                            }
                        });
                    });

                    XLSX.utils.book_append_sheet(wb, ws, 'Reporte Formas de Pago');

                    // 6. Generar y descargar el archivo
                    XLSX.writeFile(wb, 'Reporte_Formas_de_Pago.xlsx');
                };

                const fetchReportData = () => {
                    const selectedFilters = {
                        documentType: $('input[name="documentType"]:checked').val(),
                        personType: $('input[name="personType"]:checked').val(),
                        orderBy: $('input[name="orderBy"]:checked').val(),
                        year: $('#year-select').val(),
                        paymentForms: [],
                        months: [],
                        studentConditions: [],
                        countFamily: $('input[name="countFamily"]:checked').val() === '1',
                        countStudents: $('input[name="countStudents"]:checked').val() === '1'
                    };
                    
                    $('input[name="paymentForms[]"]:checked').each(function() {
                        selectedFilters.paymentForms.push($(this).val());
                    });
                    
                    $('input[name="months[]"]:checked').each(function() {
                        selectedFilters.months.push($(this).val());
                    });

                    $('input[name="studentConditions[]"]:checked').each(function() {
                        selectedFilters.studentConditions.push($(this).val());
                    });
                    
                    if (selectedFilters.paymentForms.length === 0) {
                        showAlertModal('Error de Validación', "Debes seleccionar al menos una forma de pago.", true);
                        return;
                    }

                    if (!selectedFilters.months.includes('all') && selectedFilters.months.length === 0) {
                        showAlertModal('Error de Validación', "Debes seleccionar al menos un mes o la opción 'Todos'.", true);
                        return;
                    }

                    if (selectedFilters.studentConditions.length === 0) {
                        showAlertModal('Error de Validación', "Debes seleccionar al menos una condición de estudiante.", true);
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
                            // Esperar a que el modal de "cargando" se oculte antes de mostrar el siguiente
                            hideLoading(function() {
                                if (response.success) {
                                    renderReport(
                                        response.data.details,
                                        response.data.filters,
                                        response.data.totals
                                    );
                                    showAlertModal('Reporte Generado', "El reporte se ha generado correctamente.", false);
                                } else {
                                    console.error('Error al obtener el reporte:', response.message);
                                    showAlertModal('Error', response.message || 'Ocurrió un error al generar el reporte. Por favor, inténtalo de nuevo más tarde.', true);
                                    renderReport([], {}, {}, 0);
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            hideLoading(function() {
                                console.error('Error en la llamada AJAX:', textStatus, errorThrown);
                                showAlertModal('Error de conexión', 'No se pudo conectar con el servidor. Verifica tu conexión y vuelve a intentarlo.', true);
                                renderReport([], {}, {}, 0);
                            });
                        }
                    });
                };
        
                // Lógica principal
                renderFilterForm();
                // Inicializar el estado de los contadores
                $('#contadores-section fieldset').prop('disabled', false);

                $(document).on('change', 'input[name="orderBy"]', function() {
                    const contadoresFieldset = $('#contadores-section fieldset');
                    if ($(this).val() === 'factura') {
                        contadoresFieldset.prop('disabled', true);
                        contadoresFieldset.find('input[type="checkbox"]').prop('checked', false);
                    } else {
                        contadoresFieldset.prop('disabled', false);
                    }
                });



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

                $(document).on('click', '#exportar-excel', function(e) {
                    e.preventDefault();
                    exportToExcel();
                });
            }
        });

    })(jQuery);
};
reporteFormasDePago();