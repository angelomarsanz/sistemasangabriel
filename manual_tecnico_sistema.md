# Manual Técnico del Sistema San Gabriel

## src/Template/Bills/create_invoice.ctp
    Este archivo maneja la vista para la creación de facturas y recibos. Se actualizó la sección de totales para incluir un título informativo "**Descuentos/Recargos**". El campo de selección de concepto ahora ofrece las opciones: "Descuento", "Descuento por meses no cursados", "Descuento por pago año completo", "Descuento pronto pago" (por defecto) y "Concepto personalizado". La etiqueta del input de descuento/recargo se simplificó a "**Tipo**". Se eliminaron las líneas divisorias internas de esta sección para una interfaz más limpia. La lógica de JavaScript maneja la captura de conceptos personalizados mediante un modal y asegura que el valor se transmita correctamente al proceso de facturación.

## src/Controller/BillsController.php
    Controlador encargado de la lógica de facturación. Se modificó el método `recordInvoiceData` para recibir el concepto de descuento desde la vista y pasarlo al método `agregaNotaCreditoDescuentos`. Este último método ahora recibe el concepto y lo propaga al controlador de conceptos para su registro en la nota de crédito correspondiente.

## src/Controller/ConceptsController.php
    Controlador que gestiona los conceptos de los documentos. Se actualizó la función `agregarConceptoNotaCreditoDescuento` para aceptar un concepto opcional. Si se proporciona, se usa como descripción del concepto; de lo contrario, se mantiene el valor por defecto "Descuento por pronto pago".
