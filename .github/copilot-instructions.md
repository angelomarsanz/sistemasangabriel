# Directrices de Codificación para el Proyecto
  Este proyecto está codificado en Cakephp 3 y jquery

## CHAT IA
El chat de IA debe ser en idioma español

## Memoria de Sesiones y Protocolo ante Fallas Eléctricas/Conexión (Copilot y Copilot CLI)
- **Log de Progreso:** Cada vez que inicies una nueva sesión, debes leer obligatoriamente el archivo `LOG_DESARROLLO_REDA.md`. Esto te permitirá recordar automáticamente todos los trabajos realizados anteriormente sin que el usuario tenga que repetirlos.
- **Protocolo de Protección contra Cortes Eléctricos / Pérdida de Internet (`previo_cambios_realizados.md`):**
  Debido a fallas recurrentes de electricidad y conectividad en el entorno del usuario, se debe utilizar el archivo `previo_cambios_realizados.md` en la raíz del proyecto para registrar avances parciales:
  1. **Verificación Inicial:** Al inicio de CADA petición del usuario, leer obligatoriamente `previo_cambios_realizados.md` para verificar si quedó algún trabajo inconcluso por una interrupción imprevista. Si hay trabajo inconcluso, retomarlo inmediatamente en el punto exacto donde se detuvo.
  2. **Inicialización Limpia:** Si no hay trabajo inconcluso (o una vez resuelto y al arrancar una nueva solicitud), limpiar/reiniciar el archivo `previo_cambios_realizados.md` indicando la nueva tarea que se inicia, evitando así acumulación de contenido obsoleto o basura.
  3. **Registro Incremental en Caliente:** A medida que se avance y se modifique o cree cada archivo durante la tarea, actualizar de inmediato `previo_cambios_realizados.md` detallando la ruta del archivo y los cambios específicos realizados hasta ese momento.
  4. **Consolidación Definitiva:** Al finalizar satisfactoriamente toda la petición, redactar la documentación oficial en `LOG_DESARROLLO_REDA.md` y `manual_tecnico_sistema.md`, y restablecer `previo_cambios_realizados.md` a su estado limpio ("Sin tareas inconclusas").
- **Registro de Avances:** Al finalizar "CADA PETICIÓN" que haga el usuario en la línea de comandos de Copilot CLI o e en el prompt de Copilot se debe actualizar el archivo "LOG_DESARROLLO_REDA.md": Mencionar cada una de las rutas de los achivos que se modificaron o crearon y hacer un resumen técnico de los cambios que se realizaron en los archivos existentes o del código de los nuevos archivos creados. Así se podrá llevar un hilo de todas las modificacione que has realizado en la aplicación. Esta actividad debe ser ejecutada tanto si se está usando Copilot o como si se usa Copilot CLI que viene integrado con el IDE Cloud Editor.
- **Exportación de Conversaciones:** Para guardar el diálogo literal, utiliza el comando `/chat share last_chat_export.md` y luego ejecuta el script `./registrar_sesion.sh`.

## Interacción con la IA y Modo de Trabajo Autónomo
- **Ejecución Autónoma y Directa de Cambios:** Cuando el usuario solicite realizar cualquier cambio, ajuste o nueva funcionalidad, la IA debe trabajar de forma autónoma e independiente, aplicando las modificaciones y creando el código necesario de manera automática y directa en los archivos del proyecto, **SIN hacer pausas intermedias** ni detenerse a pedir que el usuario acepte o rechace el código paso a paso.

## Estilo de Código General
- Los comentarios deben estar en español.
- Usar nombres de variables descriptivos en español

## PHP
- Se debe usar php 7.4
- Se debe usar Cakephp 3.0
- Para la conexión a base de datos, usa la librería `PDO`. Nunca uses funciones antiguas como `mysql_*`.
- Cuando se ejecuta el comando "php" se ejecuta php versión 8.2.12 que es un alias en /home/angelomarsanz/.bashrc:
     alias php="/opt/lampp/bin/php"
- Si por alguna razón se necesita ejecutar php versión 7.4 este se encuentra en: 
    /opt/lampp74/bin/php

## NOTAS POR SI EN ALGÚN MOMENTO SE NECESITA CORRER LAMPP
En mi sistema operativo Debian 13:

En el archivo /home/angelomarsanz/.bashrc tengo estos alias:
    alias php="/opt/lampp/bin/php"
    alias composer="php /opt/lampp/composer.phar"
    alias idea="/home/angelomarsanz/intellijIdea/bin/./idea.sh"

    alias onlampp='sudo /opt/lampp/lampp start'
    alias offlampp='sudo /opt/lampp/lampp stop'

    # Alias para alternar entre versiones de XAMPP
    alias lampp74='sudo ~/scripts/lampp74.sh'
    alias lampp82='sudo ~/scripts/lampp82.sh'
    
Siempre tomará el php y el composer que están en /opt/lampp

Para conocer la versión de php:
    php -v

Para conocer la versión de composer:
    composer -v

