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
    - **Backend (`src/Controller/StudenttransactionsController.php`):**
        - Se modificó la acción `edit` para recibir la propiedad `condicionEspecial` y guardarla en la columna `condicion_especial` de la tabla `studenttransactions`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` con los detalles de persistencia de la condición especial.

## [2026-09-03] - Depuración de opciones de concepto de descuento
- **Tarea:** Eliminar opciones obsoletas o redundantes del selector de conceptos de descuento.
- **Cambios Realizados:**
    - **UI (`src/Template/Bills/create_invoice.ctp`):**
        - Se eliminaron las opciones "Descuento" y "Concepto personalizado" del input select `concepto_descuento`.
- **Documentación:** Actualización de `manual_tecnico_sistema.md` para reflejar la lista simplificada de conceptos disponibles.

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

