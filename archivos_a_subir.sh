#!/bin/bash

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# Define aquí la lista de archivos PHP nuevos o modificados.
# Usa rutas relativas desde la raíz del proyecto.
ARCHIVOS_PHP_PUNTUALES=(
    # Ejemplo: "src/Model/Table/MiTabla.php"
    # Si no quieres subir ningún archivo PHP, deja solo "Ninguno"
    # "Ninguno"

    #"src/Model/Entity/Parentsandguardian.php"
    #"src/Model/Table/ParentsandguardiansTable.php"

    #"js_csga/src/index.css"
    #"src/Template/Guardiantransactions/home_screen.ctp"
    #"src/Template/Parentsandguardians/edit.ctp"
    #"src/Template/Guardiantransactions/contrato_representante_2026.ctp"
    #"src/Template/Guardiantransactions/contrato_representante_2027.ctp"
    #"src/Template/Students/filepdf.ctp"
    #"src/Template/Turns/index.ctp"
    "src/Template/Bills/create_invoice.ctp"

    #"src/Controller/GuardiantransactionsController.php"
    #"src/Controller/ParentsandguardiansController.php"
    #"src/Controller/RatesController.php"
    "src/Controller/BillsController.php"
    "src/Controller/ParentsandguardiansController.php"
)
