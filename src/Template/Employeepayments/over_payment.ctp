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
<div>
	<?php $accountBlock = 0; ?>

    <?php foreach ($employeesFor as $employeesFors): ?>
        <br />
        <br />

		<?php if ($accountBlock == 3): ?>
			<div class='saltopagina' style='clear:both; width: 100%;'>
			<?php $accountBlock = 0; ?>
		<?php else: ?>
			<div style='clear:both; width: 100%;'>
		<?php endif; ?>
			<div style='width: 50%; float:left;'>
				<p><b>U. E. San Gabriel Arcángel, C.A.</b></p>
				<p><b>J-07573084-4</b></p>
				<p><b>Nómina: <?= $classification ?></b></p>
				<p><b><?= $fortnight . ' de ' . $month . ' ' . $year ?></b></p>
			</div>
			<div style='width: 25%; float:left; text-align: right;'>
				<p>&nbsp;</p>
				<p><b>Desde: </b></p>
				<p><b>Hasta: </b></p>
				<p><b>Fecha de pago: </b></p>
			</div>
			<div style='width: 25%; float:left; text-align: right;'>
				<p>&nbsp;</p>
				<p><b><?= $paysheet->date_from->format('d-m-Y') ?></b></p>
				<p><b><?= $paysheet->date_until->format('d-m-Y') ?></b></p>
				<p><b><?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></b></p>
			</div>				
		</div>
		<div style='clear=both; width: 100%; float:left;'>
			<p style='text-align: center;'><b>RECIBO DE PAGO</b></p>
		</div>
		<div style='clear: both; width: 100%; float:left;'>
			<div style='width: 25%; float:left;'>
				<p>Nombre:</p>
				<p>C.I.</p>
				<p>F.I.</p>
			</div>
			<div style='width: 25%; float:left;'>
				<p><?= $employeesFors->employee->first_name . ' ' . $employeesFors->employee->surname ?></p>
				<p><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
				<p>&nbsp;</p>
			</div>					
			<div style='width: 25%; float:left; text-align: right;'>
				<p>Sueldo por hora:</p>
				<p>Escalafón:</p>
				<p>Total sueldo:</p>
			</div>
			<div style='width: 25%; float:left; text-align: right;'>
				<p><?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?></p>
				<p><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></p>
				<p><?= number_format(($employeesFors->monthly_salary + ($employeesFors->amount_escalation/2)), 2, ",", ".") ?> </p>
			</div>
		</div>
		<div style='clear: both; width: 100%; float:left;'>
			<div style='width: 45%; float:left;'>
				<p><b>ASIGNACIONES</b></p>
				<hr style='border-color: black;'>
			</div>
			<div style='width: 10%; float:left;'>
				<p>&nbsp;</p>
			</div>
			<div style='width: 45%; float:left;'>
				<p><b>DEDUCCIONES</b></p>
				<hr style='border-color: black;'>
			</div>										
		</div>
		<div style='clear: both; width: 100%; float:left;'>
			<div style='width: 25%; float:left;'>
				<p>Quincena:</p>
				<p>Escalafon:</p> 
				<p>Otros ingresos:</p>
				<p>&nbsp;</p>
				<hr style='border-color: black;'>
			</div>
			<div style='width: 20%; float:left; text-align: right;'>
				<p><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></p>
				<p><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></p> 
				<p><?= number_format($employeesFors->other_income, 2, ",", ".") ?></p>
				<p>&nbsp;</p>
				<hr style='border-color: black;'>
			</div>	
			<div style='width: 10%; float:left;'>
				<p>&nbsp;</p>
			</div>				
			<div style='width: 25%; float:left;'>
				<p>Faov:</p>
				<p>S.S.O.</p> 
				<p>Préstamos:</p>		
				<p>Desc. Inas.:</p>					
				<hr style='border-color: black;'>
			</div>
			<div style='width: 20%; float:left; text-align: right;'>
				<p><?= number_format($employeesFors->faov, 2, ",", ".") ?></p>
				<p><?= number_format($employeesFors->ivss, 2, ",", ".") ?></p> 
				<p><?= number_format($employeesFors->discount_loan, 2, ",", ".") ?></p>		
				<p><?= number_format($employeesFors->discount_absences, 2, ",", ".") ?></p>					
				<hr style='border-color: black;'>
			</div>
		</div>	
		<?php $totAsignaciones = $employeesFors->fortnight + ($employeesFors->amount_escalation/2) + $employeesFors->other_income; ?>
		<?php $totDeducciones = $employeesFors->faov + $employeesFors->ivss + $employeesFors->amount_imposed + $employeesFors->discount_loan + $employeesFors->discount_absences; ?>
		<div style='clear: both; width: 100%; float:left;'>
			<div style='width: 25%; float:left;'>
				<p>Total asig:</p>
				<p>Recibí conforme:</p>
				<p>Firma:</p>
				<hr style='border-width: 5px; border-color: black;'>
			</div>
			<div style='width: 20%; float:left; text-align: right;'>
				<p><?= number_format(($totAsignaciones), 2, ",", ".") ?></p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<hr style='border-width: 5px; border-color: black;'>
			</div>
			<div style='width: 10%; float:left;'>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<hr style='border-width: 5px; border-color: black;'>
			</div>
			<div style='width: 25%; float:left;'>
				<p>Total deducciones:</p>
				<p><b>Neto a recibir:</b></p>
				<p>&nbsp;</p>
				<hr style='border-width: 5px; border-color: black;'>
			</div>
			<div style='width: 20%; float:left; text-align: right;'>
				<p><?= number_format(($totDeducciones), 2, ",", ".") ?></p>
				<p><b><?= number_format(($totAsignaciones - $totDeducciones), 2, ",", ".") ?></b></p>
				<p>&nbsp;</p>
				<hr style='border-width: 5px; border-color: black;'>
			</div>				
		</div>				
					
		<?php $accountBlock++ ?>
    
    <?php endforeach; ?>
            
</div>
<div class="menumenos nover menu-menos">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
    <p>
        <?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
        <?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
        <a href='#' onclick='myFunction()' id="imprimir" title="Imprimir" class='glyphicon glyphicon-print btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
    function myFunction() 
    {
        window.print();
    }
    
    $(document).ready(function()
    {
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