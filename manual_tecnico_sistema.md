# Manual Técnico del Sistema San Gabriel

## src/Template/Bills/create_invoice.ctp
    Este archivo maneja la vista para la creación de facturas y recibos. Se actualizó la sección de totales para incluir un título informativo "**Descuentos/Recargos**". El campo de selección de concepto ofrece varias opciones de descuento y una lógica de habilitación dinámica para los campos de tipo y cantidad. Al guardar la factura, se calcula el monto neto y, si se aplica un descuento, se determina el porcentaje de pago realizado en divisas. Esta información se registra en el atributo `condicion_especial` tanto de la factura como de cada una de las transacciones asociadas, permitiendo mantener un rastro detallado del beneficio aplicado y la modalidad de pago.

## src/Controller/StudenttransactionsController.php
    Controlador que gestiona las transacciones de los estudiantes. Se actualizó la acción `edit` para permitir la recepción y persistencia del campo `condicion_especial`. Durante el proceso de registro de datos de facturación, el controlador extrae este valor del objeto de transacción recibido y lo guarda en la base de datos, facilitando el seguimiento de beneficios especiales aplicados a las mensualidades de los alumnos. El archivo también contiene lógica para la creación masiva de cuotas (inscripción, seguro, mensualidades), ajustes de morosidad y reportes de cobranza.

## src/Controller/BillsController.php
    Controlador encargado de la lógica de facturación. Se modificó el método `recordInvoiceData` para recibir el concepto de descuento desde la vista y pasarlo al método `agregaNotaCreditoDescuentos`. Asimismo, se actualizó la acción `add` para recibir y persistir el atributo `condicion_especial` en el registro de la factura (`Bill`). 
    **Automatización de rastro técnico:** Se mejoró `agregaNotaCreditoDescuentos` para detectar automáticamente la condición "100% pago en divisas" de la factura origen; en tal caso, la nota de crédito registra proporcionalmente el `monto_divisas` y el `monto_igtf` (utilizando el porcentaje de IGTF enviado desde el cliente o un valor base del 3%), redondeando ambos valores a dos decimales para garantizar precisión contable. Además, se aseguró la transferencia de la `condicion_especial` durante la conversión de pedidos a facturas en las acciones `pedidoPorFactura` y `pedidoPorFacturaPlanificado`.

## src/Controller/ConceptsController.php
    Controlador que gestiona los conceptos de los documentos. Se actualizó la función `agregarConceptoNotaCreditoDescuento` para aceptar un concepto opcional. Si se proporciona, se usa como descripción del concepto; de lo contrario, se mantiene el valor por defecto "Descuento por pronto pago".

## js_csga/vite.config.js
    Archivo de configuración de Vite para la compilación de los assets modernos (React/ES6+). Define los puntos de entrada para el script principal (`main-script`) y los estilos (`main-style`). Se configuró la salida para generar archivos deterministas (`main-script.js` y `main-style.css`) que son compatibles con la estructura de directorios de CakePHP 3. Incluye la configuración necesaria para manejar dependencias externas como jQuery y asegura la limpieza del directorio de salida antes de cada compilación.
