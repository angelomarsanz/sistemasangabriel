# Manual Técnico del Sistema San Gabriel

## src/Template/Bills/create_invoice.ctp
    Este archivo maneja la vista para la creación de facturas y recibos. Se actualizó para incluir un campo de selección de concepto para descuentos y recargos, con soporte para conceptos personalizados mediante un modal. También se actualizó la lógica de JavaScript para capturar y enviar este concepto al controlador.

## src/Controller/BillsController.php
    Controlador encargado de la lógica de facturación. Se modificó el método `recordInvoiceData` para recibir el concepto de descuento desde la vista y pasarlo al método `agregaNotaCreditoDescuentos`. Este último método ahora recibe el concepto y lo propaga al controlador de conceptos para su registro en la nota de crédito correspondiente.

## src/Controller/ConceptsController.php
    Controlador que gestiona los conceptos de los documentos. Se actualizó la función `agregarConceptoNotaCreditoDescuento` para aceptar un concepto opcional. Si se proporciona, se usa como descripción del concepto; de lo contrario, se mantiene el valor por defecto "Descuento por pronto pago".
