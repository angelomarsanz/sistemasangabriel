export const indexProductos = () => 
{
    (function( $ ) {
        const funcionExternaIndexProductos = () => {
            console.log('Hiciste clic en una card de producto');
        }
        const exportToExcel = () => {
            // Seleccionamos la tabla por su ID
            var table = document.getElementById("tabla-productos");
            
            // Creamos una copia de la tabla para limpiar la columna de "Acciones" antes de exportar
            var wb = XLSX.utils.table_to_book(table, { sheet: "Productos" });
            
            // Generamos el nombre del archivo con la fecha actual
            var date = new Date().toISOString().slice(0, 10);
            var fileName = "Reporte_Productos_" + date + ".xlsx";

            // Descargamos el archivo
            XLSX.writeFile(wb, fileName);
        }

        $(function() {
            if ($('#indexProductos').length > 0) 
            {
                console.log('indexProductos.length', $('#indexProductos').length)
                $(document).on('click', '#exportar-excel', function(e) {
                    e.preventDefault();
                    exportToExcel();
                });
            }
        });
    })(jQuery);
}
indexProductos();