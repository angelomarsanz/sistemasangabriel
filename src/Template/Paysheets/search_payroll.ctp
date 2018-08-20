<?php 
	use Cake\I18n\Time;
	
	setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
	date_default_timezone_set('America/Caracas');
	
	$currentDate = time::now();
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
    <div class="col-md-12">
        <div class="page-header">
			<h4>Buscar Nómina</h4>
			<input type='hidden' id='ambiente' value=<?= $school->ambient ?>
        </div>
		<?= $this->Form->create() ?>
		<div class="row">
			<div class="col-md-11">								
				<fieldset>
					<div class="row">
						<div class="col-md-4">
							<?php echo $this->Form->input('position_categories', ['label' => 'Categoría:', 'options' => $positionCategories]); ?>
						</div>
						<div class="col-md-4">
							<?php echo $this->Form->input('date_from', ['label' => 'Desde: ', 
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
								'templates' => ['dateWidget' => '<ul class="list-inline"><li class="day">{{day}}</li><li class="month">{{month}}</li><li class="year">{{year}}</li></ul>']]);
							?>
						</div>
						<div class="col-md-4">
							<?php echo $this->Form->input('date_until', ['label' => 'Hasta: ', 
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
								'templates' => ['dateWidget' => '<ul class="list-inline"><li class="day">{{day}}</li><li class="month">{{month}}</li><li class="year">{{year}}</li></ul>']]);
							?>
						</div>
					</div>
				</fieldset>	
			</div>
			<div class="col-md-1">	
				<br />
				<button type="submit" id="search-payroll" class="glyphicon glyphicon-search btn btn-default"></button>
			</div>
		</div>
		<?= $this->Form->end() ?>
    </div>
</div>
<div class="menumenos nover menu-menos">
	<p>
	<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
	</p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
	<p>
		<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'edit'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
		<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
		<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
	</p>
</div> 
<script>
    $(document).ready(function()
    { 		
		if ($('#ambiente').val() == "Producción")
		{
			paysheetIndex = "/sistemasangabriel/paysheets/index";
		}
		else
		{
			paysheetIndex = "/desarrollosistemasangabriel/paysheets/index";
		}	

		$('[data-toggle="tooltip"]').tooltip();
        
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

        $('#search-payroll').click(function(e) 
        {
            e.preventDefault(); 
			
			$.redirect(paysheetIndex, {ddFrom : $("select[name='date_from[day]']").val(), mmFrom : $("select[name='date_from[month]']").val(), yyFrom : $("select[name='date_from[year]']").val(), ddUntil : $("select[name='date_until[day]']").val(), mmUntil : $("select[name='date_until[month]']").val(), yyUntil : $("select[name='date_until[year]']").val(), positionCategories : $("#position-categories").val() });

        });
});
</script>