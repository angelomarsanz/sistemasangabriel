# Manual Técnico del Sistema San Gabriel

## src/Template/Bills/create_invoice.ctp
    Este archivo maneja la vista para la creación de facturas y recibos. Se actualizó la sección de totales para incluir un título informativo "**Descuentos/Recargos**". El campo de selección de concepto ofrece varias opciones de descuento y una lógica de habilitación dinámica para los campos de tipo y cantidad. Al guardar la factura, se calcula el monto neto y, si se aplica un descuento, se determina el porcentaje de pago realizado en divisas. Esta información se registra en el atributo `condicion_especial` tanto de la factura como de cada una de las transacciones asociadas, permitiendo mantener un rastro detallado del beneficio aplicado y la modalidad de pago.

## src/Controller/StudenttransactionsController.php
    Controlador que gestiona las transacciones de los estudiantes. Se actualizó la acción `edit` para permitir la recepción y persistencia del campo `condicion_especial`. Durante el proceso de registro de datos de facturación, el controlador extrae este valor del objeto de transacción recibido y lo guarda en la base de datos.
    **Seguimiento de Reportes de Seguro:** Se mejoró significativamente la función `reporteParaAseguradora` para implementar un sistema de trazabilidad diferenciado según el tipo de estudiante:
    - **Estudiantes Nuevos:** Implementa un sistema de trazabilidad incremental. El sistema carga el registro de la institución (ID 2 de la tabla `schools`) y gestiona un historial en la columna `ejecucion_reporte_seguro` (formato JSON), asignando un identificador único con la estructura `{consecutivo}_nuevo_{fecha_hora}`. Para evitar duplicidades, el controlador verifica qué estudiantes no han sido registrados previamente en la tabla `excels` y guarda automáticamente a los nuevos incluidos, vinculando su ID (`codigo_colegio`) con el identificador de la ejecución actual.
    - **Estudiantes Regulares y 5to. Año:** Realiza una búsqueda directa en la base de datos. Para alumnos de "**5to. Año**", se simplificó la lógica eliminando condiciones redundantes e integrando el filtro por secciones (`41, 42, 43`) directamente en las condiciones de búsqueda. El proceso asegura que la vista reciba toda la información necesaria para el reporte, incluyendo la detección de condiciones especiales y registros previos en `ListaAsegurados`.

## src/Controller/BillsController.php
    Controlador encargado de la lógica de facturación. Se modificó el método `recordInvoiceData` para recibir el concepto de descuento desde la vista y pasarlo al método `agregaNotaCreditoDescuentos`. Asimismo, se actualizó la acción `add` para recibir y persistir el atributo `condicion_especial` en el registro de la factura (`Bill`). 
    **Automatización de rastro técnico:** Se mejoró `agregaNotaCreditoDescuentos` para detectar automáticamente la condición "100% pago en divisas" de la factura origen; en tal caso, la nota de crédito registra proporcionalmente el `monto_divisas` y el `monto_igtf` (utilizando el porcentaje de IGTF enviado desde el cliente o un valor base del 3%), redondeando ambos valores a dos decimales para garantizar precisión contable. Además, se aseguró la transferencia de la `condicion_especial` durante la conversión de pedidos a facturas en las acciones `pedidoPorFactura` y `pedidoPorFacturaPlanificado`.

## src/Controller/ConceptsController.php
    Controlador que gestiona los conceptos de los documentos. Se actualizó la función `agregarConceptoNotaCreditoDescuento` para aceptar un concepto opcional. Si se proporciona, se usa como descripción del concepto; de lo contrario, se mantiene el valor por defecto "Descuento por pronto pago".

## js_csga/vite.config.js
    Archivo de configuración de Vite para la compilación de los assets modernos (React/ES6+). Define los puntos de entrada para el script principal (`main-script`) y los estilos (`main-style`). Se configuró la salida para generar archivos deterministas (`main-script.js` y `main-style.css`) que son compatibles con la estructura de directorios de CakePHP 3. Incluye la configuración necesaria para manejar dependencias externas como jQuery y asegura la limpieza del directorio de salida antes de cada compilación.

## src/Template/Studenttransactions/report_student_general.ctp
    Esta vista permite generar diferentes tipos de reportes relacionados con el seguro escolar de los estudiantes (Aseguradora, Solventes y Pendientes). El formulario cuenta con lógica dinámica en JavaScript para mostrar u ocultar campos obligatorios según el tipo de reporte seleccionado: el campo "Período escolar" se activa para reportes de solvencia o deudas, mientras que el campo "Tipo de estudiantes" (con opciones independientes para "Regulares" y "Nuevos") se habilita específicamente para el reporte de aseguradora, optimizando la interfaz de usuario.

## src/Model/Entity/ListaAsegurado.php
    Entidad que representa un registro individual de la tabla `lista_asegurados`. Define las propiedades accesibles y protege la clave primaria `certificado` de asignaciones masivas accidentales.

## src/Model/Table/ListaAseguradosTable.php
    Modelo de tabla para la gestión de datos en `lista_asegurados`. Configura la clave primaria personalizada (`certificado`), el campo de visualización (`asegurado`) y activa el comportamiento `Timestamp` para el manejo automático de fechas de creación y modificación. Incluye reglas de validación básica para todos los campos del esquema SQL proporcionado.

## src/Controller/StudenttransactionsController.php
    Se mejoró la acción `reporteParaAseguradora` para integrar la búsqueda en el modelo `ListaAsegurados`. Ahora el sistema filtra automáticamente a los estudiantes con condiciones especiales y detecta registros con instrucciones previas. **Automatización de Instrucciones:** Si un estudiante regular o de 5to. Año es encontrado en la lista pero su instrucción está vacía, el sistema actualiza automáticamente el registro en la tabla `lista_asegurados` asignando el valor correspondiente ("RENOVAR" o "EXCLUIR") según su condición, garantizando la integridad de los datos históricos.

## src/Controller/StudenttransactionsController.php
    Se unificó la lógica de generación del reporte para aseguradora. Para estudiantes de tipo "**Nuevo**", ahora se aplica la misma segmentación que para regulares: se identifican estudiantes con estatus distinto a "Regular" (condición especial) y se cruzan datos con la tabla `Excels`. Los alumnos ya procesados en envíos anteriores se separan en una colección independiente, permitiendo que el reporte principal contenga únicamente los registros pendientes por informar.

## src/Template/Studenttransactions/report_student_general.ctp
    Se mejoró la experiencia del usuario al visualizar el reporte para aseguradora mediante la adición de un título dinámico que indica el "**Tipo de estudiante**" procesado (Nuevo, Regular o 5to. Año). Este título utiliza la clase CSS `.noExl` para garantizar que sea visible únicamente en la interfaz web y no interfiera con el formato de los archivos Excel generados para la aseguradora.
