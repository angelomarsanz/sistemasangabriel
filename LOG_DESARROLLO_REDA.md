# Log de Desarrollo - REDA

## [2026-10-05] - Mejora y Enriquecimiento de Columnas en Listado de Documentos por Familia (`src/Template/Bills/index.ctp`)
- **Tarea:** Enriquecer la vista del listado de comprobantes y facturas por familia (`Bills/index`), renombrando la columna "Número de factura" a "Nro. documento", añadiendo las columnas "Nro. Control", "Tipo de Documento", "Descuento/Recargo $" y adaptando el cálculo de conversión de divisas para el caso particular de "Recibo de Consejo Educativo".
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/index.ctp`):**
        - Se renombró el encabezado de "Número de factura" a "Nro. documento" con soporte para ordenamiento `bill_number`.
        - Se incorporaron las columnas ordenables "Nro. Control" (`control_number`) y "Tipo de Documento" (`tipo_documento`).
        - Se añadió la columna "Descuento/Recargo $" que calcula el equivalente en dólares del descuento o recargo (`round($bill->amount / $bill->tasa_cambio, 2)`).
        - **Lógica Particular para "Recibo de Consejo Educativo":**
            - Debido a que en la tabla `bills` este tipo de documento guarda el valor en dólares directamente en el campo `amount_paid`, se muestra dicho valor tal cual en la columna "Monto $".
            - En la columna "Monto Bs.", se calcula el valor equivalente en bolívares multiplicando por la tasa de cambio (`round($bill->amount_paid * $bill->tasa_cambio, 2)`).
            - Para los demás tipos de comprobante (facturas, pedidos, otros recibos) se conserva la lógica habitual (`round($bill->amount_paid / $bill->tasa_cambio, 2)` para Monto $ y `$bill->amount_paid` para Monto Bs.).
        - Se agregó la cabecera DocBlock con la documentación explicativa al inicio del archivo.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-10-05] - Implementación de Protocolo de Salvaguarda Incremental ante Cortes Eléctricos/Conexión (`previo_cambios_realizados.md`)
- **Tarea:** Establecer un mecanismo de persistencia continua e incremental de avances técnicos para mitigar la pérdida de contexto e interrupciones causadas por fallas de suministro eléctrico o caídas del servicio de internet en el entorno del usuario.
- **Cambios Realizados:**
    - **Creación de Archivo Raíz (`previo_cambios_realizados.md`):**
        - Se creó el archivo en la raíz del proyecto para registrar de forma inmediata y en caliente el avance por cada archivo modificado o creado durante el desarrollo de una petición.
        - Mantiene un estado limpio inicializado ("Sin tareas inconclusas") que se actualiza dinámicamente durante cualquier trabajo.
    - **Actualización de Directrices de Proyecto (`GEMINI.md` / `.github/copilot-instructions.md`):**
        - Se formalizó el protocolo mandatorio:
            1. **Lectura Obligatoria al Iniciar:** Al recibir cualquier requerimiento o iniciar sesión, se lee primero `previo_cambios_realizados.md` para verificar si existe una tarea interrumpida y reanudarla en el punto exacto.
            2. **Inicialización Limpia:** Se reinicia el contenido del archivo con la nueva solicitud en curso para evitar acumulación de datos residuales o basura.
            3. **Registro Incremental en Caliente:** Conforme se modifique o cree cada archivo, se documenta inmediatamente su ruta y resumen técnico antes de continuar con el siguiente paso.
            4. **Consolidación Oficial:** Al completar la tarea, se transfiere la documentación final a `LOG_DESARROLLO_REDA.md` y `manual_tecnico_sistema.md`, dejando `previo_cambios_realizados.md` en su estado limpio.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-10-05] - Dinamización de Períodos Escolares y Optimización de Sesión en Reporte General de Morosidad de Representantes
- **Tarea:** Sustituir los valores estáticos ('2024-2025' y '2025-2026') en el selector de período escolar del formulario de morosidad general de representantes por períodos dinámicos calculados a partir de la tabla `schools` (`current_school_year`), y transferir los datos de la institución entre las acciones para evitar consultas redundantes a la base de datos y optimizar los tiempos de respuesta.
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - En la acción `generalMorosidadRepresentantes()`, se incorporó la consulta a la institución educativa (`$school = $this->Schools->get(2)`), calculando automáticamente:
            - Período escolar anterior: `($anioEscolarActual - 1) . '-' . $anioEscolarActual`
            - Período escolar actual: `$anioEscolarActual . '-' . ($anioEscolarActual + 1)`
        - Se envía `compact('periodoEscolarAnterior', 'periodoEscolarActual')` a la vista para poblar las opciones del selector.
        - Se implementó la persistencia de la entidad institucional en la sesión PHP de CakePHP (`$this->request->session()->write('school', $school)`).
        - En la acción `reporteGeneralMorosidadRepresentantes()`, se eliminó la consulta repetida y doble carga redundante del modelo `Schools`. Ahora el sistema recupera la institución directamente desde la sesión (`$session->read('school')`), manteniendo como respaldo seguro `$this->Schools->get(2)` solo si la sesión no estuviera disponible.
        - En las funciones auxiliares `saldoCuotas()` y `verificarAnioUltimaInscripcion()`, se adaptó la misma lógica de lectura desde la sesión, logrando que todo el proceso de generación del reporte opere con 0 consultas adicionales a la tabla `schools`.
        - Se incorporaron las cabeceras DocBlock a las funciones modificadas.
    - **UI Formulario (`src/Template/Studenttransactions/general_morosidad_representantes.ctp`):**
        - Se sustituyeron las opciones fijas de `'2024-2025'` y `'2025-2026'` por las variables dinámicas `$periodoEscolarAnterior` y `$periodoEscolarActual`.
        - Se agregó la cabecera DocBlock con la documentación explicativa de la vista.
    - **UI Reporte (`src/Template/Studenttransactions/reporte_general_morosidad_representantes.ctp`):**
        - Se añadió la documentación de cabecera DocBlock al inicio del archivo.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-10-02] - Implementación de 4 Capas de Seguridad contra Concurrencia de Sesiones y Cruce de Turnos
- **Tarea:** Prevenir el cruce accidental de turnos y facturas entre usuarios de cobranza fiscal (`Seniat`) y usuarios de pedidos/recibos (`Ventas generales`) cuando los cajeros abren ambos turnos en pestañas normales del mismo navegador Chrome. Se eliminó la referencia al rol obsoleto `Facturas` dejando únicamente `Seniat` como rol fiscal.
- **Causa Raíz:** Los navegadores web comparten el almacén de cookies (`cookie store`) entre todas las pestañas de una sesión normal. Al iniciar sesión con un segundo usuario en otra pestaña, la cookie de sesión del servidor PHP/CakePHP se sobrescribe con el segundo usuario. Al volver a la primera pestaña, las peticiones (`checkTurnInvoice`, `createInvoice`, `recordInvoiceData`) se enviaban con la sesión del segundo usuario, asociando facturas fiscales al turno de pedidos o arrojando el error de "Usted no tiene un turno abierto".
- **Cambios Realizados:**
    - **Capa 1 - Control de Concurrencia en Login (`src/Controller/UsersController.php`):**
        - En peticiones `GET` a `login()`, si ya existe un usuario autenticado (`$this->Auth->user('id')`), se emite un mensaje Flash informativo y se redirige a la acción `wait`, impidiendo que se mantenga abierta la pantalla de login en pestañas normales.
        - En peticiones `POST` a `login()`, si se intenta autenticar teniendo ya una sesión activa con otro usuario, se rechaza la sobreescritura de credenciales, emitiendo una alerta Flash explícita: `"Usted ya accedió al sistema con otro usuario y clave... Para trabajar simultáneamente con facturas fiscales y pedidos, por favor abra una VENTANA DE INCÓGNITO e ingrese allí con el otro usuario."` y redirigiendo a `wait`.
        - Se agregaron las cabeceras DocBlock a la clase y a la función `login()`.
    - **Capa 2 - Validación Rol-Operación en Turnos (`src/Controller/TurnsController.php`):**
        - En la acción `checkTurnInvoice($menuOption)`, se clasificaron las opciones de cobro en `$tiposFacturaFiscal` y `$tiposPedido`.
        - Se valida que usuarios con rol `Seniat` no puedan acceder a opciones de pedidos/recibos, y que usuarios con rol `Ventas generales` no puedan acceder a opciones de facturación fiscal. Ante inconsistencias, se bloquea el acceso con mensaje explicativo y se redirige a `wait`.
        - Se añadió redirección ordenada hacia `checkTurnOpen` cuando no se encuentra un turno abierto para el usuario en sesión.
        - Se incorporó la documentación DocBlock a la clase y al método `checkTurnInvoice()`.
    - **Capa 3 - Validación Estricta de Turno y Consistencia Contable (`src/Controller/BillsController.php`):**
        - En `createInvoice($menuOption, $idTurn, $turn)`, se verifica obligatoriamente que el `$idTurn` recibido exista, pertenezca al usuario en sesión (`user_id === Auth->user('id')`) y esté con estatus abierto (`status === true`). Además, se restringe el acceso según el rol fiscal (`Seniat`) o no fiscal (`Ventas generales`), redirigiendo con mensaje Flash si se detecta discordancia.
        - En `recordInvoiceData()`, antes de ejecutar `$this->add()` y generar números correlativos de cobro, se verifica que el `$this->headboard['idTurn']` sea un turno abierto propiedad del usuario en sesión. Se valida estrictamente que comprobantes con `fiscal === 1` solo sean grabados por usuarios con rol fiscal autorizado (`Seniat`, `Administrador`, `Propietario`), y que usuarios fiscales (`Seniat`) no registren comprobantes no fiscales (`fiscal === 0`). Si hay inconsistencia, se registra en bitácora (`Binnacles`) y se cancela la operación de forma segura.
        - Se incorporaron las cabeceras DocBlock a la clase `BillsController` y a los métodos modificados.
    - **Capa 4 - Coherencia en Interfaz de Retorno de Impresión (`src/Template/Bills/retorno_impresion.ctp`):**
        - Se actualizó la condicional para evaluar exclusivamente el rol `'Seniat'` (`if ($current_user['role'] == 'Seniat')`), eliminando la referencia al rol obsoleto `'Facturas'`. Esto garantiza que los cajeros fiscales, al finalizar la impresión o verificación de facturas, solo visualicen accesos directos a opciones fiscales y nunca a pedidos.
        - Se añadió la documentación DocBlock al inicio de la vista.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-09-30] - Normalización de Cédulas Escolares y Nacionalidad M en Reporte de Aseguradora
- **Tarea:** Implementar la regla de asignación de nacionalidad "M" y cédula escolar generada (cédula del representante más consecutivo secuencial por hijo sin cédula válida) en el reporte de aseguradora para:
    1. Estudiantes con tipo de identificación diferente de "V" ("E", "P", "PN").
    2. Estudiantes con cualquier nacionalidad ("V", "E", "P", "PN") cuya cédula sea igual a "cero", "0", vacía o con una numeración menor o igual a 7 cifras.
    3. Mantener cédula propia y nacionalidad "V" únicamente para estudiantes con nacionalidad "V" cuya cédula sea válida (no "cero" y con más de 7 dígitos numéricos).
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Se implementó el método privado `esMenorSinCedula($estudiante)` para centralizar la verificación lógica de acuerdo a las directrices: evalúa si `type_of_identification !== 'V'`, si `identity_card` es 'cero'/'0' o si su conteo de dígitos numéricos es menor o igual a 7.
        - Se refactorizó la acción `reporteParaAseguradora` para ambos bloques de ejecución (Nuevos/Nuevo y Regular, y Regular/5to. Año):
            - En el pre-procesamiento, se utiliza `esMenorSinCedula($est)` para asignar de forma persistente y no colisionante la cédula escolar generada (`$cedulaRep . $consecutivo`) en `$mapaCedulasPN`.
            - En el guardado histórico en la tabla `excels`, se almacena como `nacionalidad_titular = 'M'` y `cedula_titular_escolar` la generada con el consecutivo.
            - En la búsqueda y comparación contra la tabla `ListaAsegurados`, se verifica tanto con el nuevo identificador normalizado (`M-{cedulaGenerada}` o `V-{cedula}`) como con el original para garantizar compatibilidad con registros existentes en la aseguradora.
            - Se actualizó la lista de estudiantes con condición especial para mostrar la cédula escolar generada si no disponen de cédula propia válida.
            - Se actualizaron las cabeceras DocBlock del controlador y del método `reporteParaAseguradora`.
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se actualizó la función anónima `$fnEsMenorSinCedula` con la misma regla de validación de 7 dígitos y cédulas en cero.
        - Se ajustaron `$fnCedulaPN` y `$fnNacionalidadEstudiante` para recibir la entidad de estudiante y sincronizar la nacionalidad ("M" o "V") con la cédula correspondiente (generada del mapa o cédula propia).
        - Se actualizaron todas las tablas de reporte de aseguradora (Principal, Encontrados Seguro, No Encontrados Seguro e Instrucción Actualizada) pasando la entidad `$student` a `$fnNacionalidadEstudiante`.
        - Se actualizó la cabecera DocBlock del archivo de vista.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-09-29] - Habilitación de campo mes para Promoción especial mensualidad pedidos en tarifas
- **Tarea:** Permitir que al seleccionar "Promoción especial mensualidad pedidos" en la creación de tarifas en dólares, el campo `rate_month` (a partir del mes) se mantenga habilitado y requerido.
- **Causa Raíz:** La cadena `"Promoción especial mensualidad"` tiene exactamente 30 caracteres. Al evaluarse con `substring(0, 31)`, para `"Promoción especial mensualidad pedidos"` se extraían 31 caracteres incluyendo un espacio en blanco final (`"Promoción especial mensualidad "`), provocando que la comparación fuera falsa y se ejecutara el bloque `else` que deshabilitaba el selector de mes.
- **Cambios Realizados:**
    - **UI (`src/Template/Rates/add_dollar.ctp`):**
        - Se incorporó la opción `'Promoción especial mensualidad pedidos' => 'Promoción especial mensualidad pedidos'` al arreglo de opciones del campo `concept`.
        - En la función `enableInputs()`, se corrigió la longitud del substring de 31 a 30 caracteres (`$("#concept").val().substring(0, 30) == "Promoción especial mensualidad"`), abarcando tanto `"Promoción especial mensualidad"` como `"Promoción especial mensualidad pedidos"`.
        - En el evento `click` del botón `#guardar`, se actualizó la condición para usar `.substring(0, 30)` en lugar de la comparación exacta `== "Promoción especial mensualidad"`, asegurando que la confirmación incluya el mes y año correctamente.
        - Se agregaron los comentarios DocBlock explicativos al inicio del archivo y a las funciones `enableInputs()` y `verifyConcept()`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-09-29] - Ajuste en búsqueda de tarifa para promoción especial según indicador_pedido
