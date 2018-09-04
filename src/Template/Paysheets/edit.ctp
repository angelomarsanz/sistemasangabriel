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
<div class="page-header">
	<h3>Modificar parámetros de la nómina</h3>
</div>
<div class="row">
	<?= $this->Form->create($paysheet, ['novalidate']) ?>
        <fieldset>
			<div class="row">
				<div class="col-md-6">
					<?php echo $this->Form->input('positioncategory_id', ['label' => 'Categoría:', 'options' => $positionCategories]); ?>
				</div>
				<div class="col-md-6">				
					<?php echo $this->Form->input('payroll_name', ['label' => 'Nombre de la nómina: ']); ?> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">	
					<?php echo $this->Form->input('date_from', ['label' => 'Fecha inicio nómina: ', 
						'type' => 'date',
						'value' => $paysheet->date_from,
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
					?>
				</div>
				<div class="col-md-4">
					<?php echo $this->Form->input('date_until', ['label' => 'Fecha culminación nómina: ', 
						'type' => 'date',
						'value' => $paysheet->date_until,
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
					?>
				</div>				
				<div class="col-md-4">
					<br />
					<div class="row">
						<div class="col-md-6">
							<label for="salary-days">Días base cálculos:</label>
							<input name="salary_days" id="salary-day" value=<?= number_format($paysheet->salary_days, 2, ",", ".") ?> class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días a pagar por concepto de utilidades" style="text-align: right;" />
						</div>
					</div>
				</div>
			</div >
			<hr />
			<div class="row">				
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label for="cesta-ticket-month">Cesta ticket:</label>
							<input name="cesta_ticket_month" id="cesta-ticket-month" value=<?= number_format($paysheet->cesta_ticket_month, 2, ",", ".") ?> class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Valor de la cesta ticket mensual" style="text-align: right;" />
						</div>
						<div class="col-md-6">						
							<label for="days-cesta-ticket">Días base cálculos:</label>
							<input name="days_cesta_ticket" id="days-cesta-ticket" value=<?= number_format($paysheet->days_cesta_ticket, 2, ",", ".") ?> class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días base para el cálculo de esta cesta ticket" style="text-align: right;" />
						</div>
					</div>
				</div>			
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label for="days-utilities">Días utilidades:</label>
							<input name="days_utilities" id="days-utilities" value=<?= number_format($paysheet->days_utilities, 2, ",", ".") ?> class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días a pagar por concepto de utilidades" style="text-align: right;" />
						</div>					
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label for="collective-holidays">Días vacaciones:</label>
							<input name="collective_holidays" id="collective-holidays" value=<?= number_format($paysheet->collective_holidays, 2, ",", ".") ?> class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días disfrute de vacaciones" style="text-align: right;" />
						</div>
						<div class="col-md-6">
							<label for="collective-vacation-bonus-days">Días bono:</label>
							<input name="collective_vacation_bonus_days" id="collective-vacation-bonus-days" value=<?= number_format($paysheet->collective_vacation_bonus_days, 2, ",", ".") ?> class="form-control  alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días del bono vacacional" style="text-align: right;" />
						</div>						
					</div>
				</div>
			</div>
		</fieldset>
		<hr />
		<div class="row">
			<div class="col-md-4">
				<?= $this->Html->link(__(''), ['controller' => $controller, 'action' => $action], ['class' => 'glyphicon glyphicon-remove btn btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Cancelar']) ?>
				<button id="crear-nomina" type="submit" class="glyphicon glyphicon-ok btn btn-success" data-toggle="tooltip" data-placement="top" title="Ok"></button>
			</div>
		</div>
	<?= $this->Form->end() ?>
</div>
<div class="menumenos nover menu-menos">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
    <p>
		
		<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'Cerrar']) ?>
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
		
		$('[data-toggle="tooltip"]').tooltip();
		
		$('#marcar-todos').click(function(e)
		{			
			e.preventDefault();
			
			$(".mark-categories").each(function (index) 
			{ 
				$(this).attr('checked', true);
				$(this).prop('checked', true);
			});
		});
		
		$('#desmarcar-todos').click(function(e)
		{			
			e.preventDefault();
			
			$(".mark-categories").each(function (index) 
			{ 
				$(this).attr('checked', false);
				$(this).prop('checked', false);
			});
		});
		
		$('#crear-nomina').click(function(e) 
        {
			if ($("#positioncategory-id").val() == "1")
			{
				e.preventDefault();
				$("#positioncategory-id").css("background-color", "#ffffe6");
				alert('Por favor seleccione una categoría');
			}
		});
	});
</script>