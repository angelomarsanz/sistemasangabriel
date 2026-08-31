# Directrices de Codificación para el Proyecto
  Este proyecto está codificado en Cakephp 3 y jquery

## CHAT IA
El chat de IA debe ser en idioma español

## Memoria de Sesiones (Gemini CLI)
- **Log de Progreso:** Cada vez que inicies una nueva sesión, debes leer obligatoriamente el archivo `LOG_DESARROLLO_REDA.md`. Esto te permitirá recordar automáticamente todos los trabajos realizados anteriormente sin que el usuario tenga que repetirlos.
- **Registro de Avances:** Al finalizar una tarea importante, actualiza dicho archivo con un resumen técnico de los cambios.
- **Exportación de Conversaciones:** Para guardar el diálogo literal, utiliza el comando `/chat share last_chat_export.md` en la terminal de Gemini CLI y luego ejecuta el script `./registrar_sesion.sh` en la terminal de la aplicación.

## Estilo de Código General
- Los comentarios deben estar en español.
- Usar nombres de variables descriptivos en español

## PHP
- Se debe usar php 7.4
- Se debe usar Cakephp 3.0
- Para la conexión a base de datos, usa la librería `PDO`. Nunca uses funciones antiguas como `mysql_*`.
- Para ejecutar comandos php, usar phpact en lugar de php

## JavaScript
- Utiliza la sintaxis moderna de ES6+ (`const`, `let`, funciones flecha).
- Las vistas actuales, archivos (.ctp) en su mayoría tienen en el mismo archivo los estilos .css y el código javascript. Para nuevas vistas que se creen los estilos no se deben crear en el mismo archivo .ctp sino añadir a js_csga/src/index.css y luego insertar las clases .css correspondientes en la vista. Respecto al código javascript para cada nueva vista se deben crear un archivo .js en el directorio: js_csga/src/vistas/Directorio nombre del controlador, sin el prefijo "Controller" Ya existen algunas vistas con el directorio creado correspondiente al controlador

## Estilos CSS
- En este proyecto
  Usar Bootstrap 3 a través del plugin de Cakephp:
    vendor/friendsofcake/bootstrap-ui
Los nuevos estilos se deben añadir a:
js_csga/src/index.css

## Documentación del sistema
Todos los archivos que se creen deben documentarse al inicio del archivo. Crear un resumen de lo que hace el archivo. Así también cada función que contenga ese archivo debe documentarse
Además de documentar individualmente cada archivo, cada vez que se cree un archivo se debe agregar un resumen de la documentación de ese archivo en manual_tecnico_sistema.md : Se coloca el nombre del archivo como un título y luego dejando una sangría se coloca el resumen.
Si se modifica el archivo se debe modificar tanto el resumen que se hace directamente en el archivo como el resumen en el archivo manual_tecnico_sistema.md
Si se modifica alguna función de un archivo Javascript o Php también debe actualizarse la documentación de la función