- **Tarea:** Condicionar la búsqueda de la tarifa promocional de mensualidad en la vista de facturación/pedidos para buscar "Promoción especial mensualidad pedidos" si `indicador_pedido == 1`, o "Promoción especial mensualidad" en caso contrario.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se modificó la sección del evento `change` de `#concepto-descuento` correspondiente a `'Descuento promoción especial mensualidad'`.
        - Antes de iterar sobre `otrasTarifas`, se evalúa si `indicador_pedido == 1` para definir la cadena de búsqueda (`'Promoción especial mensualidad pedidos'` o `'Promoción especial mensualidad'`).
        - Se ajustó la comparación contra `value3.conceptoAno` para asociar la tarifa correcta (`tarifaDolar`), estableciendo `#descuento-recargo` en `'Descuento $'` y precargando `#cantidad-descuento` adecuadamente.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.

## [2026-09-22] - Corrección de Error: Índice $mapaCedulasPN indefinido en Controlador
- **Tarea:** Resolver el error `Notice (8): Undefined index: mapaCedulasPN` en el controlador al ejecutar el reporte de aseguradora.
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Se modificó la función `reporteParaAseguradora` para incluir explícitamente la clave `'mapaCedulasPN' => $mapaCedulasPN` en su arreglo de retorno.
        - Esto permite que la acción `reportStudentGeneral` acceda correctamente a los datos pre-calculados y los pase a la vista sin generar advertencias de índice inexistente.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando la sincronización de identidades entre el controlador y la vista.

