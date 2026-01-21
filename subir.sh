#!/bin/bash

# Colores para una mejor legibilidad
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# --- Carga de Configuración Segura ---
if [ -f .env.sh ]; then
    source .env.sh
else
    echo -e "${RED}Error: Archivo de configuración .env.sh no encontrado.${NC}"
    echo "Por favor, crea un archivo .env.sh con las credenciales FTP."
    exit 1
fi

# --- 1. SELECCIÓN DE AMBIENTE ---
echo -e "${YELLOW}¿A qué ambiente desea subir los archivos?${NC}"
read -p "Escriba 'P' para Producción o 'D' para Desarrollo: " AMBIENTE

case $AMBIENTE in
    [pP])
        FTP_HOST=$PROD_FTP_HOST
        FTP_USER=$PROD_FTP_USER
        FTP_PASS=$PROD_FTP_PASS
        REMOTE_DIR=$PROD_REMOTE_DIR
        echo -e "${GREEN}--- Desplegando en el servidor de PRODUCCIÓN ---${NC}"
        ;;
    [dD])
        FTP_HOST=$DEV_FTP_HOST
        FTP_USER=$DEV_FTP_USER
        FTP_PASS=$DEV_FTP_PASS
        REMOTE_DIR=$DEV_REMOTE_DIR
        echo -e "${GREEN}--- Desplegando en el servidor de DESARROLLO ---${NC}"
        ;;
    *)
        echo -e "${RED}Opción no válida. Abortando despliegue.${NC}"
        exit 1
        ;;
esac

# --- 2. COMPILACIÓN Y SUBIDA DE ASSETS (JS/CSS) ---
read -p "¿Desea compilar y subir los archivos JavaScript/CSS? (S/N): " COMPILAR_ASSETS

if [[ "$COMPILAR_ASSETS" =~ ^[sS]$ ]]; then
    echo -e "${YELLOW}Ejecutando compilación y preparación de assets...${NC}"
    # Nos posicionamos en el directorio de JS para ejecutar la compilación y luego volvemos
    (cd js_csga && npm run build)
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error durante la compilación de assets con 'npm run build'. Abortando.${NC}"
        exit 1
    fi
    echo -e "${GREEN}Compilación y preparación local finalizada.${NC}"

    echo -e "${YELLOW}Subiendo assets (JS/CSS) al servidor...${NC}"
    # Respaldamos los archivos existentes y luego subimos los nuevos.
    lftp -c "set ftp:ssl-allow no; open -u $FTP_USER,$FTP_PASS $FTP_HOST; \
             mkdir -p old; \
             (mv webroot/js/main-script.js old/main-script.js || true); put -O webroot/js/ webroot/js/main-script.js; \
             (mv webroot/css/main-style.css old/main-style.css || true); put -O webroot/css/ webroot/css/main-style.css;"

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Assets subidos correctamente.${NC}"
    else
        echo -e "${RED}Error al subir los assets. Revisa la salida de lftp.${NC}"
        exit 1
    fi
else
    echo "Se omite la compilación y subida de assets."
fi

echo "" # Línea en blanco para separar secciones

# --- 3. SUBIDA DE ARCHIVOS PHP PUNTUALES ---

# La lista de archivos a subir ahora se gestiona en 'archivos_a_subir.sh'
source ./archivos_a_subir.sh

# Comprobar si se debe ejecutar la subida de archivos puntuales
if [[ ${#ARCHIVOS_PHP_PUNTUALES[@]} -eq 1 && "${ARCHIVOS_PHP_PUNTUALES[0]}" == "Ninguno" ]]; then
    echo "No se especificaron archivos PHP para subir. Se omite este paso."
else
    echo -e "${YELLOW}Subiendo archivos PHP puntuales al servidor...${NC}"

    # Construir la lista de comandos para lftp
    lftp_commands="set ftp:ssl-allow no; open -u $FTP_USER,$FTP_PASS $FTP_HOST;"

    for archivo in "${ARCHIVOS_PHP_PUNTUALES[@]}"; do
        if [ -f "$archivo" ]; then
            # Obtener el directorio del archivo para crearlo en el servidor remoto
            nombre_archivo=$(basename "$archivo")
            directorio_remoto=$(dirname "$archivo")
            nombre_respaldo="$nombre_archivo" # Nombre de respaldo por defecto

            # Si es un archivo .ctp, usar el nombre de la carpeta como prefijo
            if [[ "$nombre_archivo" == *.ctp ]]; then
                nombre_carpeta_contenedora=$(basename "$directorio_remoto")
                nombre_respaldo="${nombre_carpeta_contenedora}_${nombre_archivo}"
            fi
            
            # Añadir comandos para respaldar, crear el directorio y subir el archivo
            lftp_commands+="mkdir -p old;"
            lftp_commands+="(mv '${archivo}' 'old/${nombre_respaldo}' || true);"
            lftp_commands+="mkdir -p '${directorio_remoto}';" # Asegurarse de que el directorio exista
            lftp_commands+="put -O '${directorio_remoto}/' '${archivo}';"
            echo " -> Preparando para subir: $archivo"
        else
            echo -e "${RED}Advertencia: El archivo '$archivo' no existe localmente y será ignorado.${NC}"
        fi
    done

    # Ejecutar todos los comandos de lftp de una vez
    lftp -c "$lftp_commands"

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}Archivos PHP subidos correctamente.${NC}"
    else
        echo -e "${RED}Error al subir archivos PHP. Revisa la salida de lftp.${NC}"
        exit 1
    fi
fi

echo -e "${GREEN}--- Proceso de despliegue finalizado ---${NC}"
