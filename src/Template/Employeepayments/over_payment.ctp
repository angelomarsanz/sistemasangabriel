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

            <div class='saltopagina' style='clear:both; width: 90%;'>

                <div style='width: 45%; float:left; border-style: solid; margin: 5px;'>
                    <div style='padding: 5px; margin: 5px;'>
                        <p>Unidad Educativa San Gabriel Arcángel</p>
                        <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>
                        <p>Nombre: <?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></p>
                        <p>C.I. <?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
                        <p>Sueldo hora: <?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?></p>
                        <p>Fecha de pago <?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></p>
                		<table>
                            <thead>
                                <tr>
                                    <th scope="col">Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asignaciones</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deducciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Quincena</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Escalafón</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Otros ingresos</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->other_income, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Fideicomiso</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->trust_days * $employeesFors->integral_salary), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Faov</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->faov, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>SSO</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->ivss, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>ISLR <?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?> %</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>Préstamos</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->discount_loan, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>Descuento inasistencia</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->discount_absences, 2, ",", ".") ?></td>
                                </tr>
                                <?php $totAsignaciones = $employeesFors->fortnight + ($employeesFors->amount_escalation/2) + $employeesFors->other_income; ?>
                                <?php $totDeducciones = $employeesFors->faov + $employeesFors->ivss + $employeesFors->amount_imposed + $employeesFors->discount_loan + $employeesFors->discount_absences; ?>
                                <tr>
                                    <td><b>Sub-total</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones), 2, ",", ".") ?></b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totDeducciones), 2, ",", ".") ?></b></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style='text-align: right;'><b>Total a pagar Bs.</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones - $totDeducciones), 2, ",", ".") ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style='width: 45%; float:left; border-style: solid; margin: 5px;'>
                    <div style='padding: 5px; margin: 5px;'>
                        <p>Unidad Educativa San Gabriel Árcangel</p>
                        <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>
                        <p>Nombre: <?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></p>
                        <p>C.I. <?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
                        <p>Fecha de pago <?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></p>
                        <p>&nbsp;</p>
                		<table>
                            <thead>
                                <tr>
                                    <th scope="col">Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monto</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retención</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sueldo hora</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->monthly_salary, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Escalafón</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                
                                <?php $totAsignaciones = $employeesFors->monthly_salary + ($employeesFors->amount_escalation/2); ?>

                                <tr>
                                    <td><b>Total sueldo</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones), 2, ",", ".") ?></b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>ISLR</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?> %</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style='text-align: right;'><b>Total a pagar Bs.</b></td>
                                    <td style='text-align: right;'><b><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>  
            <?php $accountBlock = 1; ?>

        <?php else: ?>
        
            <br />
            <br />

            <div style='clear:both; width: 90%;'>
                <div style='width: 45%; float:left; border-style: solid; margin: 5px;'>
                    <div style='padding: 5px;'>
                        <p>Unidad Educativa San Gabriel Arcangel</p>
                        <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>
                        <p>Nombre: <?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></p>
                        <p>C.I. <?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
                        <p>Sueldo hora: <?= number_format(($employeesFors->monthly_salary), 2, ",", ".") ?></p>
                        <p>Fecha de pago <?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></p>
                		<table>
                            <thead>
                                <tr>
                                    <th scope="col">Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asignaciones</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deducciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Quincena</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Escalafón</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Otros ingresos</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->other_income, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Fideicomiso</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->trust_days * $employeesFors->integral_salary), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Faov</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->faov, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>SSO</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->ivss, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>ISLR <?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?> %</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>Préstamos</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->discount_loan, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>Descuento inasistencia</td>
                                    <td></td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->discount_absences, 2, ",", ".") ?></td>
                                </tr>
                                <?php $totAsignaciones = $employeesFors->fortnight + ($employeesFors->amount_escalation/2) + $employeesFors->other_income; ?>
                                <?php $totDeducciones = $employeesFors->faov + $employeesFors->ivss + $employeesFors->amount_imposed + $employeesFors->discount_loan + $employeesFors->discount_absences; ?>
                                <tr>
                                    <td><b>Sub-total</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones), 2, ",", ".") ?></b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totDeducciones), 2, ",", ".") ?></b></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style='text-align: right;'><b>Total a pagar Bs.</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones - $totDeducciones), 2, ",", ".") ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style='width: 45%; float:left; border-style: solid; margin: 5px;'>
                    <div style='padding: 5px;'>
                        <p>Unidad Educativa San Gabriel Arcangel</p>
                        <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>
                        <p>Nombre: <?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></p>
                        <p>C.I. <?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></p>
                        <p>Fecha de pago <?= ($fortnightNumber == 1) ? '10-' . $monthNumber . '-' . $year : '25-' . $monthNumber . '-' . $year ; ?></p>
                        <p>&nbsp;</p>
                		<table>
                            <thead>
                                <tr>
                                    <th scope="col">Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monto</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Retención</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sueldo hora</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->monthly_salary, 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Escalafón</td>
                                    <td style='text-align: right;'><?= number_format(($employeesFors->amount_escalation/2), 2, ",", ".") ?></td>
                                    <td></td>
                                </tr>
                                
                                <?php $totAsignaciones = $employeesFors->monthly_salary + ($employeesFors->amount_escalation/2); ?>

                                <tr>
                                    <td><b>Total sueldo</b></td>
                                    <td style='text-align: right;'><b><?= number_format(($totAsignaciones), 2, ",", ".") ?></b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>ISLR</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->percentage_imposed, 2, ",", ".") ?> %</td>
                                    <td style='text-align: right;'><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style='text-align: right;'><b>Total a pagar Bs.</b></td>
                                    <td style='text-align: right;'><b><?= number_format($employeesFors->amount_imposed, 2, ",", ".") ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        
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