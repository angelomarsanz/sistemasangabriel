#!/bin/bash

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# Define aquí la lista de archivos PHP nuevos o modificados.
# Usa rutas relativas desde la raíz del proyecto.
ARCHIVOS_PHP_PUNTUALES=(
    # Ejemplo: "src/Model/Table/MiTabla.php"
    # Si no quieres subir ningún archivo PHP, deja solo "Ninguno"
    # "Ninguno"
    "src/Controller/ProductosController.php"
    "src/Model/Table/ProductosTable.php"
    "src/Model/Entity/Producto.php"
    "src/Template/Productos/index.ctp"
    "js_csga/src/vistas/Productos/indexProductos.js"
)