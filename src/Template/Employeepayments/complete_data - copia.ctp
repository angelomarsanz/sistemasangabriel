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
	.table-container
	{
		height: 500px;
		overflow: auto;
	}

	.table-container th
	{
		position: relative;
		z-index: 5;
		background: white;
	}

	.table-container td
	{
		position: relative;
	}
	
	.table-container tbody tr:nth-child(odd) td
	{
		background: #f9f9f9;
	}

	.table-container tbody tr:nth-child(even) td
	{
		background: white;
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

<div class='container'>
	<div class="page-header">
		<input type='hidden' id='idPaysheet' value=<?= $paysheet->id ?> />
		<input type='hidden' id='ambiente' value=<?= $school->ambient ?>

		<?= $this->Form->create() ?>
			<div class="row">
				<h5><b>Buscar nómina:</b></h5>
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
		<h4>Nómina del personal <?= $paysheet->positioncategory->description_category . ' correspondiente a ' . $paysheet->payroll_name . ' período del ' . $paysheet->date_from->format('d-m-Y') . ' al ' . $paysheet->date_until->format('d-m-Y') ?></h4>
	</div>
       	
    <div class="row">
        <div class="col-md-12">
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="table-responsive table-container">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col"></th>
									<th scope="col"></th>
									<th scope="col"></th>
									<th scope="col"><button type="button" class="glyphicon glyphicon-eye-open btn btn-default" data-toggle="modal" data-target="#myModal" style="color: #9494b8; padding: 1px 3px;" title="Mostrar columnas"></button></th>
									<th scope="col">Nro.</th>
									<th scope="col" class="fixed">Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
																			
									<th scope="col" class="<?= $tableConfiguration->identidy ?>"><a href="#" id='identificacion' title='Ocultar'>Cédula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='cargo'><a href="#" id='cargo' title='Ocultar'>Cargo</a></th>
																			
									<th scope="col" class='fecha-ingreso'><a href="#" id='fecha-ingreso' title='Ocultar'>Fecha&nbsp;ingreso</a></th>

									<th scope="col" class='sueldo-mensual'><a href="#" id='sueldo-mensual' title='Ocultar'>Sueldo&nbsp;mens.</a></th>

									<th scope="col" class='quincena'><a href="#" id='quincena' title='Ocultar'>Quincena&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='escalafon'><a href="#" id='escalafon' title='Ocultar'>Escalafón&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='otros-ingresos'><a href="#" id='otros-ingresos' title='Ocultar'>Otros&nbsp;ingresos</a></th>

									<th scope="col" class='faov'><a href="#" id='faov' title='Ocultar'>FAOV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='ivss'><a href="#" id='ivss' title='Ocultar'>IVSS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='dias-fideicomiso'><a href="#" id='dias-fideicomiso' title='Ocultar'>Días&nbsp;fidei.</a></th>

									<th scope="col" class='fideicomiso'><a href="#" id='fideicomiso' title='Ocultar'>Fideicomiso</a></a></th>

									<th scope="col" class='reposo'><a href="#" id='reposo' title='Ocultar'>Reposo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class='adelanto-sueldo'><a href="#" id='adelanto-sueldo' title='Ocultar'>Adelan.&nbsp;sueldo</a></th>
								
									<th scope="col" class='prestamos'><a href="#" id='prestamos' title='Ocultar'>Préstamos</a></th>
								
									<th scope="col" class='porcentaje-impuesto'><a href="#" id='porcentaje-impuesto' title='Ocultar'>%&nbsp;Imp.&nbsp;</a></th>

									<th scope="col" class='monto-impuesto'><a href="#" id='monto-impuesto' title='Ocultar'>Monto&nbsp;Imp.&nbsp;</a></th>

									<th scope="col" class='dias-inasistencias'><a href="#" id='dias-inasistencias' title='Ocultar'>Días&nbsp;Inasist.</a></th>

									<th scope="col" class='inasistencias'><a href="#" id='inasistencias' title='Ocultar'>Inasistencias</a></th>

									<th scope="col" class='total-quincena'><a href="#" id='total-quincena' title='Ocultar'>Tot.&nbsp;Quinc.</a></th>
							
									<th scope="col" class='days-cesta-ticket'><a href="#" id='days-cesta-ticket' title='Ocultar'>Días&nbsp;cesta&nbsp;ticket</a></th>
								
									<th scope="col" class='amount-cesta-ticket'><a href="#" id='amount-cesta-ticket' title='Ocultar'>Monto&nbsp;cesta&nbsp;ticket</a></th>
								
									<th scope="col" class='loan-cesta-ticket'><a href="#" id='loan-cesta-ticket' title='Ocultar'>Préstamo&nbsp;cesta&nbsp;ticket</a></th>
								
									<th scope="col" class='total-cesta-ticket'><a href="#" id='total-cesta-ticket' title='Ocultar'>Total&nbsp;cesta&nbsp;ticket</a></th>									
								</tr>
							</thead>
							<tbody id='table-fortnight'>
								<?php 
									$accountArray = 0;
									$accountEmployee = 1;
									foreach ($employeesFor as $employeesFors): 
								?>
									<tr id=<?= 'emp' . $employeesFors->id ?> class='linea-empleado'>
										<td><input style="width: 100%;" type="hidden" name="employeepayment[<?= $accountArray ?>][id]" value=<?=$employeesFors->id ?>></td>

										<td><?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'view', $employeesFors->employee->id, 'Paysheets', 'edit', $paysheet->id, $employeesFors->id, $paysheet->weeks_social_security], ['id' => 'ver-empleado', 'class' => 'glyphicon glyphicon-eye-open btn btn-default', 'title' => 'Ver empleado', 'style' => 'color: #9494b8; padding: 1px 3px;']) ?></td>                                            
										<td><?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'edit', $employeesFors->employee->id, 'Paysheets', 'edit', $paysheet->id, $paysheet->weeks_social_security, $employeesFors->id], ['id' => 'modificar-empleado', 'class' => 'glyphicon glyphicon-edit btn btn-default', 'title' => 'Modificar empleado', 'style' => 'color: #9494b8; padding: 1px 3px;']) ?></td>
										<td><?= $this->html->link(__(''), ['controller' => 'Employees', 'action' => 'changeState', $employeesFors->employee->id, $paysheet->id, $employeesFors->id], ['id' => 'eliminar-empleado', 'class' => 'glyphicon glyphicon-trash btn btn-sm btn-default', 'title' => 'Eliminar empleado', 'style' => 'color: #9494b8; padding: 1px 3px;']) ?></td>
															
										<td></td>
															
										<td><?= $accountEmployee ?></td>
										
										<td><?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></td>		
										
										<td class="<?= $tableConfiguration->identidy ?>"><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>

										<td class="cargo"><?= $employeesFors->current_position ?></td>
										
										<td class="fecha-ingreso"><input disabled='true' class='input-fecha-ingreso' style="text-align: center; width: 100%;" name="employeepayment[<?= $accountArray ?>][date_of_admission]" value=<?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?>></td>

										<td class="sueldo-mensual"><input disabled='true' class='input-sueldo-mensual' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][monthly_salary]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?>></td>

										<td class='quincena'><input disabled='true' class='input-quincena' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][fortnight]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->fortnight, 2, ",", ".") ?>></td>
									
										<td class='escalafon'><input disabled='true' class='input-escalafon' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_escalation_fortnight]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?>></td>

										<td class='otros-ingresos'><input class='input-otros-ingresos alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][other_income]" value=<?= number_format($employeesFors->other_income, 2, ",", ".") ?>></td> 
			
										<td class='faov' style='text-align: right;'><input disabled='true' class='input-faov' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][faov]" value=<?= number_format($employeesFors->faov, 2, ",", ".") ?>></td>

										<td class='ivss' style='text-align: right;'><input disabled='true' class='input-ivss' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][ivss]" value=<?= number_format($employeesFors->ivss, 2, ",", ".") ?>></td>

										<td class='dias-fideicomiso' style='text-align: right;'><input class='input-dias-fideicomiso alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][trust_days]" value=<?= number_format($employeesFors->trust_days, 2, ",", ".") ?>></td>

										<td class='fideicomiso' style='text-align: right;'><input disabled='true' class='input-fideicomiso' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][escrow]" value=<?= number_format(($employeesFors->trust_days * $employeesFors->integral_salary), 2, ",", ".") ?>></td>

										<td class='reposo'><input class='input-reposo alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_repose]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_repose, 2, ",", ".") ?>></td>

										<td class='adelanto-sueldo'><input class='input-adelanto-sueldo alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][salary_advance]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->salary_advance, 2, ",", ".") ?>></td>
									
										<td class='prestamos'><input class='input-prestamos alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_loan]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_loan, 2, ",", ".") ?>></td>

										<td class='porcentaje-impuesto'><input class='input-porcentaje-impuesto alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][percentage_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?>></td>

										<td class='monto-impuesto'><input  disabled='true' class='input-monto-impuesto' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?>></td>

										<td class='dias-inasistencias' style='text-align: right;'><input class='input-dias-inasistencias alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][days_absence]" value=<?= number_format($employeesFors->days_absence, 2, ",", ".") ?>></td>

										<td class='inasistencias'><input disabled='true' class='input-inasistencia' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][discount_absences]" value=<?= number_format($employeesFors->discount_absences, 2, ",", ".") ?>></td>

										<td class='total-quincena'><input disabled='true' class='input-total-quincena' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_payment]" value=<?= number_format($employeesFors->total_payment, 2, ",", ".") ?>></td>

										<td class='days-cesta-ticket'><input class='input-days-cesta-ticket alternative-decimal-separator' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][days_cesta_ticket]" value=<?= number_format($employeesFors->days_cesta_ticket, 2, ",", ".") ?>></td>
								
										<td class='amount-cesta-ticket'><input disabled='true' class='input-amount-cesta-ticket' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][amount_cesta_ticket]" value=<?= number_format($employeesFors->amount_cesta_ticket, 2, ",", ".") ?>></td>
								
										<td class='loan-cesta-ticket'><input class='input-loan-cesta-ticket alternative-decimal-separator' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][loan_cesta_ticket]" value=<?= number_format($employeesFors->loan_cesta_ticket, 2, ",", ".") ?>></td>
									
										<td class='total-cesta-ticket'><input disabled='true' class='input-total-cesta-ticket' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_cesta_ticket]" value=<?= number_format($employeesFors->total_cesta_ticket, 2, ",", ".") ?>></td>	
									</tr>
								<?php 
									$accountArray++; 
									$accountEmployee++;
									endforeach; ?>
							</tbody>
						</table>
						<?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'add', $paysheet->id, $paysheet->weeks_social_security], ['id' => 'agregar-empleado', 'class' => 'glyphicon glyphicon-user btn btn-default', 'title' => 'Agregar empleado', 'style' => 'color: #9494b8; padding: 3px 5px;']) ?>
						<!-- Modal -->
						<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">				
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Mostrar/ocultar columnas</h4>
									</div>
									<div class="modal-body">
										<p><input class="column-mark" type="checkbox" name="columnsReport[identidy]" id="mostrar-identificacion" <?php if ($tableConfiguration->identidy == 'identificacion') echo 'checked'; ?>> Cédula</p>
									</div>
									<div class="modal-footer">
										<button id="marcar-todos" class="glyphicon icon-checkbox-checked btn btn-default" title="Marcar todos" style="padding: 8px 12px 10px 12px;"></button>
										<button id="desmarcar-todos" class="glyphicon icon-checkbox-unchecked btn btn-default" title="Desmarcar todos" style="padding: 8px 12px 10px 12px;"></button>
										<button type="button" class="glyphicon glyphicon-eye-close btn btn-default" data-dismiss="modal"></button>
									</div>
								</div>
							</div>
						</div>
						<br />
						<br />
					</div>
				</fieldset>
				<?= $this->Form->button(__('Guardar'), ['id' => 'Guardar', 'class' =>'btn btn-success noverScreen']) ?>
				
				<div class="menumenos nover menu-menos">
					<p>
					<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
					</p>
				</div>
				<div style="display:none;" class="menumas nover menu-mas">
					<p>
						<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
						<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>

						<?= $this->Html->link(__(''), ['controller' => 'Employeepayments', 'action' => 'overPayment', $idPaysheet, $year, $month, $fortnight, $classification, $monthNumber], ['id' => 'sobre-pago', 'class' => 'glyphicon glyphicon-envelope btn btn-danger', 'title' => 'Sobre de pago sueldo']) ?>							
						
						<?php if ($fortnight == '2da. Quincena'): ?>
							<?= $this->Html->link(__(''), ['controller' => 'Employeepayments', 'action' => 'overTax', $idPaysheet, $year, $month, $fortnight, $classification, $monthNumber], ['id' => 'sobre-islr', 'class' => 'glyphicon icon-ISLR btn btn-danger', 'title' => 'Sobre de pago retención', 'style' => 'padding: 8px 12px 10px 12px;']) ?>
							<?php if ($tableConfiguration->sw_cesta_ticket == 0): ?> 
								<button type="submit" id="ver-cesta-ticket" class="glyphicon glyphicon-eye-open btn btn-danger" title="Ver cesta ticket"></button>
							<?php else: ?>
								<button type="submit" id="ver-nomina" class="glyphicon glyphicon-eye-open btn btn-danger" title="Ver nómina"></button>
							<?php endif; ?>
						<?php endif; ?>
						
						<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'createPayrollFortnight'], ['id' => 'nuevo', 'class' => 'glyphicon glyphicon-plus-sign btn btn-danger', 'title' => 'Crear nueva nómina']) ?>
						<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'editPayrollFortnight', $idPaysheet, 'Employeepayments', 'completeData'], ['id' => 'modificar', 'class' => 'glyphicon glyphicon-edit btn btn-danger', 'title' => 'Modificar parámetros']) ?>
						<button id="borrar" class="glyphicon glyphicon-trash btn btn-danger" title="Eliminar"></button>
						<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
					</p>
				</div> 					
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
// Variables
    var empleadoSeleccionado = 'valorInicial';

