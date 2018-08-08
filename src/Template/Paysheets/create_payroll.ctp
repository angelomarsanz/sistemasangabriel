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
	.error 
	{
		position: relative;
		z-index: 1;
		padding: 10px;
		border-radius: 10px;
		color: white;
		width: 235px;
		text-align: center; 
		font-size: 12px;
		background: RGB(194, 46, 79);
	}

	.error::after 
	{
		content: '';
		border-bottom: 15px solid RGB(194, 46, 79);
		border-right: 15px solid transparent;
		border-left: 15px solid transparent;
		position: absolute;
		left: 45%;
		top: -14px;
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
	<h3>Crear Nómina</h3>
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
					?>
				</div>
				<div class="col-md-4">
					<?php echo $this->Form->input('date_until', ['label' => 'Fecha culminación nómina: ', 
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
					?>
				</div>				
				<div class="col-md-4">
					<br />
					<div class="row">
						<div class="col-md-6">
							<label for="salary-days">Días base cálculos:</label>
							<input name="salary_days" id="salary-day" value="<?= number_format($payrollParameters['salaryDays'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días base para el cálculo de esta nómina">
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
							<input name="cesta_ticket_month" id="cesta-ticket-month" value="<?= number_format($payrollParameters['cestaTicketMonth'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Valor de la cesta ticket mensual" />
						</div>
						<div class="col-md-6">						
							<label for="days-cesta-ticket">Días base cálculos:</label>
							<input name="days_cesta_ticket" id="days-cesta-ticket" value="<?= number_format($payrollParameters['daysCestaTicket'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días base para el cálculo de esta cesta ticket">
						</div>
					</div>
				</div>			
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label for="days-utilities">Días utilidades:</label>
							<input name="days_utilities" id="days-utilities" value="<?= number_format($payrollParameters['daysUtilities'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días a pagar por concepto de utilidades">
						</div>					
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label for="collective-holidays">Días vacaciones:</label>
							<input name="collective_holidays" id="collective-holidays" value="<?= number_format($payrollParameters['collectiveHolidays'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días disfrute de vacaciones">
						</div>
						<div class="col-md-6">
							<label for="collective-vacation-bonus-days">Días bono:</label>
							<input name="collective_vacation_bonus_days" id="collective-vacation-bonus-days" value="<?= number_format($payrollParameters['collectiveVacationBonusDays'], 2, ",", ".") ?>" class="form-control alternative-decimal-separator" data-toggle="tooltip" data-placement="top" title="Cantidad de días del bono vacacional">
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