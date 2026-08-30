# Log de Desarrollo - REDA

## [2026-08-30] - Implementación de concepto personalizado para descuentos
- **Tarea:** Agregar un campo de concepto para los descuentos/recargos en la creación de facturas.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se añadió una fila en la tabla de totales con un selector para el concepto del descuento.
        - Opciones añadidas: "Pronto pago", "Descuento pago año completo", "Personalizado".
        - Implementación de un modal Bootstrap para capturar el texto cuando se selecciona "Personalizado".
        - Actualización de la lógica JS para incluir `concepto_descuento` en el objeto de pago enviado al servidor.
    - **Backend (`src/Controller/BillsController.php`):**
        - Modificación de `recordInvoiceData` para recuperar el concepto del descuento.
        - Actualización de `agregaNotaCreditoDescuentos` para aceptar el concepto como parámetro.
    - **Backend (`src/Controller/ConceptsController.php`):**
        - Actualización de `agregarConceptoNotaCreditoDescuento` para usar el concepto proporcionado en lugar de un texto estático.
- **Documentación:** Actualización de `manual_tecnico_sistema.md`.