En opt tengo dos carpetas:
    lampp74:
        Estan todos los archivos y programas en php 7.4 pero ya no se usa
    lampp:
        Estan todos los archivos y programas en php 8.2 

Php versión 8.2 se encuentra en:
    /opt/lampp/bin/php

Los scripts:
    /home/angelomarsanz/scripts/lampp74 (Se recomienda no ejecutar)
        #!/bin/bash

        # Detiene XAMPP si está corriendo
        echo "Deteniendo XAMPP..."
        sudo /opt/lampp/lampp stop

        # --- Lógica de cambio de versión ---

        # Verifica si la versión de XAMPP 7.4 ya está activa
        if [ -d "/opt/lampp" ] && [ -d "/opt/lampp/htdocs" ] && [ ! -d "/opt/lampp74" ]; then
            echo "¡XAMPP 7.4 ya está activo!"
            echo "Iniciando XAMPP con PHP 7.4..."
            sudo /opt/lampp/lampp start
            exit 0
        fi

        # Alterna las carpetas
        echo "Cambiando a XAMPP 7.4..."
        sudo mv /opt/lampp /opt/lampp82
        sudo mv /opt/lampp74 /opt/lampp

        # Inicia XAMPP
        echo "Iniciando XAMPP con PHP 7.4..."
        sudo /opt/lampp/lampp start
    /home/angelomarsanz/scripts/lampp82
        #!/bin/bash

        # Detiene XAMPP si está corriendo
        echo "Deteniendo XAMPP..."
        sudo /opt/lampp/lampp stop

        # --- Lógica de cambio de versión ---

        # Verifica si la versión de XAMPP 8.2 ya está activa
        if [ -d "/opt/lampp" ] && [ -d "/opt/lampp/htdocs" ] && [ ! -d "/opt/lampp82" ]; then
            echo "¡XAMPP 8.2 ya está activo!"
            echo "Iniciando XAMPP con PHP 8.2..."
            sudo /opt/lampp/lampp start
            exit 0
        fi

        # Alterna las carpetas
        echo "Cambiando a XAMPP 8.2..."
        sudo mv /opt/lampp /opt/lampp74
        sudo mv /opt/lampp82 /opt/lampp

        # Inicia XAMPP
        echo "Iniciando XAMPP con PHP 8.2..."
        sudo /opt/lampp/lampp start

## JavaScript
- Utiliza la sintaxis moderna de ES6+ (`const`, `let`, funciones flecha).
- Las vistas actuales, archivos (.ctp) en su mayoría tienen en el mismo archivo los estilos .css y el código javascript. Para nuevas vistas que se creen los estilos no se deben crear en el mismo archivo .ctp sino añadir a js_csga/src/index.css y luego insertar las clases .css correspondientes en la vista. Respecto al código javascript para cada nueva vista se deben crear un archivo .js en el directorio: js_csga/src/vistas/Directorio nombre del controlador, sin el prefijo "Controller" Ya existen algunas vistas con el directorio creado correspondiente al controlador

## Estilos CSS
- En este proyecto
  Usar Bootstrap 3 a través del plugin de Cakephp:
    vendor/friendsofcake/bootstrap-ui
Los nuevos estilos se deben añadir a:
js_csga/src/index.css
- No modificar directamente `webroot/css/main-style.css` ni `webroot/js/main-script.js`: son archivos generados por la compilación de Vite a partir de `js_csga/src/index.css` y `js_csga/src/main.jsx`. Realizar los cambios en esas fuentes. La compilación y copia de los artefactos para el despliegue se gestionan mediante `subir.sh`; no incluir ediciones manuales de los archivos generados.

## Diseño adaptable
- Todas las vistas nuevas o modificadas deben funcionar tanto en pantallas de escritorio como en celulares y tabletas.
- Usar la grilla y utilidades responsivas de Bootstrap 3, controles fluidos y tablas dentro de `.table-responsive` cuando corresponda.
- Evitar anchos fijos y comprobar que formularios, botones, paneles y contenido no generen desplazamiento horizontal en pantallas pequeñas.

## Documentación del sistema
Todos los archivos que se creen deben documentarse al inicio del archivo. Crear un resumen de lo que hace el archivo. Así también cada función que contenga ese archivo debe documentarse
Además de documentar individualmente cada archivo, cada vez que se cree un archivo se debe agregar un resumen de la documentación de ese archivo en manual_tecnico_sistema.md : Se coloca la ruta y el nombre del archivo como un título y luego dejando una sangría se coloca el resumen.
Si es un archivo que fue creado en el pasado, antes de implementar esta directriz y no tiene ninguna documentación al inicio del archivo y tampoco están documentadas sus funciones (en caso de que tenga funciones) entonces proceder a documentar el archivo y sus funciones y además agregar la documentación de ese archivo en el manual_tecnico_sistema.md
Si se modifica el archivo se debe modificar tanto el resumen que se hace directamente en el archivo como el resumen en el archivo manual_tecnico_sistema.md
Si se modifica alguna función de un archivo Javascript o Php también debe actualizarse la documentación de la función
