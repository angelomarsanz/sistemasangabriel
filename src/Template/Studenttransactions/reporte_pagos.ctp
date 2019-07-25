<?php
    use Cake\I18n\Time;
?>

<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Reportes de Pagos Recibidos</h2>
    	</div>
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
                echo $this->Form->input('concepto', ['required' => 'required', 'label' => 'Concepto', 'options' => 
                    [null => '',
                    'Matrícula' => 'Matrícula',
					'Ene' => 'Mes Enero',
					'Feb' => 'Mes Febrero',
					'Mar' => 'Mes Marzo',
					'Abr' => 'Mes Abril',
					'May' => 'Mes Mayo',
					'Jun' => 'Mes Junio',
					'Jul' => 'Mes Julio',
					'Ago' => 'Mes Agosto',
					'Sep' => 'Mes Septiembre',
					'Oct' => 'Mes Octubre',
					'Nov' => 'Mes Noviembre',
					'Dic' => 'Mes Diciembre',
                    'Seguro escolar' => 'Seguro escolar',
                    'Servicio educativo' => 'Servicio educativo',
					'Thales' => 'Thales']]); 
			?>
				<div id="mensaje-concepto" class="mensajes-usuario"></div>
			<?php 
               	echo $this->Form->input('ano_concepto', ['label' => 'Del año: ', 'options' => 
                    [null => '',
                    '2018' => '2018',
                    '2019' => '2019',
					'2020' => '2020',
					'2021' => '2021',
					'2022' => '2022']]);
            ?>
				<div id="mensaje-ano-concepto" class="mensajes-usuario"></div>
        </fieldset>
		<br />
        <?= $this->Form->button(__('Emitir'), ['id' => 'emitir', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>   
    $(document).ready(function() 
    {	
		$("#emitir").click(function(e)
		{
			error = 0;
			$('.mensajes-usuario').html("");
			$('.campo-resaltado').css('background-color', "white");
			
			if ($("#concepto").val().length < 1)
			{
				$('#concepto').css('background-color', "#ffffe6");
				$('#mensaje-concepto').html("Por favor seleccione un concepto").css('color', 'red');
				error = 1;	
			}
			if ($("#ano-concepto").val().length < 1)
			{
				$('#ano-concepto').css('background-color', "#ffffe6");
				$('#mensaje-ano-concepto').html("Por favor seleccione un año").css('color', 'red');
				error = 1;	
			}
			if (error > 0)
			{
				alert("Estimado usuario faltan uno o más datos. Por favor revise");
				return false;
			}
		});
    });
</script>