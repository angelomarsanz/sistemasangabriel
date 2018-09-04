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

									<th scope="col" class="<?= $tableConfiguration->position ?>"><a href="#" id='cargo' title='Ocultar'>Cargo</a></th>
																			
									<th scope="col" class="<?= $tableConfiguration->date_of_admission ?>"><a href="#" id='fecha-ingreso' title='Ocultar'>Fecha&nbsp;ingreso</a></th>

									<th scope="col" class="<?= $tableConfiguration->monthly_salary ?>"><a href="#" id='sueldo-mensual' title='Ocultar'>Sueldo&nbsp;mens.</a></th>

									<th scope="col" class="<?= $tableConfiguration->payment_period ?>"><a href="#" id='pago-periodo' title='Ocultar'>Pago&nbsp;período</a></th>

									<th scope="col" class="<?= $tableConfiguration->amount_escalation ?>"><a href="#" id='escalafon' title='Ocultar'>Escalafón&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class="<?= $tableConfiguration->other_income ?>"><a href="#" id='otros-ingresos' title='Ocultar'>Otros&nbsp;ingresos</a></th>

									<th scope="col" class="<?= $tableConfiguration->faov ?>"><a href="#" id='faov' title='Ocultar'>FAOV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class="<?= $tableConfiguration->ivss ?>"><a href="#" id='ivss' title='Ocultar'>IVSS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<?php if ($paysheet->date_until->day > 28): ?>
										<th scope="col" class="<?= $tableConfiguration->trust_days ?>"><a href="#" id='dias-fideicomiso' title='Ocultar'>Días&nbsp;fidei.</a></th>

										<th scope="col" class="<?= $tableConfiguration->escrow ?>"><a href="#" id='fideicomiso' title='Ocultar'>Fideicomiso</a></a></th>
									<?php endif; ?>
										
									<th scope="col" class="<?= $tableConfiguration->discount_repose ?>"><a href="#" id='reposo' title='Ocultar'>Reposo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>

									<th scope="col" class="<?= $tableConfiguration->salary_advance ?>"><a href="#" id='adelanto-sueldo' title='Ocultar'>Adelan.&nbsp;sueldo</a></th>
								
									<th scope="col" class="<?= $tableConfiguration->discount_loan ?>"><a href="#" id='prestamos' title='Ocultar'>Préstamos</a></th>
								
									<?php if ($paysheet->date_until->day > 28): ?>
										<th scope="col" class="<?= $tableConfiguration->percentage_imposed ?>"><a href="#" id='porcentaje-impuesto' title='Ocultar'>%&nbsp;Imp.&nbsp;</a></th>
										
										<th scope="col" class="<?= $tableConfiguration->amount_imposed ?>"><a href="#" id='monto-impuesto' title='Ocultar'>Monto&nbsp;Imp.&nbsp;</a></th>
									<?php endif; ?>
									
									<th scope="col" class="<?= $tableConfiguration->days_absence ?>"><a href="#" id='dias-inasistencias' title='Ocultar'>Días&nbsp;Inasist.</a></th>

									<th scope="col" class="<?= $tableConfiguration->discount_absences ?>"><a href="#" id='inasistencias' title='Ocultar'>Inasistencias</a></th>

									<th scope="col" class="<?= $tableConfiguration->total_payment ?>"><a href="#" id='total-pago' title='Ocultar'>Total&nbsp;Pago</a></th>
							
									<?php if ($paysheet->days_cesta_ticket > 0): ?>
										<th scope="col" class="<?= $tableConfiguration->days_cesta_ticket ?>"><a href="#" id='dias-cesta-ticket' title='Ocultar'>Días&nbsp;cesta&nbsp;ticket</a></th>
								
										<th scope="col" class="<?= $tableConfiguration->amount_cesta_ticket ?>"><a href="#" id='monto-cesta-ticket' title='Ocultar'>Monto&nbsp;cesta&nbsp;ticket</a></th>
								
										<th scope="col" class="<?= $tableConfiguration->loan_cesta_ticket ?>"><a href="#" id='prestamos-cesta-ticket' title='Ocultar'>Préstamos&nbsp;cesta&nbsp;ticket</a></th>
								
										<th scope="col" class="<?= $tableConfiguration->total_cesta_ticket ?>"><a href="#" id='total-cesta-ticket' title='Ocultar'>Total&nbsp;cesta&nbsp;ticket</a></th>											
									<?php endif; ?>
								</tr>
							</thead>
							<tbody id='table-payment'>
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

										<td class="<?= $tableConfiguration->position ?>"><?= $employeesFors->current_position ?></td>
										
										<td class="<?= $tableConfiguration->date_of_admission ?>"><input disabled='true' style="text-align: center; width: 100%;" name="employeepayment[<?= $accountArray ?>][date_of_admission]" value=<?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?>></td>

										<td class="<?= $tableConfiguration->monthly_salary ?>"><input disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][monthly_salary]" value=<?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->payment_period ?>"><input disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][payment-period]" value=<?= number_format($employeesFors->payment_period, 2, ",", ".") ?>></td>
									
										<td class="<?= $tableConfiguration->amount_escalation ?>"><input disabled='true'  style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_escalation]" value=<?= number_format(($employeesFors->amount_escalation), 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->other_income ?>"><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][other_income]" value=<?= number_format($employeesFors->other_income, 2, ",", ".") ?>></td> 
			
										<td class="<?= $tableConfiguration->faov ?>" style='text-align: right;'><input disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][faov]" value=<?= number_format($employeesFors->faov, 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->ivss ?>" style='text-align: right;'><input disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][ivss]" value=<?= number_format($employeesFors->ivss, 2, ",", ".") ?>></td>

										<?php if ($paysheet->date_until->day > 28): ?>
											<td class="<?= $tableConfiguration->trust_days ?>" style='text-align: right;'><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][trust_days]" value=<?= number_format($employeesFors->trust_days, 2, ",", ".") ?>></td>
											
											<td class="<?= $tableConfiguration->escrow ?>" style='text-align: right;'><input disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][escrow]" value=<?= number_format($employeesFors->fideicomiso, 2, ",", ".") ?>></td>
										<?php endif; ?>
										
										<td class="<?= $tableConfiguration->discount_repose ?>"><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_repose]" value=<?= number_format($employeesFors->discount_repose, 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->salary_advance ?>"><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][salary_advance]" value=<?= number_format($employeesFors->salary_advance, 2, ",", ".") ?>></td>
									
										<td class="<?= $tableConfiguration->discount_loan ?>"><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_loan]" value=<?= number_format($employeesFors->discount_loan, 2, ",", ".") ?>></td>

										<?php if ($paysheet->date_until->day > 28): ?>
											<td class="<?= $tableConfiguration->percentage_imposed ?>"><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][percentage_imposed]" value=<?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?>></td>

											<td class="<?= $tableConfiguration->amount_imposed ?>"><input  disabled='true' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_imposed]" value=<?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?>></td>
										<?php endif; ?>
										
										<td class="<?= $tableConfiguration->days_absence ?>" style='text-align: right;'><input class='alternative-decimal-separator' style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][days_absence]" value=<?= number_format($employeesFors->days_absence, 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->discount_absences ?>"><input disabled='true' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][discount_absences]" value=<?= number_format($employeesFors->discount_absences, 2, ",", ".") ?>></td>

										<td class="<?= $tableConfiguration->total_payment ?>"><input disabled='true' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_payment]" value=<?= number_format($employeesFors->total_payment, 2, ",", ".") ?>></td>

										<?php if ($paysheet->days_cesta_ticket > 0): ?>
											<td class="<?= $tableConfiguration->days_cesta_ticket ?>"><input class='alternative-decimal-separator' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][days_cesta_ticket]" value=<?= number_format($employeesFors->days_cesta_ticket, 2, ",", ".") ?>></td>
											<td class="<?= $tableConfiguration->amount_cesta_ticket ?>"><input disabled='true' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][amount_cesta_ticket]" value=<?= number_format($employeesFors->amount_cesta_ticket, 2, ",", ".") ?>></td>
											<td class="<?= $tableConfiguration->loan_cesta_ticket ?>"><input class='alternative-decimal-separator' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][loan_cesta_ticket]" value=<?= number_format($employeesFors->loan_cesta_ticket, 2, ",", ".") ?>></td>
											<td class="<?= $tableConfiguration->total_cesta_ticket ?>"><input disabled='true' style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_cesta_ticket]" value=<?= number_format($employeesFors->total_cesta_ticket, 2, ",", ".") ?>></td>	
										<?php endif; ?>									
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
										<div class="row">
											<div class="col-md-4">
												<p><input class="column-mark" type="checkbox" name="columnsReport[identidy]" id="mostrar-identificacion" <?php if ($tableConfiguration->identidy == 'allColumns identificacion') echo 'checked'; ?>> Cédula</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[position]" id="mostrar-cargo" <?php if ($tableConfiguration->position == 'allColumns cargo') echo 'checked'; ?>> Cargo</p>

												<p><input class="column-mark" type="checkbox" name="columnsReport[date_of_admission]" id="mostrar-fecha-ingreso" <?php if ($tableConfiguration->date_of_admission == 'allColumns fecha-ingreso') echo 'checked'; ?>> Fecha de ingreso</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[monthly_salary]" id="mostrar-sueldo-mensual" <?php if ($tableConfiguration->monthly_salary == 'allColumns sueldo-mensual') echo 'checked'; ?>> Sueldo mensual</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[payment_period]" id="mostrar-pago-periodo" <?php if ($tableConfiguration->payment_period == 'allColumns pago-periodo') echo 'checked'; ?>> Pago período</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[amount_escalation]" id="mostrar-escalafon" <?php if ($tableConfiguration->amount_escalation == 'allColumns escalafon') echo 'checked'; ?>> Escalafón</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[other_income]" id="mostrar-otros-ingresos" <?php if ($tableConfiguration->other_income == 'allColumns otros-ingresos') echo 'checked'; ?>> Otros ingresos</p>

												<p><input class="column-mark" type="checkbox" name="columnsReport[faov]" id="mostrar-faov" <?php if ($tableConfiguration->faov == 'allColumns faov') echo 'checked'; ?>> FAOV</p>
																						
											</div>
											<div class="col-md-4">
												<p><input class="column-mark" type="checkbox" name="columnsReport[ivss]" id="mostrar-ivss" <?php if ($tableConfiguration->ivss == 'allColumns ivss') echo 'checked'; ?>> IVSS</p>
											
												<?php if ($paysheet->date_until->day > 28): ?>
													<p><input class="column-mark" type="checkbox" name="columnsReport[trust_days]" id="mostrar-dias-fideicomiso" <?php if ($tableConfiguration->trust_days == 'allColumns dias-fideicomiso') echo 'checked'; ?>> Días fideicomiso</p>
												
													<p><input class="column-mark" type="checkbox" name="columnsReport[escrow]" id="mostrar-fideicomiso" <?php if ($tableConfiguration->escrow == 'allColumns fideicomiso') echo 'checked'; ?>> Fideicomiso</p>
												<?php endif; ?>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[discount_repose]" id="mostrar-reposo" <?php if ($tableConfiguration->discount_repose == 'allColumns reposo') echo 'checked'; ?>> Reposo</p>

												<p><input class="column-mark" type="checkbox" name="columnsReport[salary_advance]" id="mostrar-adelanto-sueldo" <?php if ($tableConfiguration->salary_advance == 'allColumns adelanto-sueldo') echo 'checked'; ?>> Adelanto sueldo</p>
														
												<p><input class="column-mark" type="checkbox" name="columnsReport[discount_loan]" id="mostrar-prestamos" <?php if ($tableConfiguration->discount_loan == 'allColumns prestamos') echo 'checked'; ?>> Préstamos</p>
												
												<?php if ($paysheet->date_until->day > 28): ?>
													<p><input class="column-mark" type="checkbox" name="columnsReport[percentage_imposed]" id="mostrar-porcentaje-impuesto" <?php if ($tableConfiguration->percentage_imposed == 'allColumns porcentaje-impuesto') echo 'checked'; ?>> Porcentaje impuesto</p>
												
													<p><input class="column-mark" type="checkbox" name="columnsReport[amount_imposed]" id="mostrar-monto-impuesto" <?php if ($tableConfiguration->amount_imposed == 'allColumns monto-impuesto') echo 'checked'; ?>> Monto impuesto</p>										
												<?php endif; ?>
												
											</div>
											<div class="col-md-4">
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[days_absence]" id="mostrar-dias-inasistencias" <?php if ($tableConfiguration->days_absence == 'allColumns dias-inasistencias') echo 'checked'; ?>> Días inasistencia</p>

												<p><input class="column-mark" type="checkbox" name="columnsReport[discount_absences]" id="mostrar-inasistencias" <?php if ($tableConfiguration->discount_absences == 'allColumns inasistencias') echo 'checked'; ?>> Inasistencia</p>
												
												<p><input class="column-mark" type="checkbox" name="columnsReport[total_payment]" id="mostrar-total-pago" <?php if ($tableConfiguration->total_payment == 'allColumns total-pago') echo 'checked'; ?>> Total pago</p>
												
												<?php if ($paysheet->days_cesta_ticket > 0): ?>
												
													<p><input class="column-mark" type="checkbox" name="columnsReport[days_cesta_ticket]" id="mostrar-dias-cesta-ticket" <?php if ($tableConfiguration->days_cesta_ticket == 'allColumns dias-cesta-ticket') echo 'checked'; ?>> Días cesta ticket</p>
												
													<p><input class="column-mark" type="checkbox" name="columnsReport[amount_cesta_ticket]" id="mostrar-monto-cesta-ticket" <?php if ($tableConfiguration->amount_cesta_ticket == 'allColumns monto-cesta-ticket') echo 'checked'; ?>> Monto cesta ticket</p>										
												
													<p><input class="column-mark" type="checkbox" name="columnsReport[loan_cesta_ticket]" id="mostrar-prestamos-cesta-ticket" <?php if ($tableConfiguration->loan_cesta_ticket == 'allColumns prestamos-cesta-ticket') echo 'checked'; ?>> Préstamos cesta ticket</p>

													<p><input class="column-mark" type="checkbox" name="columnsReport[total_cesta_ticket]" id="mostrar-total-cesta-ticket" <?php if ($tableConfiguration->total_cesta_ticket == 'allColumns total-cesta-ticket') echo 'checked'; ?>> Total cesta ticket</p>													
											
												<?php endif; ?>
											
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" id="marcar-todos" class="glyphicon icon-checkbox-checked btn btn-default" title="Marcar todos" style="padding: 8px 12px 10px 12px"></button>
										<button type="button" id="desmarcar-todos" class="glyphicon icon-checkbox-unchecked btn btn-default" title="Desmarcar todos" style="padding: 8px 12px 10px 12px"></button>										
										<button type="button" class="glyphicon glyphicon-remove btn btn-default" data-dismiss="modal" title="Cerrar""></button>
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

						<?= $this->Html->link(__(''), ['controller' => 'Employeepayments', 'action' => 'overPayment', $paysheet->id], ['id' => 'sobre-pago', 'class' => 'glyphicon glyphicon-envelope btn btn-danger', 'title' => 'Sobre de pago sueldo']) ?>							
						
						<?php if ($paysheet->days_cesta_ticket > 0): ?>   
							<?= $this->Html->link(__(''), ['controller' => 'Employeepayments', 'action' => 'overTax', $paysheet->id], ['id' => 'sobre-islr', 'class' => 'glyphicon icon-ISLR btn btn-danger', 'title' => 'Sobre de pago retención', 'style' => 'padding: 8px 12px 10px 12px;']) ?>
							<?php if ($paysheet->days_cesta_ticket > 0): ?> 
								<button type="submit" id="ver-cesta-ticket" class="glyphicon glyphicon-eye-open btn btn-danger" title="Ver cesta ticket"></button>
							<?php else: ?>
								<button type="submit" id="ver-nomina" class="glyphicon glyphicon-eye-open btn btn-danger" title="Ver nómina"></button>
							<?php endif; ?>
						<?php endif; ?>
						
						<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'add'], ['id' => 'nuevo', 'class' => 'glyphicon glyphicon-plus-sign btn btn-danger', 'title' => 'Crear nueva nómina']) ?>
						<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'edit', $paysheet->id, 'Employeepayments', 'edit'], ['id' => 'modificar', 'class' => 'glyphicon glyphicon-edit btn btn-danger', 'title' => 'Modificar parámetros']) ?>
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
		
		$('[data-toggle="tooltip"]').tooltip();
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
			});
			
			$('.allColumns').removeClass("noverScreen");
			
		});
		
		$('#desmarcar-todos').click(function(e)
		{			
			e.preventDefault();
			
			$(".column-mark").each(function (index) 
			{ 
				$(this).attr('checked', false);
				$(this).prop('checked', false);
			});
			
			$('.allColumns').addClass("noverScreen");
			
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
            $('.cargo').addClass("noverScreen");
			$('#mostrar-cargo').attr('checked', false);
			$('#mostrar-cargo').prop('checked', false);
			
        });
		
        $('#mostrar-cargo').on('click',function()
        {
			if  ($('#mostrar-cargo').prop('checked'))
			{
				$('.cargo').removeClass("noverScreen");
				$('#mostrar-cargo').attr('checked', true);
			}
			else
			{
				$('.cargo').addClass("noverScreen");
				$('#mostrar-cargo').attr('checked', false);
			}
        });
		
        $('#fecha-ingreso').on('click',function()
        {
            $('.fecha-ingreso').addClass("noverScreen");
			$('#mostrar-fecha-ingreso').attr('checked', false);
			$('#mostrar-fecha-ingreso').prop('checked', false);
        });
		
        $('#mostrar-fecha-ingreso').on('click',function()
        {
			if  ($('#mostrar-fecha-ingreso').prop('checked'))
			{
				$('.fecha-ingreso').removeClass("noverScreen");
				$('#mostrar-fecha-ingreso').attr('checked', true);
			}
			else
			{
				$('.fecha-ingreso').addClass("noverScreen");
				$('#mostrar-fecha-ingreso').attr('checked', false);
			}
        });

        $('#sueldo-mensual').on('click',function()
        {
            $('.sueldo-mensual').addClass("noverScreen");
			$('#mostrar-sueldo-mensual').attr('checked', false);
			$('#mostrar-sueldo-mensual').prop('checked', false);
        });
		
        $('#mostrar-sueldo-mensual').on('click',function()
        {
			if  ($('#mostrar-sueldo-mensual').prop('checked'))
			{
				$('.sueldo-mensual').removeClass("noverScreen");
				$('#mostrar-sueldo-mensual').attr('checked', true);
			}
			else
			{
				$('.sueldo-mensual').addClass("noverScreen");
				$('#mostrar-sueldo-mensual').attr('checked', false);
			}
        });

        $('#pago-periodo').on('click',function()
        {
            $('.pago-periodo').addClass("noverScreen");
			$('#mostrar-pago-periodo').attr('checked', false);
			$('#mostrar-pago-periodo').prop('checked', false);
        });

        $('#mostrar-pago-periodo').on('click',function()
        {
			if  ($('#mostrar-pago-periodo').prop('checked'))
			{
				$('.pago-periodo').removeClass("noverScreen");
				$('#mostrar-pago-periodo').attr('checked', true);
			}
			else
			{
				$('.pago-periodo').addClass("noverScreen");
				$('#mostrar-pago-periodo').attr('checked', false);
			}
        });
        
        $('#escalafon').on('click',function()
        {
            $('.escalafon').addClass("noverScreen");
			$('#mostrar-escalafon').attr('checked', false);
			$('#mostrar-escalafon').prop('checked', false);
        });
		
        $('#mostrar-escalafon').on('click',function()
        {
			if  ($('#mostrar-escalafon').prop('checked'))
			{
				$('.escalafon').removeClass("noverScreen");
				$('#mostrar-escalafon').attr('checked', true);
			}
			else
			{
				$('.escalafon').addClass("noverScreen");
				$('#mostrar-escalafon').attr('checked', false);
			}
        });
        
        $('#otros-ingresos').on('click',function()
        {
            $('.otros-ingresos').addClass("noverScreen");
			$('#mostrar-otros-ingresos').attr('checked', false);
			$('#mostrar-otros-ingresos').prop('checked', false);
        });
		
        $('#mostrar-otros-ingresos').on('click',function()
        {
			if  ($('#mostrar-otros-ingresos').prop('checked'))
			{
				$('.otros-ingresos').removeClass("noverScreen");
				$('#mostrar-otros-ingresos').attr('checked', true);
			}
			else
			{
				$('.otros-ingresos').addClass("noverScreen");
				$('#mostrar-otros-ingresos').attr('checked', false);
			}
        });

        $('#faov').on('click',function()
        {
            $('.faov').addClass("noverScreen");
			$('#mostrar-faov').attr('checked', false);
			$('#mostrar-faov').prop('checked', false);
        });
		
        $('#mostrar-faov').on('click',function()
        {
			if  ($('#mostrar-faov').prop('checked'))
			{
				$('.faov').removeClass("noverScreen");
				$('#mostrar-faov').attr('checked', true);
			}
			else
			{
				$('.faov').addClass("noverScreen");
				$('#mostrar-faov').attr('checked', false);
			}
        });

        $('#ivss').on('click',function()
        {
            $('.ivss').addClass("noverScreen");
			$('#mostrar-ivss').attr('checked', false);
			$('#mostrar-ivss').prop('checked', false);
        });
		
        $('#mostrar-ivss').on('click',function()
        {
			if  ($('#mostrar-ivss').prop('checked'))
			{
				$('.ivss').removeClass("noverScreen");
				$('#mostrar-ivss').attr('checked', true);
			}
			else
			{
				$('.ivss').addClass("noverScreen");
				$('#mostrar-ivss').attr('checked', false);
			}
        });
		
        $('#dias-fideicomiso').on('click',function()
        {
            $('.dias-fideicomiso').addClass("noverScreen");
			$('#mostrar-dias-fideicomiso').attr('checked', false);
			$('#mostrar-dias-fideicomiso').prop('checked', false);
        });
		
        $('#mostrar-dias-fideicomiso').on('click',function()
        {
			if  ($('#mostrar-dias-fideicomiso').prop('checked'))
			{
				$('.dias-fideicomiso').removeClass("noverScreen");
				$('#mostrar-dias-fideicomiso').attr('checked', true);
			}
			else
			{
				$('.dias-fideicomiso').addClass("noverScreen");
				$('#mostrar-dias-fideicomiso').attr('checked', false);
			}
        });
	
        $('#fideicomiso').on('click',function()
        {
            $('.fideicomiso').addClass("noverScreen");
			$('#mostrar-fideicomiso').attr('checked', false);
			$('#mostrar-fideicomiso').prop('checked', false);
        });
		
        $('#mostrar-fideicomiso').on('click',function()
        {
			if  ($('#mostrar-fideicomiso').prop('checked'))
			{
				$('.fideicomiso').removeClass("noverScreen");
				$('#mostrar-fideicomiso').attr('checked', true);
			}
			else
			{
				$('.fideicomiso').addClass("noverScreen");
				$('#mostrar-fideicomiso').attr('checked', false);
			}
        });
	
        $('#reposo').on('click',function()
        {
            $('.reposo').addClass("noverScreen");
			$('#mostrar-reposo').attr('checked', false);
			$('#mostrar-reposo').prop('checked', false);
        });
		
        $('#mostrar-reposo').on('click',function()
        {
			if  ($('#mostrar-reposo').prop('checked'))
			{
				$('.reposo').removeClass("noverScreen");
				$('#mostrar-reposo').attr('checked', true);
			}
			else
			{
				$('.reposo').addClass("noverScreen");
				$('#mostrar-reposo').attr('checked', false);
			}
        });
		
        $('#adelanto-sueldo').on('click',function()
        {
            $('.adelanto-sueldo').addClass("noverScreen");
			$('#mostrar-adelanto-sueldo').attr('checked', false);
			$('#mostrar-adelanto-sueldo').prop('checked', false);
        });
		
        $('#mostrar-adelanto-sueldo').on('click',function()
        {
			if  ($('#mostrar-adelanto-sueldo').prop('checked'))
			{
				$('.adelanto-sueldo').removeClass("noverScreen");
				$('#mostrar-adelanto-sueldo').attr('checked', true);
			}
			else
			{
				$('.adelanto-sueldo').addClass("noverScreen");
				$('#mostrar-adelanto-sueldo').attr('checked', false);
			}
        });
	
        $('#prestamos').on('click',function()
        {
            $('.prestamos').addClass("noverScreen");
			$('#mostrar-prestamos').attr('checked', false);
			$('#mostrar-prestamos').prop('checked', false);
        });
		
        $('#mostrar-prestamos').on('click',function()
        {
			if  ($('#mostrar-prestamos').prop('checked'))
			{
				$('.prestamos').removeClass("noverScreen");
				$('#mostrar-prestamos').attr('checked', true);
			}
			else
			{
				$('.prestamos').addClass("noverScreen");
				$('#mostrar-prestamos').attr('checked', false);
			}
        });
	
        $('#porcentaje-impuesto').on('click',function()
        {
            $('.porcentaje-impuesto').addClass("noverScreen");
			$('#mostrar-porcentaje-impuesto').attr('checked', false);
			$('#mostrar-porcentaje-impuesto').prop('checked', false);
        });
		
        $('#mostrar-porcentaje-impuesto').on('click',function()
        {
			if  ($('#mostrar-porcentaje-impuesto').prop('checked'))
			{
				$('.porcentaje-impuesto').removeClass("noverScreen");
				$('#mostrar-porcentaje-impuesto').attr('checked', true);
			}
			else
			{
				$('.porcentaje-impuesto').addClass("noverScreen");
				$('#mostrar-porcentaje-impuesto').attr('checked', false);
			}
        });
	
        $('#monto-impuesto').on('click',function()
        {
            $('.monto-impuesto').addClass("noverScreen");
			$('#mostrar-monto-impuesto').attr('checked', false);
			$('#mostrar-monto-impuesto').prop('checked', false);
        });
		
        $('#mostrar-monto-impuesto').on('click',function()
        {
			if  ($('#mostrar-monto-impuesto').prop('checked'))
			{
				$('.monto-impuesto').removeClass("noverScreen");
				$('#mostrar-monto-impuesto').attr('checked', true);
			}
			else
			{
				$('.monto-impuesto').addClass("noverScreen");
				$('#mostrar-monto-impuesto').attr('checked', false);
			}
        });
	
        $('#dias-inasistencias').on('click',function()
        {
            $('.dias-inasistencias').addClass("noverScreen");
			$('#mostrar-dias-inasistencias').attr('checked', false);
			$('#mostrar-dias-inasistencias').prop('checked', false);
        });
		
        $('#mostrar-dias-inasistencias').on('click',function()
        {
			if  ($('#mostrar-dias-inasistencias').prop('checked'))
			{
				$('.dias-inasistencias').removeClass("noverScreen");
				$('#mostrar-dias-inasistencias').attr('checked', true);
			}
			else
			{
				$('.dias-inasistencias').addClass("noverScreen");
				$('#mostrar-dias-inasistencias').attr('checked', false);
			}
        });
	
        $('#inasistencias').on('click',function()
        {
            $('.inasistencias').addClass("noverScreen");
			$('#mostrar-inasistencias').attr('checked', false);
			$('#mostrar-inasistencias').prop('checked', false);
        });
		
        $('#mostrar-inasistencias').on('click',function()
        {
			if  ($('#mostrar-inasistencias').prop('checked'))
			{
				$('.inasistencias').removeClass("noverScreen");
				$('#mostrar-inasistencias').attr('checked', true);
			}
			else
			{
				$('.inasistencias').addClass("noverScreen");
				$('#mostrar-inasistencias').attr('checked', false);
			}
        });
	        
        $('#total-pago').on('click',function()
        {
            $('.total-pago').addClass("noverScreen");
			$('#mostrar-total-pago').attr('checked', false);
			$('#mostrar-total-pago').prop('checked', false);
        });
		
        $('#mostrar-total-pago').on('click',function()
        {
			if  ($('#mostrar-total-pago').prop('checked'))
			{
				$('.total-pago').removeClass("noverScreen");
				$('#mostrar-total-pago').attr('checked', true);
			}
			else
			{
				$('.total-pago').addClass("noverScreen");
				$('#mostrar-total-pago').attr('checked', false);
			}
        });
	
        $('#dias-cesta-ticket').on('click',function()
        {
            $('.dias-cesta-ticket').addClass("noverScreen");
			$('#mostrar-dias-cesta-ticket').attr('checked', false);
			$('#mostrar-dias-cesta-ticket').prop('checked', false);
        });
		
        $('#mostrar-dias-cesta-ticket').on('click',function()
        {
			if  ($('#mostrar-dias-cesta-ticket').prop('checked'))
			{
				$('.dias-cesta-ticket').removeClass("noverScreen");
				$('#mostrar-dias-cesta-ticket').attr('checked', true);
			}
			else
			{
				$('.dias-cesta-ticket').addClass("noverScreen");
				$('#mostrar-dias-cesta-ticket').attr('checked', false);
			}
        });
			
        $('#monto-cesta-ticket').on('click',function()
        {
            $('.monto-cesta-ticket').addClass("noverScreen");
			$('#mostrar-monto-cesta-ticket').attr('checked', false);
			$('#mostrar-monto-cesta-ticket').prop('checked', false);
        });
		
        $('#mostrar-monto-cesta-ticket').on('click',function()
        {
			if  ($('#mostrar-monto-cesta-ticket').prop('checked'))
			{
				$('.monto-cesta-ticket').removeClass("noverScreen");
				$('#mostrar-monto-cesta-ticket').attr('checked', true);
			}
			else
			{
				$('.monto-cesta-ticket').addClass("noverScreen");
				$('#mostrar-monto-cesta-ticket').attr('checked', false);
			}
        });
					
        $('#prestamos-cesta-ticket').on('click',function()
        {
            $('.prestamos-cesta-ticket').addClass("noverScreen");
			$('#mostrar-prestamos-cesta-ticket').attr('checked', false);
			$('#mostrar-prestamos-cesta-ticket').prop('checked', false);
        });
		
        $('#mostrar-prestamos-cesta-ticket').on('click',function()
        {
			if  ($('#mostrar-prestamos-cesta-ticket').prop('checked'))
			{
				$('.prestamos-cesta-ticket').removeClass("noverScreen");
				$('#prestamos-loan-cesta-ticket').attr('checked', true);
			}
			else
			{
				$('.prestamos-cesta-ticket').addClass("noverScreen");
				$('#mostrar-prestamos-cesta-ticket').attr('checked', false);
			}
        });
					
        $('#total-cesta-ticket').on('click',function()
        {
            $('.total-cesta-ticket').addClass("noverScreen");
			$('#mostrar-total-cesta-ticket').attr('checked', false);
			$('#mostrar-total-cesta-ticket').prop('checked', false);
        });
		
        $('#mostrar-total-cesta-ticket').on('click',function()
        {
			if  ($('#mostrar-total-cesta-ticket').prop('checked'))
			{
				$('.total-cesta-ticket').removeClass("noverScreen");
				$('#mostrar-total-cesta-ticket').attr('checked', true);
			}
			else
			{
				$('.total-cesta-ticket').addClass("noverScreen");
				$('#mostrar-total-cesta-ticket').attr('checked', false);
			}
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