## [2026-09-22] - Corrección de Error: Variable $mapaCedulasPN indefinida
- **Tarea:** Resolver el error `Notice (8): Undefined variable: mapaCedulasPN` que ocurría al cargar reportes distintos al de aseguradora.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se añadió una inicialización preventiva de la variable `$mapaCedulasPN = []` si no está definida al inicio del bloque PHP.
        - Esto asegura que la función anónima `$fnCedulaPN`, que hace un `use ($mapaCedulasPN)`, no falle en reportes (como Alumnos Solventes o Pendientes) donde el controlador no envía este mapa.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` reflejando la corrección para la compatibilidad multi-reporte.

## [2026-09-22] - Refactorización de Identificación de Estudiantes (PN)
- **Tarea:** Garantizar la estabilidad de las cédulas escolares generadas (PN) y asegurar que no colisionen entre hermanos, respetando las cédulas propias (V, E, P).
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Se rediseñó la función `reporteParaAseguradora` para realizar un pre-procesamiento exhaustivo de todos los estudiantes.
        - **Estabilidad de IDs:** El sistema ahora carga el historial completo de la tabla `Excels` antes de asignar nuevos IDs. Si un estudiante ya tiene un ID generado en el pasado, este se recupera y se mantiene inalterado.
        - **Lógica de Contadores Robusta:** Se implementó una lógica para deducir el contador actual de cada representante basándose en el historial de hijos PN (Nacionalidad M) ya registrados. Esto evita que un nuevo hijo PN reciba un correlativo que ya pertenezca a un hermano.
        - **Respeto por IDs Propios:** Se aseguró que los estudiantes con cédula propia (V, E, P) no afecten ni consuman números del contador secuencial de sus hermanos PN.
        - **Consistencia de Datos:** Se unificó la generación de identidades en un mapa único (`$mapaCedulasPN`) que se utiliza tanto para el guardado en base de datos como para la visualización en el reporte.
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se eliminó la lógica de cálculo de IDs locales que existía en la vista.
        - Ahora la vista consume directamente el mapa `$mapaCedulasPN` pasado desde el controlador, garantizando que el mismo estudiante tenga exactamente el mismo ID en todas las tablas del reporte (Principal, Condición Especial, Encontrados, etc.).
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando el nuevo mecanismo de persistencia y sincronización de identidades PN.

## [2026-09-22] - Corrección de Error: Variable $fnCedulaPN indefinida
- **Tarea:** Resolver el error `Notice (8): Undefined variable: fnCedulaPN` que impedía la visualización de las tablas de control en el reporte de seguro.
... (rest of the file) ...

    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se restauró la definición de la función anónima `$fnCedulaPN` al inicio del bloque PHP de la vista.
        - Esta función es crítica para generar consistentemente las cédulas temporales de estudiantes "PN" en todas las secciones del reporte.
- **Estado:** Error resuelto, funcionalidad de identificación temporal restablecida.

## [2026-09-22] - Automatización de Registro en Excels para Nuevos Ingresos
- **Tarea:** Registrar automáticamente en la tabla de control `excels` a los estudiantes de modalidad "Nuevo" y "Nuevo y Regular" que se incluyen en el reporte por primera vez.
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - En la función `reporteParaAseguradora`, se implementó el guardado automático de entidades en la tabla `Excels` para aquellos estudiantes que no tienen un registro previo (dentro del bloque de alumnos adicionales).
        - Se integró la lógica de **normalización de nacionalidad** (PN -> M, P -> E) y la generación de **cédulas temporales** (concatenación de ID representante + secuencia) directamente en el controlador.
        - Se aseguró que los nombres y apellidos se guarden en **mayúsculas** para mantener la uniformidad con el histórico de la tabla.
        - Se incluyó la vinculación del registro con el identificador de la ejecución actual (`N_nuevo_fecha_hora`).
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando el proceso de persistencia automática para control de envíos.

## [2026-09-22] - Normalización de Nacionalidad en Reporte de Seguro
- **Tarea:** Ajustar la visualización del tipo de identificación para estudiantes y representantes según estándares de la aseguradora.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se implementaron las funciones auxiliares `fnNacionalidadEstudiante` y `fnNacionalidadRepresentante`.
        - **Estudiantes:** Los registros con "**PN**" ahora se muestran como "**M**" (Menor sin cédula). Los registros con pasaporte ("**P**") se muestran como "**E**" (Extranjero). Las opciones "V" y "E" se mantienen.
        - **Representantes:** Los registros con pasaporte ("**P**") se muestran ahora como "**E**" (Extranjero). Las opciones "V" y "E" se mantienen.
        - Se actualizaron todas las celdas de nacionalidad en las 4 tablas del reporte para aplicar estas reglas de transformación.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando las reglas de transformación de identidad.

## [2026-09-22] - Implementación de Cédulas Temporales (PN) en Reporte de Seguro
- **Tarea:** Generar números de cédula automáticos para estudiantes sin identificación (PN) basados en la cédula del representante.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se implementó una lógica de inicialización con un mapa de asignación (`$mapaCedulasPN`) y contadores por representante (`$contadoresRepresentantes`).
        - Se añadió una función auxiliar (`fnCedulaPN`) que detecta estudiantes con `type_of_identification == 'PN'` y les asigna la cédula de su representante seguida de un contador secuencial (ej. 103490971, 103490972).
        - La lógica asegura consistencia: un mismo estudiante mantiene la misma cédula temporal aunque aparezca en múltiples tablas del reporte (Principal, Encontrados, No encontrados, etc.).
        - Se actualizaron todas las tablas del reporte que manejan entidades de estudiante para utilizar esta nueva función de identificación.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando el nuevo mecanismo de identificación temporal.

## [2026-09-22] - Simplificación de Reporte Seguro Escolar: Eliminación de columna "Grado"
- **Tarea:** Eliminar la columna "**Grado**" de todas las tablas del reporte para aseguradora.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se eliminó el encabezado `<th scope="col">GRADO</th>` de las 4 tablas principales del reporte de seguro (Principal, Registros Encontrados, No Encontrados e Instrucción Actualizada).
        - Se eliminaron las celdas correspondientes que mostraban el nombre completo de la sección (`section->full_name`).
        - El reporte ahora cuenta con 20 columnas de datos, manteniendo el alineamiento correcto para su visualización y exportación.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` reflejando la nueva estructura de las tablas del reporte.

