#!/bin/bash

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# Define aquí la lista de archivos PHP nuevos o modificados.
# Usa rutas relativas desde la raíz del proyecto.
ARCHIVOS_PHP_PUNTUALES=(
    # Ejemplo: "src/Model/Table/MiTabla.php"
    # Si no quieres subir ningún archivo PHP, deja solo "Ninguno"
    # "Ninguno"

    #"src/Controller/ParentsandguardiansController.php"
    "src/Controller/StudenttransactionsController.php"
    #"src/Controller/StudentsController.php"

    #"src/Template/Studenttransactions/general_morosidad_representantes.ctp"
    #"src/Template/Studenttransactions/reporte_general_morosidad_representantes.ctp"
    #"src/Template/Studenttransactions/consejo_educativo_por_cobrar.ctp"
    "src/Template/Parentsandguardians/consejo_educativo.ctp"
    #"src/Template/Parentsandguardians/partes/reporte_general_consejo_educativo.ctp"
)
