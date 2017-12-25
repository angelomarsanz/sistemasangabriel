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
    
        <?php if ($accountBlock == 2): ?>
        
            <br />
            <br />

            <div class='saltopagina' style='clear:both; width: 100%;'>
                <div style='width: 25%; float:left;'>
					<p><b>U. E. San Gabriel Arcángel, C.A.</b></p>
					<p><b>J-07573084-4</b></p>
					<p><b>Nómina: <?= $classification ?></b></p>
					<p><b><?= $fortnight . ' de ' . $month . ' ' . $year ?></b></p>
				</div>
                <div style='width: 25%; float:left;'>
					<p>.</p>
					<p><b>Desde: </b></p>
					<p><b>Hasta: </b></p>
                    <p><b>Fecha de pago <?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></b></p>
				</div>				
			</div>
			<div style='clear=both; width: 100%; float:left;'>
				<p style='text-align: center;'><b>RECIBO DE PAGO</b></p>
			</div>
			<div style='clear: both; width: 100%; float:left;'>
				<div style='width: 25%; float:left;'>
                    <p>Nombre: <?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></p>
                    <p>C.I. <?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
					<p>F.I.</p>
				</div>
                <div style='width: 25%; float:left;'>
					<p>Sueldo por hora: <?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?></p>
                    <p>Escalafón: <?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></p>
					<p>Total sueldo: <?= number_format(($employeesFors->monthly_salary + ($employeesFors->amount_escalation/2)), 2, ",", ".") ?> </p>
				</div>
			</div>
            <div style='clear: both; width: 100%; float:left;'>
				<div style='width: 25%; float:left;'>
					<p><b>ASIGNACIONES</b></p>
					<hr style='border-color: black;'>
				</div>
				<div style='width: 25%; float:left;'>
					<p><b>DEDUCCIONES</b></p>
					<hr style='border-color: black;'>
				</div>										
			</div>
            <div style='clear: both; width: 100%; float:left;'>
				<?php $totAsignaciones = $employeesFors->fortnight + ($employeesFors->amount_escalation/2) + $employeesFors->other_income; ?>
				<?php $totDeducciones = $employeesFors->faov + $employeesFors->ivss + $employeesFors->amount_imposed + $employeesFors->discount_loan + $employeesFors->discount_absences; ?>
				<div style='width: 25%; float:left;'>
					<p>Quincena: <?= number_format($employeesFors->fortnight, 2, ",", ".") ?></p>
					<p>Escalafon: <?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></p> 
					<p>Otros ingresos: <?= number_format($employeesFors->other_income, 2, ",", ".") ?></p>
					<p>.</p>
					<hr style='border-color: black;'>
				</div>
                <div style='width: 25%; float:left;'>
					<p>Faov: <?= number_format($employeesFors->faov, 2, ",", ".") ?></p>
					<p>S.S.O. <?= number_format($employeesFors->ivss, 2, ",", ".") ?></p> 
					<p>Préstamos: <?= number_format($employeesFors->discount_loan, 2, ",", ".") ?></p>		
					<p>Descuentos <?= number_format($employeesFors->discount_absences, 2, ",", ".") ?></p>					
					<hr style='border-color: black;'>
				</div>
			</div>	
            <div style='clear: both; width: 100%; float:left;'>
				<div style='width: 25%; float:left;'>
                    <p>Total asig: <td style='text-align: right;'><b><?= number_format(($totAsignaciones), 2, ",", ".") ?></p>
					<p>Recibí conforme</p>
					<p>Firma</p>
					<hr style='border-width: 5px; border-color: black;'>
				</div>
				<div style='width: 25%; float:left;'>
                    <p><td style='text-align: right;'><b><?= number_format(($totDeducciones), 2, ",", ".") ?></p>
					<p><b>Neto a recibir: <?= number_format(($totAsignaciones - $totDeducciones), 2, ",", ".") ?></b></p>
					<p>.</p>
					<hr style='border-width: 5px; border-color: black;'>
				</div>				
			</div>				
						
            <?php $accountBlock = 1; ?>

        <?php else: ?>
        

        
            <?php $accountBlock++; ?>

        <?php endif; ?>
    
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