## [2026-09-21] - Mejora en Reporte Seguro Escolar: Nueva opción "Nuevo y Regular"
- **Tarea:** Agregar la opción "Nuevo y Regular" al reporte de seguro y renombrar "Regular".
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se renombró la etiqueta de la opción "Regular" a "**Regular versus archivo del seguro**".
        - Se añadió la nueva opción "**Nuevo y Regular**" en el selector de tipo de estudiante para el reporte de aseguradora.
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Refactorizada la acción `reporteParaAseguradora` para manejar tanto "Nuevo" como "Nuevo y Regular" en un mismo bloque lógico.
        - Para la opción "Nuevo y Regular", se omitió el filtro `'Students.new_student' => 1`, permitiendo incluir a todos los estudiantes con matrícula pagada.
        - Se ajustó el prefijo de la cadena de ejecución (`$nuevaEjecucionStr`) a `nuevo_y_regular_` cuando se selecciona esta modalidad.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` reflejando la nueva capacidad de segmentación en el reporte de aseguradora.

## [2026-08-30] - Implementación completa de sección Descuentos/Recargos
- **Tarea:** Mejorar la sección de descuentos/recargos en la creación de facturas.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se agregó el título "**Descuentos/Recargos**" a la sección correspondiente en la tabla de totales.
        - Se actualizaron las opciones del selector de concepto: "Descuento", "Descuento por meses no cursados", "Descuento por pago año completo", "Descuento pronto pago" (por defecto) y "Concepto personalizado".
        - Se cambió la etiqueta del input de "Descuento/Recargo" a "**Tipo**".
        - Se eliminó la línea divisoria visual entre la fila de concepto y la fila de tipo/cantidad mediante estilos CSS (`border-top: none`).
        - Corregido error en la lógica de JavaScript que impedía mostrar el modal al seleccionar "Concepto personalizado".
    - **Backend (`src/Controller/BillsController.php`):**
        - El método `recordInvoiceData` recupera el concepto seleccionado (estático o personalizado) y lo envía al proceso de creación de notas de crédito.
        - `agregaNotaCreditoDescuentos` ahora acepta el concepto como parámetro dinámico.
    - **Backend (`src/Controller/ConceptsController.php`):**
        - `agregarConceptoNotaCreditoDescuento` utiliza el concepto recibido desde el controlador de facturas para la descripción del registro.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` con los detalles finales de la implementación.

