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
					<button type="submit" id="search-fortnight" class="glyphicon glyphicon-search btn btn-default"></button>
				</div>
			</div>
		<?= $this->Form->end() ?>
		<h4>Nómina del personal <?= $paysheet->positioncategory->description_category . ' correspondiente a ' . $paysheet->payroll_name . ' período del ' . $paysheet->date_from->format('d-m-Y') . ' al ' . $paysheet->date_until->format('d-m-Y') ?></h4>
	</div>
       	
    <div>				
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
                                        <th scope="col">Nro.</th>
                                        <th scope="col" class="fixed">Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                                        <th scope="col" class='sw-cesta-ticket'></th>                                        
										
										<?php if ($tableConfiguration->identidy == 0): ?>
											<th scope="col" class='cedula'><a href="#" id='cedula' title='Cédula'>+</a></th>
											<th scope="col" class='datos-cedula' style='display: none;'><a href="#" id='datos-cedula' title='Ocultar cédula'>Cédula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
										<?php else: ?>
											<th scope="col" class='cedula' style='display: none;'><a href="#" id='cedula' title='Cédula'>+</a></th>
											<th scope="col" class='datos-cedula'><a href="#" id='datos-cedula' title='Ocultar cédula'>Cédula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
										<?php endif; ?>                                        

										<?php if ($tableConfiguration->position == 0): ?>
											<th scope="col" class='cargo'><a href="#" id='cargo' title='Cargo'>+</a></th>
											<th scope="col" class='datos-cargo' style='display: none;'><a href="#" id='datos-cargo' title='Ocultar cargo'>Cargo</a></th>
										<?php else: ?>
											<th scope="col" class='cargo' style='display: none;'><a href="#" id='cargo' title='Cargo'>+</a></th>
											<th scope="col" class='datos-cargo'><a href="#" id='datos-cargo' title='Ocultar cargo'>Cargo</a></th>
										<?php endif; ?>
																				
										<?php if ($tableConfiguration->sw_cesta_ticket == 0): ?>
		
											<?php if ($tableConfiguration->date_of_admission == 0): ?>
												<th scope="col" class='fecha-ingreso'><a href="#" id='fecha-ingreso' title='Fecha ingreso'>+</a></th>
												<th scope="col" class='datos-fecha-ingreso' style='display: none;'><a href="#" id='datos-fecha-ingreso' title='Ocultar fecha de ingreso'>Fecha&nbsp;ingreso</a></th>
											<?php else: ?>
												<th scope="col" class='fecha-ingreso' style='display: none;'><a href="#" id='fecha-ingreso' title='Fecha ingreso'>+</a></th>
												<th scope="col" class='datos-fecha-ingreso'><a href="#" id='datos-fecha-ingreso' title='Ocultar fecha de ingreso'>Fecha&nbsp;ingreso</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->monthly_salary == 0): ?>
												<th scope="col" class='sueldo-mensual'><a href="#" id='sueldo-mensual' title='Sueldo mensual'>+</a></th>
												<th scope="col" class='datos-sueldo-mensual' style='display: none;'><a href="#" id='datos-sueldo-mensual' title='Ocultar sueldo mensual'>Sueldo&nbsp;mens.</a></th>
											<?php else: ?>
												<th scope="col" class='sueldo-mensual' style='display: none;'><a href="#" id='sueldo-mensual' title='Sueldo mensual'>+</a></th>
												<th scope="col" class='datos-sueldo-mensual'><a href="#" id='datos-sueldo-mensual' title='Ocultar sueldo mensual'>Sueldo&nbsp;mens.</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->fortnight == 0): ?>
												<th scope="col" class='quincena'><a href="#" id='quincena' title='Quincena'>+</a></th>
												<th scope="col" class='datos-quincena' style='display: none;'><a href="#" id='datos-quincena' title='Ocultar quincena'>Quincena&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='quincena' style='display: none;'><a href="#" id='quincena' title='Quincena'>+</a></th>
												<th scope="col" class='datos-quincena'><a href="#" id='datos-quincena' title='Ocultar quincena'>Quincena&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php endif; ?>
		
											<?php if ($tableConfiguration->amount_escalation_fortnight == 0): ?>
												<th scope="col" class='escalafon'><a href="#" id='escalafon' title='Escalafón'>+</a></th>
												<th scope="col" class='datos-escalafon' style='display: none;'><a href="#" id='datos-escalafon' title='Ocultar escalafón'>Escalafón&nbsp;&nbsp;&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='escalafon' style='display: none;'><a href="#" id='escalafon' title='Escalafón'>+</a></th>
												<th scope="col" class='datos-escalafon'><a href="#" id='datos-escalafon' title='Ocultar escalafón'>Escalafón&nbsp;&nbsp;&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->other_income == 0): ?>
												<th scope="col" class='otros-ingresos'><a href="#" id='otros-ingresos' title='Otros ingresos'>+</a></th>
												<th scope="col" class='datos-otros-ingresos' style='display: none;'><a href="#" id='datos-otros-ingresos' title='Ocultar otros ingresos'>Otros&nbsp;ingresos</a></th>
											<?php else: ?>
												<th scope="col" class='otros-ingresos' style='display: none;'><a href="#" id='otros-ingresos' title='Otros ingresos'>+</a></th>
												<th scope="col" class='datos-otros-ingresos'><a href="#" id='datos-otros-ingresos' title='Ocultar otros ingresos'>Otros&nbsp;ingresos</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->faov == 0): ?>
												<th scope="col" class='faov'><a href="#" id='faov' title='FAOV'>+</a></th>
												<th scope="col" class='datos-faov' style='display: none;'><a href="#" id='datos-faov' title='Ocultar FAOV'>FAOV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='faov' style='display: none;'><a href="#" id='faov' title='FAOV'>+</a></th>
												<th scope="col" class='datos-faov'><a href="#" id='datos-faov' title='Ocultar FAOV'>FAOV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->ivss == 0): ?>
												<th scope="col" class='ivss'><a href="#" id='ivss' title='IVSS'>+</a></th>
												<th scope="col" class='datos-ivss' style='display: none;'><a href="#" id='datos-ivss' title='Ocultar IVSS'>IVSS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='ivss' style='display: none;'><a href="#" id='ivss' title='IVSS'>+</a></th>
												<th scope="col" class='datos-ivss'><a href="#" id='datos-ivss' title='Ocultar IVSS'>IVSS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->trust_days == 0): ?>
												<th scope="col" class='dias-fideicomiso'><a href="#" id='dias-fideicomiso' title='Días fideicomiso'>+</a></th>
												<th scope="col" class='datos-dias-fideicomiso' style='display: none;'><a href="#" id='datos-dias-fideicomiso' title='Ocultar días fideicomiso'>Días&nbsp;fidei.</a></th>
											<?php else: ?>
												<th scope="col" class='dias-fideicomiso' style='display: none;'><a href="#" id='dias-fideicomiso' title='Días fideicomiso'>+</a></th>
												<th scope="col" class='datos-dias-fideicomiso'><a href="#" id='datos-dias-fideicomiso' title='Ocultar días fideicomiso'>Días&nbsp;fidei.</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->escrow == 0): ?>
												<th scope="col" class='fideicomiso'><a href="#" id='fideicomiso' title='Fideicomiso'>+</a></th>
												<th scope="col" class='datos-fideicomiso' style='display: none;'><a href="#" id='datos-fideicomiso' title='Ocultar fideicomiso'>Fideicomiso</a></a></th>
											<?php else: ?>
												<th scope="col" class='fideicomiso' style='display: none;'><a href="#" id='fideicomiso' title='Fideicomiso'>+</a></th>
												<th scope="col" class='datos-fideicomiso'><a href="#" id='datos-fideicomiso' title='Ocultar fideicomiso'>Fideicomiso</a></a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->discount_repose == 0): ?>
												<th scope="col" class='reposo'><a href="#" id='reposo' title='Reposo'>+</a></th>
												<th scope="col" class='datos-reposo' style='display: none;'><a href="#" id='datos-reposo' title='Ocultar reposo'>Reposo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='reposo' style='display: none;'><a href="#" id='reposo' title='Reposo'>+</a></th>
												<th scope="col" class='datos-reposo'><a href="#" id='datos-reposo' title='Ocultar reposo'>Reposo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->salary_advance == 0): ?>    
												<th scope="col" class='adelanto-sueldo'><a href="#" id='adelanto-sueldo' title='Adelanto de sueldo'>+</a></th>
												<th scope="col" class='datos-adelanto-sueldo' style='display: none;'><a href="#" id='datos-adelanto-sueldo' title='Ocultar adelanto sueldo'>Adelan.&nbsp;sueldo</a></th>
											<?php else: ?>
												<th scope="col" class='adelanto-sueldo' style='display: none;'><a href="#" id='adelanto-sueldo' title='Adelanto de sueldo'>+</a></th>
												<th scope="col" class='datos-adelanto-sueldo'><a href="#" id='datos-adelanto-sueldo' title='Ocultar adelanto sueldo'>Adelan.&nbsp;sueldo</a></th>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->discount_loan == 0): ?>
												<th scope="col" class='prestamos'><a href="#" id='prestamos' title='Préstamos'>+</a></th>
												<th scope="col" class='datos-prestamos' style='display: none;'><a href="#" id='datos-prestamos' title='Ocultar préstamos'>Préstamos</a></th>
											<?php else: ?>
												<th scope="col" class='prestamos' style='display: none;'><a href="#" id='prestamos' title='Préstamos'>+</a></th>
												<th scope="col" class='datos-prestamos'><a href="#" id='datos-prestamos' title='Ocultar préstamos'>Préstamos</a></th>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->percentage_imposed == 0): ?>
												<th scope="col" class='porcentaje-impuesto'><a href="#" id='porcentaje-impuesto' title='Porcentaje impuesto'>+</a></th>
												<th scope="col" class='datos-porcentaje-impuesto' style='display: none;'><a href="#" id='datos-porcentaje-impuesto' title='Ocultar porcentaje impuesto'>%&nbsp;Imp.&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='porcentaje-impuesto' style='display: none;'><a href="#" id='porcentaje-impuesto' title='Porcentaje impuesto'>+</a></th>
												<th scope="col" class='datos-porcentaje-impuesto'><a href="#" id='datos-porcentaje-impuesto' title='Ocultar porcentaje impuesto'>%&nbsp;Imp.&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->amount_imposed == 0): ?>
												<th scope="col" class='monto-impuesto'><a href="#" id='monto-impuesto' title='Monto impuesto'>+</a></th>
												<th scope="col" class='datos-monto-impuesto' style='display: none;'><a href="#" id='datos-monto-impuesto' title='Ocultar monto impuesto'>Monto&nbsp;Imp.&nbsp;</a></th>
											<?php else: ?>
												<th scope="col" class='monto-impuesto' style='display: none;'><a href="#" id='monto-impuesto' title='Monto impuesto'>+</a></th>
												<th scope="col" class='datos-monto-impuesto'><a href="#" id='datos-monto-impuesto' title='Ocultar monto impuesto'>Monto&nbsp;Imp.&nbsp;</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->days_absence == 0): ?>
												<th scope="col" class='dias-inasistencias'><a href="#" id='dias-inasistencias' title='Días inasistencias'>+</a></th>
												<th scope="col" class='datos-dias-inasistencias' style='display: none;'><a href="#" id='datos-dias-inasistencias' title='Ocultar días inasistencias'>Días&nbsp;Inasist.</a></th>
											<?php else: ?>
												<th scope="col" class='dias-inasistencias' style='display: none;'><a href="#" id='dias-inasistencias' title='Días inasistencias'>+</a></th>
												<th scope="col" class='datos-dias-inasistencias'><a href="#" id='datos-dias-inasistencias' title='Ocultar días inasistencias'>Días&nbsp;Inasist.</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->discount_absences == 0): ?>
												<th scope="col" class='inasistencias'><a href="#" id='inasistencias' title='Inasistencias'>+</a></th>
												<th scope="col" class='datos-inasistencias' style='display: none;'><a href="#" id='datos-inasistencias' title='Ocultar inasistencias'>Inasistencias</a></th>
											<?php else: ?>
												<th scope="col" class='inasistencias' style='display: none;'><a href="#" id='inasistencias' title='Inasistencias'>+</a></th>
												<th scope="col" class='datos-inasistencias'><a href="#" id='datos-inasistencias' title='Ocultar inasistencias'>Inasistencias</a></th>
											<?php endif; ?>

											<?php if ($tableConfiguration->total_payment == 0): ?>
												<th scope="col" class='total-quincena'><a href="#" id='total-quincena' title='Total quincena'>+</a></th>
												<th scope="col" class='datos-total-quincena' style='display: none;'><a href="#" id='datos-total-quincena' title='Ocultar total quincena'>Tot.&nbsp;Quinc.</a></th>
											<?php else: ?>
												<th scope="col" class='total-quincena' style='display: none;'><a href="#" id='total-quincena' title='Total quincena'>+</a></th>
												<th scope="col" class='datos-total-quincena'><a href="#" id='datos-total-quincena' title='Ocultar total quincena'>Tot.&nbsp;Quinc.</a></th>
											<?php endif; ?>
										
										<?php else: ?>
			
											<?php if ($tableConfiguration->days_cesta_ticket == 0): ?>
												<th scope="col" class='days-cesta-ticket'><a href="#" id='days-cesta-ticket' title='Días cesta ticket'>+</a></th>
												<th scope="col" class='datos-days-cesta-ticket' style='display: none;'><a href="#" id='datos-days-cesta-ticket' title='Ocultar días cesta ticket'>Días&nbsp;cesta&nbsp;ticket</a></th>
											<?php else: ?>
												<th scope="col" class='days-cesta-ticket' style='display: none;'><a href="#" id='days-cesta-ticket' title='Días cesta ticket'>+</a></th>
												<th scope="col" class='datos-days-cesta-ticket'><a href="#" id='datos-days-cesta-ticket' title='Ocultar días cesta ticket'>Días&nbsp;cesta&nbsp;ticket</a></th>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->amount_cesta_ticket == 0): ?>
												<th scope="col" class='amount-cesta-ticket'><a href="#" id='amount-cesta-ticket' title='Monto cesta ticket'>+</a></th>
												<th scope="col" class='datos-amount-cesta-ticket' style='display: none;'><a href="#" id='datos-amount-cesta-ticket' title='Ocultar monto cesta ticket'>Monto&nbsp;cesta&nbsp;ticket</a></th>
											<?php else: ?>
												<th scope="col" class='amount-cesta-ticket' style='display: none;'><a href="#" id='amount-cesta-ticket' title='Monto cesta ticket'>+</a></th>
												<th scope="col" class='datos-amount-cesta-ticket'><a href="#" id='datos-amount-cesta-ticket' title='Ocultar monto cesta ticket'>Monto&nbsp;cesta&nbsp;ticket</a></th>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->loan_cesta_ticket == 0): ?>
												<th scope="col" class='loan-cesta-ticket'><a href="#" id='loan-cesta-ticket' title='Préstamos cesta ticket'>+</a></th>
												<th scope="col" class='datos-loan-cesta-ticket' style='display: none;'><a href="#" id='datos-loan-cesta-ticket' title='Ocultar préstamo cesta ticket'>Préstamo&nbsp;cesta&nbsp;ticket</a></th>
											<?php else: ?>
												<th scope="col" class='loan-cesta-ticket' style='display: none;'><a href="#" id='loan-cesta-ticket' title='Préstamo cesta ticket'>+</a></th>
												<th scope="col" class='datos-loan-cesta-ticket'><a href="#" id='datos-loan-cesta-ticket' title='Ocultar préstamo cesta ticket'>Préstamo&nbsp;cesta&nbsp;ticket</a></th>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->total_cesta_ticket == 0): ?>
												<th scope="col" class='total-cesta-ticket'><a href="#" id='total-cesta-ticket' title='Total cesta ticket'>+</a></th>
												<th scope="col" class='datos-total-cesta-ticket' style='display: none;'><a href="#" id='datos-total-cesta-ticket' title='Ocultar total cesta ticket'>Total&nbsp;cesta&nbsp;ticket</a></th>
											<?php else: ?>
												<th scope="col" class='total-cesta-ticket' style='display: none;'><a href="#" id='total-cesta-ticket' title='Total cesta ticket'>+</a></th>
												<th scope="col" class='datos-total-cesta-ticket'><a href="#" id='datos-total-cesta-ticket' title='Ocultar total cesta ticket'>Total&nbsp;cesta&nbsp;ticket</a></th>
											<?php endif; ?>
																		
										<?php endif; ?>
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
                                            
                                            <td><?= $accountEmployee ?></td>
                                            
                                            <td><?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></td>
											
											<?php if ($tableConfiguration->sw_cesta_ticket == 0): ?>
												<td class='sw-cesta-ticket'><input type='hidden' class='ver-sw-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_sw_cesta_ticket]" value='0'></td>
											<?php else: ?>
												<td class='sw-cesta-ticket'><input type='hidden' class='ver-sw-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_sw_cesta_ticket]" value='1'></td>
											<?php endif; ?>
                                            
                                            <?php $apellidos = explode(' ', $employeesFors->employee->surname); ?>
                                            <?php $nombres = explode(' ', $employeesFors->employee->first_name); ?>
																				
											<?php if ($tableConfiguration->identidy == 0): ?>
												<td class='cedula'><input type='hidden' class='ver-cedula' name="employeepayment[<?= $accountArray ?>][view_identidy]" value='0'></td>
												<td class='datos-cedula' style='display: none;'><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>
											<?php else: ?>
												<td class='cedula' style='display: none;'><input type='hidden' class='ver-cedula' name="employeepayment[<?= $accountArray ?>][view_identidy]" value='1'></td>
												<td class='datos-cedula'><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>
											<?php endif; ?>

											<?php if ($tableConfiguration->position == 0): ?>
												<td class='cargo'><input type='hidden' class='ver-cargo' name="employeepayment[<?= $accountArray ?>][view_position]" value='0'></td>
												<td class="datos-cargo" style='display: none;'><?= $employeesFors->current_position ?></td>
											<?php else: ?>
												<td class='cargo' style='display: none;'><input type='hidden' class='ver-cargo' name="employeepayment[<?= $accountArray ?>][view_position]" value='1'></td>
												<td class="datos-cargo"><?= $employeesFors->current_position ?></td>
											<?php endif; ?>
											
											<?php if ($tableConfiguration->sw_cesta_ticket == 0): ?>

												<?php if ($tableConfiguration->date_of_admission == 0): ?>
													<td class='fecha-ingreso'><input type='hidden' class='ver-fecha-ingreso' name="employeepayment[<?= $accountArray ?>][view_date_of_admission]" value='0'></td>
													<td class="datos-fecha-ingreso" style='display: none;'><input disabled='true' class='input-fecha-ingreso' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Fecha&nbsp;de&nbsp;ingreso' ?> style="text-align: center; width: 100%;" name="employeepayment[<?= $accountArray ?>][date_of_admission]" value=<?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?>></td>
												<?php else: ?>    
													<td class='fecha-ingreso' style='display: none'><input type='hidden' class='ver-fecha-ingreso' name="employeepayment[<?= $accountArray ?>][view_date_of_admission]" value='1'></td>
													<td class="datos-fecha-ingreso"><input disabled='true' class='input-fecha-ingreso' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Fecha&nbsp;de&nbsp;ingreso' ?> style="text-align: center; width: 100%;" name="employeepayment[<?= $accountArray ?>][date_of_admission]" value=<?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->monthly_salary == 0): ?>
													<td class='sueldo-mensual'><input type='hidden' class='ver-sueldo-mensual' name="employeepayment[<?= $accountArray ?>][view_monthly_salary]" value='0'></td>
													<td class="datos-sueldo-mensual" style='display: none;'><input disabled='true' class='input-sueldo-mensual' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Sueldo&nbsp;mensual' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][monthly_salary]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='sueldo-mensual' style='display: none;'><input type='hidden' class='ver-sueldo-mensual' name="employeepayment[<?= $accountArray ?>][view_monthly_salary]" value='1'></td>
													<td class="datos-sueldo-mensual" style='text-align: right;'><input disabled='true' class='input-sueldo-mensual' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Sueldo&nbsp;mensual' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][monthly_salary]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?>></td>
												<?php endif; ?>
		
												<?php if ($tableConfiguration->fortnight == 0): ?>
													<td class='quincena'><input type='hidden' class='ver-quincena' name="employeepayment[<?= $accountArray ?>][view_fortnight]" value='0'></td>
													<td class='datos-quincena' style='display: none;'><input disabled='true' class='input-quincena' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Quincena' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][fortnight]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->fortnight, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='quincena' style='display: none;'><input type='hidden' class='ver-quincena' name="employeepayment[<?= $accountArray ?>][view_fortnight]" value='1'></td>
													<td class='datos-quincena' style='text-align: right;'><input disabled='true' class='input-quincena' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Quincena' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][fortnight]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->fortnight, 2, ",", ".") ?>></td>
												<?php endif; ?>
												
												<?php if ($tableConfiguration->amount_escalation_fortnight == 0): ?>
													<td class='escalafon'><input type='hidden' class='ver-escalafon' name="employeepayment[<?= $accountArray ?>][view_amount_escalation_fortnight]" value='0'></td>
													<td class='datos-escalafon' style='display: none;'><input disabled='true' class='input-escalafon' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Escalafón' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_escalation_fortnight]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='escalafon' style='display: none'><input type='hidden' class='ver-escalafon' name="employeepayment[<?= $accountArray ?>][view_amount_escalation_fortnight]" value='1'></td>
													<td class='datos-escalafon' style='text-align: right;'><input disabled='true' class='input-escalafon' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Escalafón' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_escalation_fortnight]" class="alternative-decimal-separator" value=<?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->other_income == 0): ?>
													<td class='otros-ingresos'><input type='hidden' class='ver-otros-ingresos' name="employeepayment[<?= $accountArray ?>][view_other_income]" value='0'></td>
													<td class='datos-otros-ingresos' style='display: none;'><input class='input-otros-ingresos alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Otros&nbsp;ingresos' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][other_income]" value=<?= number_format($employeesFors->other_income, 2, ",", ".") ?>></td> 
												<?php else: ?>
													<td class='otros-ingresos' style='display: none'><input type='hidden' class='ver-otros-ingresos' name="employeepayment[<?= $accountArray ?>][view_other_income]" value='1'></td>
													<td class='datos-otros-ingresos'><input class='input-otros-ingresos alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Otros&nbsp;ingresos' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][other_income]" value=<?= number_format($employeesFors->other_income, 2, ",", ".") ?>></td> 
												<?php endif; ?>
						
												<?php if ($tableConfiguration->faov == 0): ?>
													<td class='faov'><input type='hidden' class='ver-faov' name="employeepayment[<?= $accountArray ?>][view_faov]" value='0'></td>
													<td class='datos-faov' style='display: none;'><input disabled='true' class='input-faov' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'FAOV' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][faov]" value=<?= number_format($employeesFors->faov, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='faov' style='display: none;'><input type='hidden' class='ver-faov' name="employeepayment[<?= $accountArray ?>][view_faov]" value='1'></td>
													<td class='datos-faov' style='text-align: right;'><input disabled='true' class='input-faov' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'FAOV' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][faov]" value=<?= number_format($employeesFors->faov, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->ivss == 0): ?>
													<td class='ivss'><input type='hidden' class='ver-ivss' name="employeepayment[<?= $accountArray ?>][view_ivss]" value='0'></td>
													<td class='datos-ivss' style='display: none;'><input disabled='true' class='input-ivss' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'IVSS' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][ivss]" value=<?= number_format($employeesFors->ivss, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='ivss' style='display: none;'><input type='hidden' class='ver-ivss' name="employeepayment[<?= $accountArray ?>][view_ivss]" value='1'></td>
													<td class='datos-ivss' style='text-align: right;'><input disabled='true' class='input-ivss' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'IVSS' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][ivss]" value=<?= number_format($employeesFors->ivss, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->trust_days == 0): ?>
													<td class='dias-fideicomiso'><input type='hidden' class='ver-dias-fideicomiso' name="employeepayment[<?= $accountArray ?>][view_trust_days]" value='0'></td>
													<td class='datos-dias-fideicomiso' style='display: none;'><input class='input-dias-fideicomiso alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;fideicomiso' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][trust_days]" value=<?= number_format($employeesFors->trust_days, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='dias-fideicomiso' style='display: none;'><input type='hidden' class='ver-dias-fideicomiso' name="employeepayment[<?= $accountArray ?>][view_trust_days]" value='1'></td>
													<td class='datos-dias-fideicomiso' style='text-align: right;'><input class='input-dias-fideicomiso alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;fideicomiso' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][trust_days]" value=<?= number_format($employeesFors->trust_days, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->escrow == 0): ?>
													<td class='fideicomiso'><input type='hidden' class='ver-fideicomiso' name="employeepayment[<?= $accountArray ?>][view_escrow]" value='0'></td>
													<td class='datos-fideicomiso' style='display: none;'><input disabled='true' class='input-fideicomiso' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Fideicomiso' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][escrow]" value=<?= number_format(($employeesFors->trust_days * $employeesFors->integral_salary), 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='fideicomiso' style='display: none;'><input type='hidden' class='ver-fideicomiso' name="employeepayment[<?= $accountArray ?>][view_escrow]" value='1'></td>
													<td class='datos-fideicomiso' style='text-align: right;'><input disabled='true' class='input-fideicomiso' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Fideicomiso' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][escrow]" value=<?= number_format(($employeesFors->trust_days * $employeesFors->integral_salary), 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->discount_repose == 0): ?>
													<td class='reposo'><input type='hidden' class='ver-reposo' name="employeepayment[<?= $accountArray ?>][view_discount_repose]" value='0'></td>
													<td class='datos-reposo' style='display: none;'><input class='input-reposo alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Reposo' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_repose]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_repose, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='reposo' style='display: none;'><input type='hidden' class='ver-reposo' name="employeepayment[<?= $accountArray ?>][view_discount_repose]" value='1'></td>
													<td class='datos-reposo'><input class='input-reposo alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Reposo' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_repose]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_repose, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->salary_advance == 0): ?>    
													<td class='adelanto-sueldo'><input type='hidden' class='ver-adelanto-sueldo' name="employeepayment[<?= $accountArray ?>][view_salary_advance]" value='0'></td>
													<td class='datos-adelanto-sueldo' style='display: none;'><input class='input-adelanto-sueldo alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Adelanto&nbsp;sueldo' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][salary_advance]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->salary_advance, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='adelanto-sueldo' style='display: none'><input type='hidden' class='ver-adelanto-sueldo' name="employeepayment[<?= $accountArray ?>][view_salary_advance]" value='1'></td>
													<td class='datos-adelanto-sueldo'><input class='input-adelanto-sueldo alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Adelanto&nbsp;sueldo' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][salary_advance]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->salary_advance, 2, ",", ".") ?>></td>
												<?php endif; ?>
												
												<?php if ($tableConfiguration->discount_loan == 0): ?>
													<td class='prestamos'><input type='hidden' class='ver-prestamos' name="employeepayment[<?= $accountArray ?>][view_discount_loan]" value='0'></td>
													<td class='datos-prestamos' style='display: none;'><input class='input-prestamos alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Préstamos' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_loan]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_loan, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='prestamos' style='display: none;'><input type='hidden' class='ver-prestamos' name="employeepayment[<?= $accountArray ?>][view_discount_loan]" value='1'></td>
													<td class='datos-prestamos'><input class='input-prestamos alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Préstamos' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][discount_loan]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->discount_loan, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->percentage_imposed == 0): ?>
													<td class='porcentaje-impuesto'><input type='hidden' class='ver-porcentaje-impuesto' name="employeepayment[<?= $accountArray ?>][view_percentage_imposed]" value='0'></td>
													<td class='datos-porcentaje-impuesto' style='display: none;'><input class='input-porcentaje-impuesto alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Porcentaje&nbsp;impuesto' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][percentage_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='porcentaje-impuesto' style='display: none;'><input type='hidden' class='ver-porcentaje-impuesto' name="employeepayment[<?= $accountArray ?>][view_percentage_imposed]" value='1'></td>
													<td class='datos-porcentaje-impuesto'><input class='input-porcentaje-impuesto alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Porcentaje&nbsp;impuesto' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][percentage_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->amount_imposed == 0): ?>
													<td class='monto-impuesto'><input type='hidden' class='ver-monto-impuesto' name="employeepayment[<?= $accountArray ?>][view_amount_imposed]" value='0'></td>
													<td class='datos-monto-impuesto' style='display: none;'><input  disabled='true' class='input-monto-impuesto' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Monto&nbsp;impuesto' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='monto-impuesto' style='display: none;'><input type='hidden' class='ver-monto-impuesto' name="employeepayment[<?= $accountArray ?>][view_amount_imposed]" value='1'></td>
													<td class='datos-monto-impuesto'><input  disabled='true' class='input-monto-impuesto' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Monto&nbsp;impuesto' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][amount_imposed]" class="alternative-decimal-separator" value=<?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->days_absence == 0): ?>
													<td class='dias-inasistencias'><input type='hidden' class='ver-dias-inasistencias' name="employeepayment[<?= $accountArray ?>][view_days_absence]" value='0'></td>
													<td class='datos-dias-inasistencias' style='display: none;'><input class='input-dias-inasistencias alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;inasistencias' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][days_absence]" value=<?= number_format($employeesFors->days_absence, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='dias-inasistencias' style='display: none;'><input type='hidden' class='ver-dias-inasistencias' name="employeepayment[<?= $accountArray ?>][view_days_absence]" value='1'></td>
													<td class='datos-dias-inasistencias' style='text-align: right;'><input class='input-dias-inasistencias alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;inasistencias' ?> style="text-align: right; width: 100%;" name="employeepayment[<?= $accountArray ?>][days_absence]" value=<?= number_format($employeesFors->days_absence, 2, ",", ".") ?>></td>
												<?php endif; ?>
		
												<?php if ($tableConfiguration->discount_absences == 0): ?>
													<td class='inasistencias'><input type='hidden' class='ver-inasistencias' name="employeepayment[<?= $accountArray ?>][view_discount_absences]" value='0'></td>
													<td class='datos-inasistencias' style='display: none;'><input disabled='true' class='input-inasistencia' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Inasistencias' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][discount_absences]" value=<?= number_format($employeesFors->discount_absences, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='inasistencias' style='display: none;'><input type='hidden' class='ver-inasistencias' name="employeepayment[<?= $accountArray ?>][view_discount_absences]" value='1'></td>
													<td class='datos-inasistencias'><input disabled='true' class='input-inasistencia' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Inasistencias' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][discount_absences]" value=<?= number_format($employeesFors->discount_absences, 2, ",", ".") ?>></td>
												<?php endif; ?>

												<?php if ($tableConfiguration->total_payment == 0): ?>
													<td class='total-quincena'><input type='hidden' class='ver-total-quincena' name="employeepayment[<?= $accountArray ?>][view_total_payment]" value='0'></td>
													<td class='datos-total-quincena' style='display: none;'><input disabled='true' class='input-total-quincena' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Total&nbsp;quincena' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_payment]" value=<?= number_format($employeesFors->total_payment, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='total-quincena' style='display: none;'><input type='hidden' class='ver-total-quincena' name="employeepayment[<?= $accountArray ?>][view_total_payment]" value='1'></td>
													<td class='datos-total-quincena'><input disabled='true' class='input-total-quincena' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Total&nbsp;quincena' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_payment]" value=<?= number_format($employeesFors->total_payment, 2, ",", ".") ?>></td>
												<?php endif; ?>

											<?php else: ?>
																						
												<?php if ($tableConfiguration->days_cesta_ticket == 0): ?>
													<td class='days-cesta-ticket'><input type='hidden' class='ver-days-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_days_cesta_ticket]" value='0'></td>
													<td class='datos-days-cesta-ticket' style='display: none;'><input class='input-days-cesta-ticket alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][days_cesta_ticket]" value=<?= number_format($employeesFors->days_cesta_ticket, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='days-cesta-ticket' style='display: none;'><input type='hidden' class='ver-days-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_days_cesta_ticket]" value='1'></td>
													<td class='datos-days-cesta-ticket'><input class='input-days-cesta-ticket alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Días&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][days_cesta_ticket]" value=<?= number_format($employeesFors->days_cesta_ticket, 2, ",", ".") ?>></td>
												<?php endif; ?>
											
												<?php if ($tableConfiguration->amount_cesta_ticket == 0): ?>
													<td class='amount-cesta-ticket'><input type='hidden' class='ver-amount-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_amount_cesta_ticket]" value='0'></td>
													<td class='datos-amount-cesta-ticket' style='display: none;'><input disabled='true' class='input-amount-cesta-ticket' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Monto&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][amount_cesta_ticket]" value=<?= number_format($employeesFors->amount_cesta_ticket, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='amount-cesta-ticket' style='display: none;'><input type='hidden' class='ver-amount-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_amount_cesta_ticket]" value='1'></td>
													<td class='datos-amount-cesta-ticket'><input disabled='true' class='input-amount-cesta-ticket' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Monto&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][amount_cesta_ticket]" value=<?= number_format($employeesFors->amount_cesta_ticket, 2, ",", ".") ?>></td>
												<?php endif; ?>
											
												<?php if ($tableConfiguration->loan_cesta_ticket == 0): ?>
													<td class='loan-cesta-ticket'><input type='hidden' class='ver-loan-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_loan_cesta_ticket]" value='0'></td>
													<td class='datos-loan-cesta-ticket' style='display: none;'><input class='input-loan-cesta-ticket alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Préstamo&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][loan_cesta_ticket]" value=<?= number_format($employeesFors->loan_cesta_ticket, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='loan-cesta-ticket' style='display: none;'><input type='hidden' class='ver-loan-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_loan_cesta_ticket]" value='1'></td>
													<td class='datos-loan-cesta-ticket'><input class='input-loan-cesta-ticket alternative-decimal-separator' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Préstamo&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][loan_cesta_ticket]" value=<?= number_format($employeesFors->loan_cesta_ticket, 2, ",", ".") ?>></td>
												<?php endif; ?>
												
												<?php if ($tableConfiguration->total_cesta_ticket == 0): ?>
													<td class='total-cesta-ticket'><input type='hidden' class='ver-total-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_total_cesta_ticket]" value='0'></td>
													<td class='datos-total-cesta-ticket' style='display: none;'><input disabled='true' class='input-total-cesta-ticket' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Total&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_cesta_ticket]" value=<?= number_format($employeesFors->total_cesta_ticket, 2, ",", ".") ?>></td>
												<?php else: ?>
													<td class='total-cesta-ticket' style='display: none;'><input type='hidden' class='ver-total-cesta-ticket' name="employeepayment[<?= $accountArray ?>][view_total_cesta_ticket]" value='1'></td>
													<td class='datos-total-cesta-ticket'><input disabled='true' class='input-total-cesta-ticket' title=<?= $apellidos[0] ?><?= (isset($apellidos[1])) ? '&nbsp;' . $apellidos[1] . '&nbsp;' : '&nbsp;' ; ?><?= $nombres[0] ?><?= (isset($nombres[1])) ? '&nbsp;' . $nombres[1] . ',&nbsp;' : ',&nbsp;' ; ?><?= 'Total&nbsp;cesta&nbsp;ticket' ?> style='text-align: right; width: 100%;' name="employeepayment[<?= $accountArray ?>][total_cesta_ticket]" value=<?= number_format($employeesFors->total_cesta_ticket, 2, ",", ".") ?>></td>
												<?php endif; ?>
											
											<?php endif; ?>
                                        </tr>
                                    <?php 
                                        $accountArray++; 
                                        $accountEmployee++;
                                        endforeach; ?>
                                </tbody>
                            </table>
                            <?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'add', $paysheet->id, $paysheet->weeks_social_security], ['id' => 'agregar-empleado', 'class' => 'glyphicon glyphicon-user btn btn-default', 'title' => 'Agregar empleado', 'style' => 'color: #9494b8; padding: 3px 5px;']) ?>
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
    	$(".alternative-decimal-separator").numeric({ altDecimal: "," });
    	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
        $('#classification').val($('#classificationFor').val());
        $('#fortnight').val($('#fortnightFor').val());
        $('#month').val($('#monthFor').val());
        $('#year').val($('#yearFor').val());
        $('#search-fortnight').click(function(e) 
        {
            e.preventDefault(); 
			
			if ($('#ambiente').val() == "Producción")
			{
				$.redirect('/sistemasangabriel/paysheets/index', {ddFrom : $("select[name='date_from[day]']").val(), mmFrom : $("select[name='date_from[month]']").val(), yyFrom : $("select[name='date_from[year]']").val(), ddUntil : $("select[name='date_until[day]']").val(), mmUntil : $("select[name='date_until[month]']").val(), yyUntil : $("select[name='date_until[year]']").val(), positionCategories : $("#position-categories").val() });
			}
			else
			{
				$.redirect('/desarrollosistemasangabriel/paysheets/index', {dateFrom : $("#date-from").val(), dateUntil : $("#date-until").val(), positionCategories : $("#position-categories").val() });			
			}
			
//            $.redirect('/sistemasangabriel/paysheets/edit', {yearPaysheet : $("#year").val(), monthPaysheet : $("#month").val(), fortnight : $("#fortnight").val(), classification : $("#classification").val() });
        });
		
        $('#borrar').click(function(e) 
        {
            e.preventDefault();
			var r = confirm("Por favor confirme que desea eliminar esta nómina");
            if (r == true)
			{
				$.redirect('/sistemasangabriel/paysheets/delete', {idPaysheet : $("#idPaysheet").val(), controller : "Paysheets", action : "edit" });
			}
			else
            {
                return false;
            } 
        });
	
        $('#cedula').on('click',function()
        {
            $('.cedula').toggle();
            $('.datos-cedula').toggle();
            $('.ver-cedula').val('1');
        });
        $('#datos-cedula').on('click',function()
        {
            $('.datos-cedula').toggle();
            $('.cedula').toggle();
            $('.ver-cedula').val('0');
        });

        $('#cargo').on('click',function()
        {
            $('.cargo').toggle();
            $('.datos-cargo').toggle();
            $('.ver-cargo').val('1');
        });
        $('#datos-cargo').on('click',function()
        {
            $('.datos-cargo').toggle();
            $('.cargo').toggle();
            $('.ver-cargo').val('0');
        });
		
        $('#fecha-ingreso').on('click',function()
        {
            $('.fecha-ingreso').toggle();
            $('.datos-fecha-ingreso').toggle();
            $('.ver-fecha-ingreso').val('1');
        });

        $('#datos-fecha-ingreso').on('click',function()
        {
            $('.datos-fecha-ingreso').toggle();
            $('.fecha-ingreso').toggle();
            $('.ver-fecha-ingreso').val('0');
        });

        $('#sueldo-mensual').on('click',function()
        {
            $('.sueldo-mensual').toggle();
            $('.datos-sueldo-mensual').toggle();
            $('.ver-sueldo-mensual').val('1');
        });

        $('#datos-sueldo-mensual').on('click',function()
        {
            $('.datos-sueldo-mensual').toggle();
            $('.sueldo-mensual').toggle();
            $('.ver-sueldo-mensual').val('0');
        });

        $('#quincena').on('click',function()
        {
            $('.quincena').toggle();
            $('.datos-quincena').toggle();
            $('.ver-quincena').val('1');
        });

        $('#datos-quincena').on('click',function()
        {
            $('.datos-quincena').toggle();
            $('.quincena').toggle();
            $('.ver-quincena').val('0');
        });

        $('#escalafon').on('click',function()
        {
            $('.escalafon').toggle();
            $('.datos-escalafon').toggle();
            $('.ver-escalafon').val('1');
        });
        
        $('#datos-escalafon').on('click',function()
        {
            $('.datos-escalafon').toggle();
            $('.escalafon').toggle();
            $('.ver-escalafon').val('0');
        });

        $('#adelanto-sueldo').on('click',function()
        {
            $('.adelanto-sueldo').toggle();
            $('.datos-adelanto-sueldo').toggle();
            $('.ver-adelanto-sueldo').val('1');
        });
        
        $('#datos-adelanto-sueldo').on('click',function()
        {
            $('.datos-adelanto-sueldo').toggle();
            $('.adelanto-sueldo').toggle();
            $('.ver-adelanto-sueldo').val('0');
        });

        $('#otros-ingresos').on('click',function()
        {
            $('.otros-ingresos').toggle();
            $('.datos-otros-ingresos').toggle();
            $('.ver-otros-ingresos').val('1');
        });

        $('#datos-otros-ingresos').on('click',function()
        {
            $('.datos-otros-ingresos').toggle();
            $('.otros-ingresos').toggle();
            $('.ver-otros-ingresos').val('0');
        });

        $('#faov').on('click',function()
        {
            $('.faov').toggle();
            $('.datos-faov').toggle();
            $('.ver-faov').val('1');
        });

        $('#datos-faov').on('click',function()
        {
            $('.datos-faov').toggle();
            $('.faov').toggle();
            $('.ver-faov').val('0');
        });

        $('#ivss').on('click',function()
        {
            $('.ivss').toggle();
            $('.datos-ivss').toggle();
            $('.ver-ivss').val('1');
        });

        $('#datos-ivss').on('click',function()
        {
            $('.datos-ivss').toggle();
            $('.ivss').toggle();
            $('.ver-ivss').val('0');
        });

        $('#dias-fideicomiso').on('click',function()
        {
            $('.dias-fideicomiso').toggle();
            $('.datos-dias-fideicomiso').toggle();
            $('.ver-dias-fideicomiso').val('1');
        });

        $('#datos-dias-fideicomiso').on('click',function()
        {
            $('.datos-dias-fideicomiso').toggle();
            $('.dias-fideicomiso').toggle();
            $('.ver-dias-fideicomiso').val('0');
        });

        $('#fideicomiso').on('click',function()
        {
            $('.fideicomiso').toggle();
            $('.datos-fideicomiso').toggle();
            $('.ver-fideicomiso').val('1');
        });

        $('#datos-fideicomiso').on('click',function()
        {
            $('.datos-fideicomiso').toggle();
            $('.fideicomiso').toggle();
            $('.ver-fideicomiso').val('0');
        });

        $('#reposo').on('click',function()
        {
            $('.reposo').toggle();
            $('.datos-reposo').toggle();
            $('.ver-reposo').val('1');
        });

        $('#datos-reposo').on('click',function()
        {
            $('.datos-reposo').toggle();
            $('.reposo').toggle();
            $('.ver-reposo').val('0');
        });

        $('#prestamos').on('click',function()
        {
            $('.prestamos').toggle();
            $('.datos-prestamos').toggle();
            $('.ver-prestamos').val('1');
        });

        $('#datos-prestamos').on('click',function()
        {
            $('.datos-prestamos').toggle();
            $('.prestamos').toggle();
            $('.ver-prestamos').val('0');
        });

        $('#porcentaje-impuesto').on('click',function()
        {
            $('.porcentaje-impuesto').toggle();
            $('.datos-porcentaje-impuesto').toggle();
            $('.ver-porcentaje-impuesto').val('1');
        });

        $('#datos-porcentaje-impuesto').on('click',function()
        {
            $('.datos-porcentaje-impuesto').toggle();
            $('.porcentaje-impuesto').toggle();
            $('.ver-porcentaje-impuesto').val('0');
        });

        $('#monto-impuesto').on('click',function()
        {
            $('.monto-impuesto').toggle();
            $('.datos-monto-impuesto').toggle();
            $('.ver-monto-impuesto').val('1');
        });

        $('#datos-monto-impuesto').on('click',function()
        {
            $('.datos-monto-impuesto').toggle();
            $('.monto-impuesto').toggle();
            $('.ver-monto-impuesto').val('0');
        });

        $('#dias-inasistencias').on('click',function()
        {
            $('.dias-inasistencias').toggle();
            $('.datos-dias-inasistencias').toggle();
            $('.ver-dias-inasistencias').val('1');
        });

        $('#datos-dias-inasistencias').on('click',function()
        {
            $('.datos-dias-inasistencias').toggle();
            $('.dias-inasistencias').toggle();
            $('.ver-dias-inasistencias').val('0');
        });

        $('#inasistencias').on('click',function()
        {
            $('.inasistencias').toggle();
            $('.datos-inasistencias').toggle();
            $('.ver-inasistencias').val('1');
        });

        $('#datos-inasistencias').on('click',function()
        {
            $('.datos-inasistencias').toggle();
            $('.inasistencias').toggle();
            $('.ver-inasistencias').val('0');
        });
        
        $('#total-quincena').on('click',function()
        {
            $('.total-quincena').toggle();
            $('.datos-total-quincena').toggle();
            $('.ver-total-quincena').val('1');
        });

        $('#datos-total-quincena').on('click',function()
        {
            $('.datos-total-quincena').toggle();
            $('.total-quincena').toggle();
            $('.ver-total-quincena').val('0');
        });

        $('#days-cesta-ticket').on('click',function()
        {
            $('.days-cesta-ticket').toggle();
            $('.datos-days-cesta-ticket').toggle();
            $('.ver-days-cesta-ticket').val('1');
        });

        $('#datos-days-cesta-ticket').on('click',function()
        {
            $('.datos-days-cesta-ticket').toggle();
            $('.days-cesta-ticket').toggle();
            $('.ver-days-cesta-ticket').val('0');
        });
		
        $('#amount-cesta-ticket').on('click',function()
        {
            $('.amount-cesta-ticket').toggle();
            $('.datos-amount-cesta-ticket').toggle();
            $('.ver-amount-cesta-ticket').val('1');
        });

        $('#datos-amount-cesta-ticket').on('click',function()
        {
            $('.datos-amount-cesta-ticket').toggle();
            $('.amount-cesta-ticket').toggle();
            $('.ver-amount-cesta-ticket').val('0');
        });
				
        $('#loan-cesta-ticket').on('click',function()
        {
            $('.loan-cesta-ticket').toggle();
            $('.datos-loan-cesta-ticket').toggle();
            $('.ver-loan-cesta-ticket').val('1');
        });
		
        $('#datos-loan-cesta-ticket').on('click',function()
        {
            $('.datos-loan-cesta-ticket').toggle();
            $('.loan-cesta-ticket').toggle();
            $('.ver-loan-cesta-ticket').val('0');
        });
				
        $('#total-cesta-ticket').on('click',function()
        {
            $('.total-cesta-ticket').toggle();
            $('.datos-total-cesta-ticket').toggle();
            $('.ver-total-cesta-ticket').val('1');
        });

        $('#datos-total-cesta-ticket').on('click',function()
        {
            $('.datos-total-cesta-ticket').toggle();
            $('.total-cesta-ticket').toggle();
            $('.ver-total-cesta-ticket').val('0');
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