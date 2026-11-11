#!/bin/bash

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# Define aquí la lista de archivos PHP nuevos o modificados.
# Usa rutas relativas desde la raíz del proyecto.
ARCHIVOS_PHP_PUNTUALES=(
    # Ejemplo: "src/Model/Table/MiTabla.php"
    # Si no quieres subir ningún archivo PHP, deja solo "Ninguno"
    # "Ninguno"

    ".github/copilot-instructions.md"
    #"subir.sh"
    #"archivos_a_subir.sh"
    #"js_csga/vite.config.js"
    "manual_tecnico_sistema.md"
    "LOG_DESARROLLO_REDA.md"
    #"registrar_sesion.sh"

    # Archivos .css de Vite modificados
    #"js_csga/src/index.css"
    #"js_csga/dist/main-style.css"
    #"webroot/css/main-style.css"
    
    # Archivos .jsx y .js creados y/o modificados
    #"js_csga/src/main.jsx"
    #"js_csga/dist/main-script.js"
    #"webroot/js/main-script.js"

    # Modelos creados y/o modificados

    # Vistas creadas y/o modificadas

    # Controladores creados y/o modificados
    "src/Controller/TurnsController.php"
)