## [2026-08-31] - Corrección de la compilación de assets (Vite)
- **Tarea:** Resolver el problema por el cual los cambios en `index.css` no se reflejaban en la version compilada.
- **Cambios Realizados:**
    - **Configuración (`js_csga/vite.config.js`):**
        - Se corrigió la ubicación de la propiedad `globals` moviéndola dentro de `build.rollupOptions.output`.
        - Se eliminó la propiedad `root` que estaba mal ubicada dentro de `build`.
        - Se mejoró la función `assetFileNames` para asegurar que los archivos CSS mantengan su nombre definido en `input`.
        - Se añadió `emptyOutDir: true` para limpiar la carpeta `dist` antes de cada compilación.
    - **Entorno:**
        - Se instalaron las dependencias de `npm` en el directorio `js_csga`.
        - Se asignaron permisos de ejecución al binario de `esbuild` (`chmod +x`) para permitir la compilación en entornos Linux.
- **Resultado:** La compilación ahora genera correctamente `dist/main-style.css` con los cambios de `index.css` y los transfiere a `webroot/css/`.

## [2026-09-01] - Mejora en la selección de conceptos de descuento y automatización
- **Tarea:** Ajustar las opciones, estética y lógica de validación de la sección Descuentos/Recargos.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se añadió una opción inicial vacía al select de `concepto_descuento` y se estableció como valor por defecto.
        - Se renombró la opción "Descuento por pago año completo" a "Descuento promoción especial mensualidad".
        - Se incrementó el ancho del selector de conceptos (colspan="3") para mejorar la estética de "recibo".
        - Implementada lógica en JavaScript (`toggleDiscountInputs`) para mantener los inputs de "**Tipo**" y "**Cantidad**" deshabilitados hasta que se seleccione un concepto válido.
        - **Automatización:** Al seleccionar "Descuento promoción especial mensualidad", el sistema busca automáticamente la tarifa de "Promoción especial mensualidad" en `otrasTarifas`, pre-cargando el tipo como "Descuento: $" y el monto correspondiente.
        - **Depuración y Ajuste:** Se corrigió la búsqueda de la tarifa promocional mediante el uso de `substring(0, 30)` para ignorar sufijos de año (ej. "2026") en `conceptoAno` y se añadieron `console.log` para facilitar la inspección de los datos cargados.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar el comportamiento dinámico y automatizado de los campos de descuento.

## [2026-09-02] - Implementación de Condición Especial en transacciones
- **Tarea:** Permitir el registro de una "condición especial" en las transacciones cuando se aplica el descuento de promoción especial.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se agregó el atributo `dbCondicionEspecial` al objeto de transacciones en la función `insertRecord` (inicializado en vacío).
        - Se actualizó el evento `change` de `#concepto-descuento` para que, al seleccionar "Descuento promoción especial mensualidad", se marque este valor en el atributo `dbCondicionEspecial` de todas las transacciones cargadas.
        - La función `uploadTransactions` ahora incluye el campo `condicionEspecial` en el objeto enviado al servidor.

## [2026-09-14] - Mejora visual en tablas secundarias del Reporte de Seguro Escolar
- **Tarea:** Incluir el estatus del estudiante en los reportes de control para mayor claridad administrativa.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se añadió la columna "**CONDICIÓN**" a la tabla de "**Estudiantes con instrucción actualizada anteriormente**".
        - Se añadió la columna "**CONDICIÓN**" a la tabla de "**Estudiantes no encontrados en archivo del seguro**".
        - En ambas tablas, el valor se muestra antes de la columna "**ID ESTUDIANTE**", permitiendo identificar rápidamente si un registro requiere atención especial por su estatus (ej. Retirado, Graduado, etc.).
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la inclusión de la columna de condición en los reportes de control.

## [2026-09-03] - Depuración de opciones de concepto de descuento
- **Tarea:** Eliminar opciones obsoletas o redundantes del selector de conceptos de descuento.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se eliminaron las opciones "Descuento" y "Concepto personalizado" del input select `concepto_descuento`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la lista simplificada de conceptos disponibles.

