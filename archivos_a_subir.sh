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

    #"js_csga/dist/main-style.css"
    #"js_csga/dist/main-script.js"

    "src/Controller/BillsController.php"
    "src/Controller/TurnsController.php"
    "src/Controller/UsersController.php"
    "src/Template/Bills/retorno_impresion.ctp"
    "src/Template/Bills/index.ctp"

    "src/Controller/StudenttransactionsController.php"
    "src/Template/Studenttransactions/general_morosidad_representantes.ctp"
    "src/Template/Studenttransactions/reporte_general_morosidad_representantes.ctp"
)
