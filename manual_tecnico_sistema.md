# Manual Técnico del Sistema San Gabriel

## src/Template/Bills/create_invoice.ctp
    Este archivo maneja la vista para la creación de facturas y recibos. Se actualizó la sección de totales para incluir un título informativo "**Descuentos/Recargos**". El campo de selección de concepto ofrece varias opciones de descuento y una lógica de habilitación dinámica para los campos de tipo y cantidad. Al guardar la factura, se calcula el monto neto y, si se aplica un descuento, se determina el porcentaje de pago realizado en divisas. Esta información se registra en el atributo `condicion_especial` tanto de la factura como de cada una de las transacciones asociadas, permitiendo mantener un rastro detallado del beneficio aplicado y la modalidad de pago.

## src/Controller/StudenttransactionsController.php
    Controlador que gestiona las transacciones de los estudiantes. Se actualizó la acción `edit` para permitir la recepción y persistencia del campo `condicion_especial`. Durante el proceso de registro de datos de facturación, el controlador extrae este valor del objeto de transacción recibido y lo guarda en la base de datos.
    **Seguimiento de Reportes de Seguro:** Se mejoró significativamente la función `reporteParaAseguradora` para implementar un sistema de trazabilidad diferenciado según el tipo de estudiante:
    - **Estudiantes Nuevos:** Implementa un sistema de trazabilidad incremental. El sistema carga el registro de la institución (ID 2 de la tabla `schools`) y gestiona un historial en la columna `ejecucion_reporte_seguro` (formato JSON), asignando un identificador único con la estructura `{consecutivo}_nuevo_{fecha_hora}`. Para evitar duplicidades, el controlador verifica qué estudiantes no han sido registrados previamente en la tabla `excels` y guarda automáticamente a los nuevos incluidos, vinculando su ID (`codigo_colegio`) con el identificador de la ejecución actual. Se aseguró que el arreglo de retorno siempre incluya la clave `estudiantesNoEncontradosSeguro` para evitar errores de índice.
    - **Estudiantes Regulares y 5to. Año:** Realiza una búsqueda directa en la base de datos. Para alumnos de "**5to. Año**", se simplificó la lógica eliminando condiciones redundantes e integrando el filtro por secciones (`41, 42, 43`) directamente en las condiciones de búsqueda. El proceso asegura que la vista reciba toda la información necesaria para el reporte, incluyendo la detección de condiciones especiales y registros previos en `ListaAsegurados`.
    - **Segmentación Quirúrgica (Nuevas Reglas):** 
        1. **Nuevos:** Los estudiantes encontrados en `Excels` van al reporte de "Ambas Listas", el resto al primer reporte.
        2. **Regulares:** Solo se imprimen en el primer reporte los que NO existen en `ListaAsegurados`. Los encontrados en ambas listas se mueven al reporte de "Ambas Listas".
        3. **5to. Año:** No se imprime ningún registro en el primer reporte. Los encontrados en ambas listas van al reporte de "Ambas Listas" y los no encontrados al reporte de "No Encontrados".
    **Identificación Flexible en Reporte de Seguro:** Se robusteció la lógica de coincidencia en la función `reporteParaAseguradora` para los estudiantes Regulares y de 5to. Año:
    - **Coincidencia de Identidad:** Ahora se compara el campo `cedu_rif` de la aseguradora con el formato `T-IDENTIDAD` (ej: V-12345678). Se aplica `trim()` y `strtoupper()` a ambos lados de la comparación (tanto al registro de la aseguradora como a los campos `identity_card` y `type_of_identification` del sistema) para eliminar espacios en blanco accidentales y garantizar insensibilidad a mayúsculas/minúsculas.
    - **Coincidencia de Nombres:** Se implementó un sistema de búsqueda multinivel:
        1. **Combinaciones de Orden:** Generación de 6 variantes (Nombre Apellido, Apellido Nombre, etc.).
        2. **Bolsa de Palabras (Word Bag):** Intersección de términos principales (> 2 caracteres), requiriendo mínimo 3 coincidencias.
        3. **Insensibilidad a Acentos y Mayúsculas:** Mediante el método `normalizarTexto`.
    **Integración de Secciones y Automatización:** Se integró el modelo `Sections` en todas las consultas de búsqueda de estudiantes mediante la cláusula `contain`, permitiendo recuperar el nombre completo de la sección (`full_name`). Además, se mejoró la integración con `ListaAsegurados`: si un estudiante regular o de 5to. Año es encontrado en la lista, se actualiza automáticamente el registro asignando "RENOVAR" o "EXCLUIR" si la instrucción estaba vacía.

## src/Template/Studenttransactions/report_student_general.ctp
    Esta vista permite generar diferentes tipos de reportes relacionados con el seguro escolar de los estudiantes (Aseguradora, Solventes y Pendientes). El formulario cuenta con lógica dinámica en JavaScript para gestionar la visibilidad de los campos según el tipo de reporte.
    **Mejoras en Reporte para Aseguradora:**
    - **Segmentación Visual:** Se renombró la tabla de instrucciones actualizadas a "**Estudiantes encontrados en las listas del colegio y del seguro (Registros encontrados)**".
    - **Estandarización de Columnas:** Las tablas de control (Encontrados en Ambas Listas y No Encontrados) ahora cuentan con el formato completo de 21 columnas idéntico a la tabla principal de la aseguradora, permitiendo una visualización exhaustiva de los datos del titular y el representante en todos los segmentos.
    - **Nombre de Sección:** Se utiliza el nombre completo de la sección (`section->full_name`) en todos los listados para una identificación precisa por nivel y subnivel.