## [2026-09-10] - Mejora de formulario en Reporte General de Estudiantes
- **Tarea:** Ajustar la visibilidad de campos dinámicos y añadir nuevas opciones en el reporte de seguro escolar.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se agregó documentación de cabecera al archivo describiendo su funcionalidad.
        - Se envolvió el campo "**Período escolar**" en un contenedor `div` para controlar su visibilidad completa (etiqueta e input).
        - Se añadió un nuevo campo select "**Tipo de estudiantes**" con las opciones independientes "**Regulares**" y "**Nuevos**", también envuelto en un contenedor dinámico.
        - Se actualizó la lógica de jQuery para:
            - Mostrar "**Período escolar**" y marcarlo como requerido solo si se selecciona "Reporte de alumnos solventes" o "Reporte de alumnos pendientes de pago".
            - Mostrar "**Tipo de estudiantes**" y marcarlo como requerido si se selecciona "Reporte para aseguradora".
            - Ocultar ambos campos y quitar la obligatoriedad en cualquier otro caso.
        - Se eliminó el bloqueo (`alert` y `preventDefault`) que impedía el uso de la opción "Reporte para aseguradora".
- **Documentación:** Se añadió el resumen del archivo y sus cambios al `manual_tecnico_sistema.md`.

## [2026-09-03] - Implementación de rastro de descuento y porcentaje de divisas
- **Tarea:** Registrar una 'condición especial' en facturas y transacciones cuando se aplica un descuento y hay pagos en divisas.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se modificó la función `guardarFactura` para calcular el monto neto de la factura (`netoFactura = totalBalance - discount`).
        - Si el concepto de descuento comienza con "Descuento", se calcula el porcentaje de divisas pagado (`porcentajeDivisa = monto_divisas * 100 / netoFactura`).
        - Se crea la cadena `condicion_especial` con el concepto y el porcentaje (ej: "Descuento pronto pago, 50.00% pago en divisas").
        - **Ajuste IGTF:** Se movió la asignación de `payments.monto_igtf` dentro de la lógica condicional. Si el pago en divisas es del 100%, el IGTF se recalcula sobre el total del balance (`totalBalance * porcentaje_calculo_igtf`) para asegurar la precisión del impuesto en pagos totales con moneda extranjera.
        - Este valor se asigna a `payments.condicion_especial` y se replica en la propiedad `dbCondicionEspecial` de cada transacción en `studentTransactionsArray` antes de enviar los datos al servidor.
    - **Backend (`src/Controller/BillsController.php`):**
        - Se actualizó la acción `add` para recibir `condicion_especial` desde el encabezado (`headboard`) y guardarla en el registro de la factura (`Bill`).
- Documentación: Actualización de `manual_tecnico_sistema.md` para reflejar el registro de condiciones especiales y el ajuste del cálculo de IGTF.

## [2026-09-03] - Automatización de rastro técnico en Notas de Crédito y conversiones
- **Tarea:** Asegurar que el rastro de "condición especial" y el ajuste de IGTF se repliquen en las notas de crédito generadas por descuentos y en la conversión de pedidos.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se incluyó el campo `porcentaje_igtf` en el objeto `payments` enviado al servidor para permitir cálculos precisos en el backend.
    - Backend (`src/Controller/BillsController.php`):
            - **`agregaNotaCreditoDescuentos`**: Modificada para detectar la condición "100% pago en divisas" de la factura afectada. En este caso, la nota de crédito registra automáticamente el `monto_divisas` proporcional y el `monto_igtf` (usando el porcentaje recibido o 3% por defecto), redondeando ambos valores a dos decimales y manteniendo el rastro en la columna `condicion_especial`.
            - **`pedidoPorFactura` y `pedidoPorFacturaPlanificado`**: Se añadió la copia del campo `condicion_especial` al crear la factura a partir de un pedido, garantizando que el rastro técnico no se pierda durante la conversión.

- **Documentación:** Actualización de `manual_tecnico_sistema.md` con los detalles de replicación de rastro técnico y persistencia de datos.

## [2026-09-03] - Mejora en la validación de becas para descuento especial
- **Tarea:** Ajustar la restricción del "Descuento promoción especial mensualidad" para permitir su aplicación a estudiantes con becas que no sean de tipo "Especial".
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudentsController.php`):**
        - Se verificó que la acción `relatedStudents` incluya el campo `tipo_descuento` en el objeto JSON de cada estudiante enviado a la vista.
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se actualizó la función `insertRecord` para capturar y almacenar `dbTipoDescuento` en el arreglo de transacciones del estudiante.
        - Se mejoró la lógica de validación en el evento `change` de `#concepto-descuento`: ahora el sistema solo bloquea la operación y solicita eliminar la beca si el estudiante tiene un descuento mayor a cero Y el tipo de beca es específicamente "Especial". Esto permite que estudiantes con otros tipos de beca (ej. "Hijos" o "Becado") puedan aplicar a la promoción especial si se requiere.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la nueva lógica de validación basada en el tipo de descuento.

## [2026-09-12] - Seguimiento de ejecuciones en Reporte para Aseguradora (Solo Estudiantes Nuevos)
- **Tarea:** Implementar un registro de control para cada ejecución del reporte de seguro escolar, limitado exclusivamente a estudiantes nuevos.
- **Cambios Realizados:**
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - **`reporteParaAseguradora`**:
            - Se reestructuró la función para diferenciar el tratamiento según el tipo de estudiante.
            - **Estudiantes Nuevos:**
                - Se incorporó la carga del modelo `Schools` para gestionar el seguimiento.
                - Se implementó una lógica de incremento consecutivo basada en la columna `ejecucion_reporte_seguro` de la tabla `schools` (registro ID 2), guardando el historial en formato JSON.
                - Se automatizó la verificación y guardado en la tabla `excels` de cada estudiante nuevo incluido en el reporte, registrando el identificador de la ejecución actual (`N_nuevo_fecha_hora`).
            - **Estudiantes Regulares:**
                - Se restauró el comportamiento de búsqueda simple en la base de datos sin afectar las tablas `schools` ni `excels`.
                - Se aseguró que la función devuelva la estructura `$datos_reporte` completa (incluyendo `alumnosAdicionales` con todos los IDs encontrados) para garantizar la correcta visualización en la interfaz.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando la exclusividad del seguimiento para el proceso de alumnos nuevos.


