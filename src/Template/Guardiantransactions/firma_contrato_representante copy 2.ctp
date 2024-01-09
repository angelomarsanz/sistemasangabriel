<?php
    use Cake\I18n\Time;
    use Cake\Routing\Router;
?>
<style>
@media screen
{
    .boton_borrar
    {
        display:scroll;
        position:fixed;
        bottom: 60%;
        right: 5%;
        // opacity: 0.5;
        text-align: center;
    }
    .boton_guardar
    {
        display:scroll;
        position:fixed;
        bottom: 45%;
        right: 5%;
        // opacity: 0.5;
        text-align: center;
    }
    .mensaje_usuario
    {
        display:scroll;
        position:fixed;
        bottom: 10%;
        right: 5%;
        // opacity: 0.5;
        text-align: center;
    }
}
</style>
<br /><br />
<!-- Contenedor y Elemento Canvas -->
<div id="signature-pad" class="signature-pad" >
    <div class="description" style="width: 90%; margin-left: 10%;" >Por favor dibuje su firma:</div>
    <div class="signature-pad--body">
        <canvas style="width: 90%; margin-left: 10%; height: 420px; border: 1px black solid;" id="canvas"></canvas>
    </div>
    <div id="mensajes_usuario" class="alert alert-danger mensaje_usuario" style="display: none; width: 60%; margin-left: 20%;"></div>
</div>

<div class="row">
    <div class="boton_borrar"> 
        <button type="button" id="borrar" class="glyphicon glyphicon-erase btn btn-sm btn-default">Borrar</button>
    </div>
    <div class="boton_guardar">  
        <!-- Formulario que recoge los datos y los enviara al servidor -->
        <?= $this->Form->create("form", ["id" => "form"]) ?>
            <fieldset>
                <input type="hidden" name="id_representante" value="<?= $idRepresentante ?>">
                <input type="hidden" name="base64" value="" id="base64">
                <input type="hidden" name="ip_cliente" value="" id="ip_cliente">
            </fieldset>
            <?= $this->Form->button(__(' Guardar'), ['id' => 'guardar-firma', 'class' => 'glyphicon glyphicon-ok btn btn-sm btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php

function getRealIP()
{
    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}

$direccion_ip = getRealIP();
echo $direccion_ip; 
?>
<script type="text/javascript">

var wrapper = document.getElementById("signature-pad");

var canvas = wrapper.querySelector("canvas");
var objeto_firma_canvas = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)'
});

var user_ip = null;

var cantidad_trazos = 0;

window.onload = () => 
{
    const get_ip = async () => 
    {
        return await fetch('https://api.ipify.org?format=json')
        .then(response => response.json());
        }

    get_ip().then(response => 
    {
        user_ip = response.ip;
    }).catch(e => { 
        document.getElementById("mensajes_usuario").style.display ="block";
        document.getElementById("mensajes_usuario").innerHTML ="Estimado usuario no se pudo obtener su dirección IP por favor recargue o refresque la página";
    });
}

function resizeCanvas() {

  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);

  objeto_firma_canvas.clear();
  document.getElementById("mensajes_usuario").style.display ="none";
  cantidad_trazos = 0;
}

window.onresize = resizeCanvas;
resizeCanvas();

objeto_firma_canvas.addEventListener("beginStroke", () => {
  cantidad_trazos++;
});

document.getElementById("borrar").addEventListener("click",function(e)
{
    objeto_firma_canvas.clear();
    document.getElementById("mensajes_usuario").style.display ="none";
    cantidad_trazos = 0;
});

document.getElementById('form').addEventListener("submit",function(e)
{
    if (user_ip === null)
    {
        e.preventDefault();
        window.location.href = window.location.href;
    }
    else if (cantidad_trazos == 0)
    {
        document.getElementById("mensajes_usuario").style.display ="block";
        document.getElementById("mensajes_usuario").innerHTML = "Estimado usuario usted aún no ha dibujado su firma";
        e.preventDefault();
    }
    else
    {
        var imagen_firma = objeto_firma_canvas.toDataURL();
        document.getElementById('base64').value = imagen_firma;
        document.getElementById('ip_cliente').value = user_ip;
    }
},false);
</script>
