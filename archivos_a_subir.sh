#!/bin/bash

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# Define aquí la lista de archivos PHP nuevos o modificados.
# Usa rutas relativas desde la raíz del proyecto.
ARCHIVOS_PHP_PUNTUALES=(
    # Ejemplo: "src/Model/Table/MiTabla.php"
    # Si no quieres subir ningún archivo PHP, deja solo "Ninguno"
    # "Ninguno"

    "LOG_DESARROLLO_REDA.md"
    "manual_tecnico_sistema.md"
    ".github/copilot-instructions.md"
    "registrar_sesion.sh"
    "subir.sh"
    "archivos_a_subir.sh"

    "src/Template/Bills/create_invoice.ctp"
    #"src/Controller/BillsController.php"
    #"src/Controller/ConceptsController.php"
)