// Funciones

    function marcarEmpleado(id)
    {
        $('#' + id + ' td').each(function ()
        {
            $(this).css('background-color', '#c2c2d6'); 
        });
    }
    
    function desmarcarEmpleado(id)
    {
        $('#' + id + ' td').each(function ()
        {
            $(this).css('background-color', 'white'); 
        });
    }

// Documento
	
	document.addEventListener("DOMContentLoaded", function()
	{
		'use strict';
		var tableContainer = document.querySelector(".table-container");
		var headRow = tableContainer.querySelector("thead tr");
		tableContainer.addEventListener("scroll", moveContent);

		function moveContent(){
			moveX(this);
			moveY(this);
		}

		function moveX(self){
			var rows = document.querySelectorAll(".table-container tr");
			var fixedColumnIndex = findFixedIndex();
			for (var i = 0; i < rows.length; i++){
				var parentName = rows[i].parentNode.nodeName.toLowerCase();
				var cells = getCells(rows[i], parentName);
				for(var j = 0; j <= fixedColumnIndex; j++){
					setZIndex(cells[j], parentName);
					cells[j].style.left = self.scrollLeft + "px";
				}
			}
		}

		function moveY(self){
			var cells = headRow.querySelectorAll("th");
			for(var i = 0; i < cells.length; i++){
				cells[i].style.top = self.scrollTop + "px";	
			}
		}

		function setZIndex(cell, parentName){
			if(!cell.style.zIndex){
				if(parentName == "thead")
					cell.style.zIndex = 10;
				else
					cell.style.zIndex = 5;
			}
		}

		function getCells (row, parentName){
			if(parentName == "thead")
				return(row.querySelectorAll("th"));
			else
				return(row.querySelectorAll("td"));
		}

		function findFixedIndex(){
			var cells = headRow.querySelectorAll("th");
			for(var i = 0; i < cells.length; i++){
				if(cells[i].classList.contains("fixed"))
					return i; 
			}
		}
	});

    $(document).ready(function()
    { 
		if ($('#ambiente').val() == "Producción")
		{
			paysheetIndex = "/sistemasangabriel/paysheets/index";
			paysheetDelete = "/sistemasangabriel/paysheets/delete";
		}
		else
		{
			paysheetIndex = "/desarrollosistemasangabriel/paysheets/index";
			paysheetDelete = "/desarrollosistemasangabriel/paysheets/delete";
		}
	
    	$(".alternative-decimal-separator").numeric({ altDecimal: "," });
    	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
        $('#classification').val($('#classificationFor').val());
        $('#fortnight').val($('#fortnightFor').val());
        $('#month').val($('#monthFor').val());
        $('#year').val($('#yearFor').val());
		
        $('#search-payroll').click(function(e) 
        {
            e.preventDefault(); 
			$.redirect(paysheetIndex, {ddFrom : $("select[name='date_from[day]']").val(), mmFrom : $("select[name='date_from[month]']").val(), yyFrom : $("select[name='date_from[year]']").val(), ddUntil : $("select[name='date_until[day]']").val(), mmUntil : $("select[name='date_until[month]']").val(), yyUntil : $("select[name='date_until[year]']").val(), positionCategories : $("#position-categories").val() });
        });
		
        $('#borrar').click(function(e) 
        {
            e.preventDefault();
			var r = confirm("Por favor confirme que desea eliminar esta nómina");
            if (r == true)
			{
				$.redirect(paysheetDelete, {idPaysheet : $("#idPaysheet").val(), controller : "Paysheets", action : "edit" });
			}
			else
            {
                return false;
            } 
        });
		
		$('#marcar-todos').click(function(e)
		{			
			e.preventDefault();
			
			$(".column-mark").each(function (index) 
			{ 
				$(this).attr('checked', true);
				$(this).prop('checked', true);
				$('.allColumns').removeClass("noverScreen");
		});
		
		$('#desmarcar-todos').click(function(e)
		{			
			e.preventDefault();
			
			$(".column-mark").each(function (index) 
			{ 
				$(this).attr('checked', false);
				$(this).prop('checked', false);
				$('.allColumns').addClass("noverScreen");
			});
			});
		});
			
        $('#identificacion').on('click',function()
        {
            $('.identificacion').addClass("noverScreen");
			$('#mostrar-identificacion').attr('checked', false);
			$('#mostrar-identificacion').prop('checked', false);

        });
		
        $('#mostrar-identificacion').on('click',function()
        {
			if  ($('#mostrar-identificacion').prop('checked'))
			{
				$('.identificacion').removeClass("noverScreen");
				$('#mostrar-identificacion').attr('checked', true);
			}
			else
			{
				$('.identificacion').addClass("noverScreen");
				$('#mostrar-identificacion').attr('checked', false);
			}
        });

        $('#cargo').on('click',function()
        {
            $('.cargo').hide();
			
        });
		
        $('#fecha-ingreso').on('click',function()
        {
            $('.fecha-ingreso').hide();
        });

        $('#sueldo-mensual').on('click',function()
        {
            $('.sueldo-mensual').hide();
        });

        $('#quincena').on('click',function()
        {
            $('.quincena').hide();
        });
        
        $('#escalafon').on('click',function()
        {
            $('.escalafon').hide();
        });
        
        $('#adelanto-sueldo').on('click',function()
        {
            $('.adelanto-sueldo').hide();
        });

        $('#otros-ingresos').on('click',function()
        {
            $('.otros-ingresos').hide();
        });

        $('#faov').on('click',function()
        {
            $('.faov').hide();
        });

        $('#ivss').on('click',function()
        {
            $('.ivss').hide();
        });

        $('#dias-fideicomiso').on('click',function()
        {
            $('.dias-fideicomiso').hide();
        });

        $('#fideicomiso').on('click',function()
        {
            $('.fideicomiso').hide();
        });

        $('#reposo').on('click',function()
        {
            $('.reposo').hide();
        });

        $('#prestamos').on('click',function()
        {
            $('.prestamos').hide();
        });

        $('#porcentaje-impuesto').on('click',function()
        {
            $('.porcentaje-impuesto').hide();
        });

        $('#monto-impuesto').on('click',function()
        {
            $('.monto-impuesto').hide();
        });

        $('#dias-inasistencias').on('click',function()
        {
            $('.dias-inasistencias').hide();
        });

        $('#inasistencias').on('click',function()
        {
            $('.inasistencias').hide();
        });
        
        $('#total-quincena').on('click',function()
        {
            $('.total-quincena').hide();
        });

        $('#days-cesta-ticket').on('click',function()
        {
            $('.days-cesta-ticket').hide();
        });
		
        $('#amount-cesta-ticket').on('click',function()
        {
            $('.amount-cesta-ticket').hide();
        });
				
        $('#loan-cesta-ticket').on('click',function()
        {
            $('.loan-cesta-ticket').hide();
        });
				
        $('#total-cesta-ticket').on('click',function()
        {
            $('.total-cesta-ticket').hide();
        });
							
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

        $('.linea-empleado').on('click',function()
        {
            idEmpleado = $(this).attr('id');
            
            if (empleadoSeleccionado != 'valorInicial')
            {
                desmarcarEmpleado(empleadoSeleccionado);
            }
            
            empleadoSeleccionado = idEmpleado;
            marcarEmpleado(empleadoSeleccionado); 
        });

		$('#ver-nomina').on('click',function()
        {
            $('.ver-sw-cesta-ticket').val('0');
         });
		
        $('#ver-cesta-ticket').on('click',function()
        {
            $('.ver-sw-cesta-ticket').val('1');
         });
		         
    });
</script>