## [2026-09-14] - Creación de modelos para Lista de Asegurados
- **Tarea:** Crear los archivos de modelo (Table y Entity) para la tabla `lista_asegurados` a partir del esquema SQL.
- **Cambios Realizados:**
    - **Entity (`src/Model/Entity/ListaAsegurado.php`):**
        - Se creó la entidad con la documentación correspondiente.
        - Se configuró el acceso masivo (`_accessible`) permitiendo todos los campos excepto `certificado` (PK).
    - **Table (`src/Model/Table/ListaAseguradosTable.php`):**
        - Se implementó la clase de tabla configurando el nombre de la tabla (`lista_asegurados`), la clave primaria (`certificado`) y el campo de visualización (`asegurado`).
        - Se añadió el comportamiento `Timestamp` para la gestión automática de `created` y `modified`.
        - Se definieron las reglas de validación básica para todos los campos de la tabla.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` con el resumen de los nuevos archivos y su funcionalidad.

## [2026-09-14] - Mejora de Reporte para Aseguradora con integración de Lista de Asegurados
- **Tarea:** Mejorar la acción `reporteParaAseguradora` para filtrar estudiantes por condición y verificar instrucciones previas en el modelo `ListaAsegurados`.
- **Cambios Realizados:**
    - **Controller (`src/Controller/StudenttransactionsController.php`):**
        - Se cargó el modelo `ListaAsegurados`.
        - En `reporteParaAseguradora`, se implementó un bucle `foreach` sobre los estudiantes para:
            1. Identificar estudiantes con condición distinta a "Regular" (`estudiantesCondicionEspecial`).
            2. Comparar estudiantes con la tabla `lista_asegurados` mediante cédula o nombre concatenado.
            3. Separar a los estudiantes que ya tienen una instrucción asignada (`estudiantesInstruccionActualizada`).
            4. Mantener en el reporte original solo a aquellos sin instrucción previa o no encontrados.
        - Se actualizaron los métodos `reportStudentGeneral` y `reporteParaAseguradora` para enviar estas nuevas colecciones a la vista.
    - **View (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se añadieron dos nuevas tablas dentro del bloque del reporte para aseguradora:
            1. "Estudiantes con condición distinta a Regular": Muestra consecutivo, nombres, cédula, condición y fecha de modificación.
            2. "Estudiantes con instrucción actualizada anteriormente": Muestra los datos de identidad para revisión.
        - Se aseguró que estas tablas no se exporten a Excel al omitir el ID `seguro`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` detallando la nueva lógica de filtrado y visualización de reportes adicionales.

## [2026-09-14] - Optimización de lógica redundante en Reporte para Aseguradora
- **Tarea:** Eliminar condiciones redundantes y simplificar el filtrado de estudiantes de "5to. Año".
- **Cambios Realizados:**
    - **Controller (`src/Controller/StudenttransactionsController.php`):**
        - En la función `reporteParaAseguradora`, se eliminó el chequeo redundante `if ($tipo_estudiante == "5to. Año")` dentro del bloque `else` final, ya que por lógica de flujo este bloque solo se ejecuta cuando el tipo es "5to. Año".
        - Se integró el filtro de secciones (`Students.section_id IN [41, 42, 43]`) directamente en el arreglo `$condicionesBusqueda` para mejorar la legibilidad y eficiencia del código.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la simplificación de la lógica de negocio.

