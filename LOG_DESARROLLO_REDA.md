# Log de Desarrollo - REDA

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
