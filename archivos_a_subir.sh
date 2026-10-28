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
    "js_csga/src/index.css"
    "js_csga/dist/main-style.css"
    
    # Archivos .jsx y .js creados y/o modificados
    #"js_csga/src/main.jsx"
    #"js_csga/dist/main-script.js"

    #"src/Model/Entity/User.php"
    #"src/Model/Entity/Parentsandguardian.php"
    #"src/Model/Entity/Student.php"

    #"src/Template/Students/edit_status.ctp"
    #"src/Template/Bills/create_invoice.ctp"
    #"src/Template/Parentsandguardians/consult_family.ctp"
    #"src/Template/Studenttransactions/reporte_general_morosidad_representantes.ctp"
    #"src/Template/Parentsandguardians/view_data.ctp"
    "src/Template/Students/view_student.ctp"

    #"src/Controller/StudenttransactionsController.php"
    #"src/Controller/ParentsandguardiansController.php"
    #"src/Controller/PaymentsController.php"
    "src/Controller/StudentsController.php"
)
