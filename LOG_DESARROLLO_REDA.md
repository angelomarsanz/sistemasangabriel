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
