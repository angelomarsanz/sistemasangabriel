<?php
    use Cake\I18n\Time;
    use Cake\Routing\Router;
?>
<style>
@media screen
{
	canvas 
	{
        width: 500px;
        height: 500px;
    	border: 1px solid black;
	}	
}
@media print
{
    .noVerImpreso
    {
      display:none
    }
}
</style>
<canvas id="pizarra"></canvas>
<br />
<?= $this->Html->link('Borrar', ['controller' => 'Guardiantransactions', 'action' => 'contratoRepresentante', $idRepresentante], ['class' => 'btn btn-success noVerImpreso']); ?>
<br />
<?= $this->Form->create("form", ["id" => "form"]) ?>
	<fieldset>
        <input type="hidden" name="id_representante" value="<?= $idRepresentante ?>">
        <input type="hidden" name="base64" value="" id="base64">
    </fieldset>
   	<?= $this->Form->button(__('Guardar'), ['id' => 'guardar-firma', 'class' =>'btn btn-success']) ?>
<?= $this->Form->end() ?>
<script>
    //======================================================================
    // VARIABLES DISPOSITIVOS
    //======================================================================
    let miCanvas = document.querySelector('#pizarra');
    let botonBorrar = document.querySelector("#botonBorrar")
    let lineas = [];
    let correccionX = 0;
    let correccionY = 0;
    let pintarLinea = false;
    // Marca el nuevo punto
    let nuevaPosicionX = 0;
    let nuevaPosicionY = 0;

    let posicion = miCanvas.getBoundingClientRect()
    correccionX = posicion.x;
    correccionY = posicion.y;

    miCanvas.width = 500;
    miCanvas.height = 500;

    //======================================================================
    // VARIABLES PC
    //======================================================================

    const $canvas = document.querySelector("#pizarra");
    const contexto = $canvas.getContext("2d");
    const COLOR_PINCEL = "black";
    const COLOR_FONDO = "white";
    const GROSOR = 2;
    let xAnterior = 0, yAnterior = 0, xActual = 0, yActual = 0;
    const obtenerXReal = (clientX) => clientX - $canvas.getBoundingClientRect().left;
    const obtenerYReal = (clientY) => clientY - $canvas.getBoundingClientRect().top;
    let haComenzadoDibujo = false; // Bandera que indica si el usuario está presionando el botón del mouse sin soltarlo

    //======================================================================
    // OTRAS CONSTANTES Y VARIABLES
    //======================================================================
    

    //======================================================================
    // FUNCIONES DISPOSITIVOS
    //======================================================================

    /**
     * Funcion que empieza a dibujar la linea
     */
    function empezarDibujo () {
        pintarLinea = true;
        lineas.push([]);
    };
    
    /**
     * Funcion que guarda la posicion de la nueva línea
     */
    function guardarLinea() {
        lineas[lineas.length - 1].push({
            x: nuevaPosicionX,
            y: nuevaPosicionY
        });
    }

    /**
     * Funcion dibuja la linea
     */
    function dibujarLinea (event) {
        event.preventDefault();
        if (pintarLinea) {
            let ctx = miCanvas.getContext('2d')
            // Estilos de linea
            ctx.lineJoin = ctx.lineCap = 'round';
            ctx.lineWidth = 10;
            // Color de la linea
            ctx.strokeStyle = 'black';
            // Marca el nuevo punto
            if (event.changedTouches == undefined) {
                // Versión ratón
                nuevaPosicionX = event.layerX;
                nuevaPosicionY = event.layerY;
            } else {
                // Versión touch, pantalla tactil
                nuevaPosicionX = event.changedTouches[0].pageX - correccionX;
                nuevaPosicionY = event.changedTouches[0].pageY - correccionY;
            }
            // Guarda la linea
            guardarLinea();
            // Redibuja todas las lineas guardadas
            ctx.beginPath();
            lineas.forEach(function (segmento) {
                ctx.moveTo(segmento[0].x, segmento[0].y);
                segmento.forEach(function (punto, index) {
                    ctx.lineTo(punto.x, punto.y);
                });
            });
            ctx.stroke();
        }
    }

    /**
     * Funcion que deja de dibujar la linea
     */
    function pararDibujar () {
        pintarLinea = false;
        guardarLinea();
    }

    //======================================================================
    // EVENTOS DISPOSITIVOS
    //======================================================================

    miCanvas.addEventListener('touchstart', empezarDibujo, false);
    miCanvas.addEventListener('touchmove', dibujarLinea, false);

    //======================================================================
    // FUNCIONES PC
    //======================================================================

    $canvas.addEventListener("mousedown", evento => {
    // En este evento solo se ha iniciado el clic, así que dibujamos un punto
    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(evento.clientX);
    yActual = obtenerYReal(evento.clientY);
    contexto.beginPath();
    contexto.fillStyle = COLOR_PINCEL;
    contexto.fillRect(xActual, yActual, GROSOR, GROSOR);
    contexto.closePath();
    // Y establecemos la bandera
    haComenzadoDibujo = true;
    });

    $canvas.addEventListener("mousemove", (evento) => {
    if (!haComenzadoDibujo) {
        return;
    }
    // El mouse se está moviendo y el usuario está presionando el botón, así que dibujamos todo

    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(evento.clientX);
    yActual = obtenerYReal(evento.clientY);
    contexto.beginPath();
    contexto.moveTo(xAnterior, yAnterior);
    contexto.lineTo(xActual, yActual);
    contexto.strokeStyle = COLOR_PINCEL;
    contexto.lineWidth = GROSOR;
    contexto.stroke();
    contexto.closePath();
    });

    ["mouseup", "mouseout"].forEach(nombreDeEvento => {
        $canvas.addEventListener(nombreDeEvento, () => {
            haComenzadoDibujo = false;
        });
    });

    //======================================================================
    // OTRAS FUNCIONES
    //======================================================================

    document.getElementById('form').addEventListener("submit",function(e){
      var image = $canvas.toDataURL(); // data:image/png....
      document.getElementById('base64').value = image;
   },false);

</script>