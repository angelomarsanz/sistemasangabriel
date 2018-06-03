<?php 
use Cake\I18n\Time;
?>
<style>
@media screen
{
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
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Crear Nómina</h3>
	    </div>
	    <?= $this->Form->create($paysheet) ?>
	        <fieldset>
		    	<?php
					setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
					date_default_timezone_set('America/Caracas');
					
					$currentDate = time::now();
					
					echo $this->Form->input('date_from', ['label' => 'Fecha de inicio de la nómina: ', 
						'type' => 'date',
						'value' => $currentDate,
						'monthNames' =>
						['01' => 'Enero',
						'02' => 'Febrero',
						'03' => 'Marzo',
						'04' => 'Abril',
						'05' => 'Mayo',
						'06' => 'Junio',
						'07' => 'Julio',
						'08' => 'Agosto',
						'09' => 'Septiembre',
						'10' => 'Octubre',
						'11' => 'Noviembre',
						'12' => 'Diciembre'],
						'templates' => ['dateWidget' => '<ul class="list-inline"><li class="day">Día{{day}}</li><li class="month">Mes{{month}}</li><li class="year">Año{{year}}</li></ul>']]);

					echo $this->Form->input('date_until', ['label' => 'Fecha de culminación de la nómina: ', 
						'type' => 'date',
						'value' => $currentDate,
						'monthNames' =>
						['01' => 'Enero',
						'02' => 'Febrero',
						'03' => 'Marzo',
						'04' => 'Abril',
						'05' => 'Mayo',
						'06' => 'Junio',
						'07' => 'Julio',
						'08' => 'Agosto',
						'09' => 'Septiembre',
						'10' => 'Octubre',
						'11' => 'Noviembre',
						'12' => 'Diciembre'],
						'templates' => ['dateWidget' => '<ul class="list-inline"><li class="day">Día{{day}}</li><li class="month">Mes{{month}}</li><li class="year">Año{{year}}</li></ul>']]);

					echo $this->Form->input('salary_days', ['label' => 'Cantidad de días base para el cálculo de esta nómina: ', 'class' => 'alternative-decimal-separator']);

					echo $this->Form->input('cesta_ticket_month', ['label' => 'Valor cesta ticket mensual: ', 'class' => 'alternative-decimal-separator', 'value' => number_format($cestaTicket, 2, ",", ".")]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Crear nómina'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>
<div class="menumenos nover menu-menos">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
    <p>
        <a href="../paysheets/edit" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
    $(document).ready(function()
    { 
		$(".alternative-decimal-separator").numeric({ altDecimal: "," });
		$('#mas').on('click',function()
		{
			$('.menu-menos').hide();
			$('.menu-mas').show();
		});
		
		$('#menos').on('click',function()
		{
			$('.menu-mas').hide();
			$('.menu-menos').show();
		});
	});
</script>