## [2026-09-14] - Integración de información de sección en Reporte para Aseguradora
- **Tarea:** Incluir el grado y sección detallada en las tablas de control y en el reporte principal de seguro escolar.
- **Cambios Realizados:**
    - **Controller (`src/Controller/StudenttransactionsController.php`):**
        - Se actualizó la acción `reporteParaAseguradora` para incluir el modelo `Sections` en el `contain` de todas las consultas de estudiantes (`StudentsFor`).
        - En la lógica de segmentación de estudiantes con condición especial, se incorporó la obtención de `section->full_name` para guardarla en el arreglo de datos enviado a la vista.
    - **View (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se añadió la columna "**SECCIÓN**" a las tres tablas de control secundarias (Condición especial, Instrucción actualizada y No encontrados).
        - **Mejora:** En la tabla principal del "**Reporte para aseguradora**", se sustituyó el campo simple `level_of_study` por el nombre completo de la sección (`section->full_name`) en la columna "**GRADO**", proporcionando una información más precisa para la póliza.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar el uso extensivo del modelo `Sections` en la interfaz del reporte.


## [2026-09-14] - Unificación de lógica para Estudiantes Nuevos y mejoras de UI
- **Tarea:** Aplicar la lógica de segmentación por condición y verificación de procesados anteriores a los estudiantes de tipo "Nuevo", y añadir un título dinámico al reporte.
- **Cambios Realizados:**
    - **Controller (`src/Controller/StudenttransactionsController.php`):**
        - En `reporteParaAseguradora`, se refactorizó el bloque de estudiantes "Nuevo" para:
            1. Detectar estudiantes con condición distinta a "Regular" y agregarlos a `estudiantesCondicionEspecial`.
            2. Verificar si el estudiante ya fue procesado en el último envío mediante la tabla `Excels`.
            3. Segmentar a los estudiantes ya procesados en la colección `estudiantesInstruccionActualizada`.
            4. Incluir en `alumnosAdicionales` (reporte principal) solo a los estudiantes que no han sido procesados anteriormente.
    - **View (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se agregó un título dinámico antes de la tabla del reporte: "**Tipo de estudiante: [Nuevo/Regular/5to. Año]**".
        - Se utilizó la clase `noExl` para asegurar que este título sea visible solo en pantalla y no se incluya en las exportaciones a Excel, manteniendo el formato requerido por la aseguradora.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` con los detalles de la unificación lógica y los ajustes visuales.

## [2026-09-14] - Culminación de mejora en coincidencia para Reporte de Seguros (Surgical Fix)
- **Tarea:** Optimizar la identificación de estudiantes en el reporte para la aseguradora, mejorando la flexibilidad en nombres e identidades para los segmentos Regulares y 5to Año.
- **Backend (`src/Controller/StudenttransactionsController.php`):**
    - Se refinó la lógica de coincidencia en el bloque `else` de `reporteParaAseguradora`.
    - **Identidad:** Implementación de comparación por cédula/RIF usando el formato `T-IDENTIDAD` (Ej: V-12345678). Se incluyó limpieza de espacios en blanco (`trim`) e insensibilidad a mayúsculas tanto en el registro de la aseguradora (`cedu_rif`) como en los datos del sistema (`identity_card` y `type_of_identification`).
    - **Nombres:** 
        - Se amplió el arreglo de combinaciones de nombres para incluir formatos con apellidos primero (ej: "PEREZ RODRIGUEZ JUAN ALBERTO").
        - Se implementó una validación por "**bolsa de palabras**" (word bag) como procedimiento de respaldo, permitiendo coincidencias aunque el orden de los términos varíe, filtrando palabras cortas/conectores.
        - Se mantuvo la insensibilidad a acentos y mayúsculas mediante el método `normalizarTexto`.
    - **Restricción Quirúrgica:** Se respetó estrictamente la instrucción de no modificar el bloque de estudiantes "**Nuevo**", el cual mantiene su lógica original de validación contra `Excels`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` con los detalles de la identificación flexible.

- **2026-09-14 16:10 (Gemini CLI):** Culminación de los ajustes técnicos y de visibilidad para el reporte de seguros:
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Se restauró la lógica de guardado automático en la tabla `Excels` para estudiantes de tipo "**Nuevo**" cuando son incluidos en el reporte por primera vez (no procesados anteriormente), vinculando su ID al identificador de la ejecución actual.
        - Se verificó que la segmentación quirúrgica se mantenga: los "Nuevos" procesados anteriormente van a "**Registros encontrados**", mientras que los no procesados permanecen en el reporte principal.
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se refinó el título del reporte secundario a "**Estudiantes encontrados en las listas del colegio y del seguro (Registros encontrados)**" para cumplir con la terminología solicitada por el usuario.
        - Se validó que todas las tablas de control mantengan la estandarización de 21 columnas para compatibilidad total con la aseguradora.
    - **Documentación:** Actualizados el `manual_tecnico_sistema.md` y este log para reflejar el estado final de la implementación.

## [2026-09-16] - Nueva segmentación en Reporte para Aseguradora
- **Tarea:** Listar estudiantes que ya poseen una instrucción actualizada en una sección independiente del reporte.
- **Cambios Realizados:**
    - **Backend (src/Controller/StudenttransactionsController.php):**
        - En reporteParaAseguradora, se inicializó el array $estudiantesInstruccionActualizada.
        - Se modificó la lógica de procesamiento para que, si un asegurado ya tiene el campo instruccion poblado, el registro se agregue a este nuevo array en lugar de ser ignorado o procesado como nueva instrucción.
        - Se actualizó el array de retorno y la acción reportStudentGeneral para enviar esta nueva colección a la vista.
    - **UI (src/Template/Studenttransactions/report_student_general.ctp):**
        - Se añadió una nueva tabla "Estudiantes con instrucción ya actualizada" que se muestra al final del bloque de reporte para aseguradora.
        - La tabla utiliza el mismo formato de 21 columnas que el reporte principal para mantener la consistencia de los datos.
- **Documentación:** Se actualizaron los encabezados de los archivos modificados y el manual técnico del sistema.

## [2026-09-21] - Implementación de exportación multi-hoja a Excel en Reporte de Seguro
- **Tarea:** Permitir la exportación de todas las tablas del reporte de seguro escolar a un único archivo Excel con hojas separadas.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se asignaron identificadores únicos (`id`) a todas las tablas del reporte para permitir su selección individual: `#tabla-condicion-especial`, `#tabla-encontrados-seguro`, `#tabla-no-encontrados-seguro` y `#tabla-instruccion-actualizada`.
        - Se reemplazó la lógica de exportación basada en `table2excel` por una implementación personalizada utilizando la librería **SheetJS (XLSX)** (ya disponible en el proyecto).
        - La nueva funcionalidad crea un libro de trabajo (`workbook`) y agrega cada tabla presente en la vista a una hoja independiente con nombres descriptivos (ej. "Seguro Escolar", "Condicion Especial", etc.).
        - Se implementó la limpieza automática de columnas marcadas con la clase `.noExl` (como los números correlativos de la interfaz) antes de la exportación para mantener la integridad del formato Excel requerido.
        - Se añadieron validaciones de existencia de elementos y se mejoró la gestión de obligatoriedad de campos en el formulario dinámico.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la mejora en la herramienta de exportación.

## [2026-09-22] - Corrección de error en exportación Excel (Fechas distorsionadas)
- **Tarea:** Corregir la distorsión de fechas en la exportación a Excel del reporte de seguro escolar.
- **Cambios Realizados:**
    - **UI (`src/Template/Studenttransactions/report_student_general.ctp`):**
        - Se modificó la función JavaScript `addTableToSheet` para incluir la opción `{ raw: true }` en la llamada a `XLSX.utils.table_to_sheet`.
        - Esta modificación previene que la librería SheetJS intente interpretar las celdas como fechas, lo cual causaba que Excel aplicara una lógica de autocompletado errónea (transformando años como 2013 en 1913) para fechas con día <= 12.
        - Se añadió documentación JSDoc a la función `addTableToSheet` para mejorar la mantenibilidad.
        - Se actualizó el encabezado PHP de la vista para incluir la funcionalidad de exportación a Excel.
- **Documentación:** Se actualizó el manual técnico del sistema y este log de desarrollo.
