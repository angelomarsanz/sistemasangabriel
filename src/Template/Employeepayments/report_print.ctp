<style>
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
    <p></p><button onclick="myFunction()" class="nover btn btn-sm btn-primary">Imprimir</button></p>
    <?php $accountEmployee = 1; ?>
    <?php $accountLine = 1; ?>
    <?php $accountPage = 1; ?>

    <?php foreach ($employeesFor as $employeesFors): ?> 
        <?php if ($accountEmployee == 1): ?>
            <p style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
            <?php $accountPage++; ?>
            <h3>UNIDAD EDUCATIVA COLEGIO SAN GABRIEL ARCANGEL C.A.</h2>
            <h4>Rif: J-07573084-4</h4>
            <p>Nómina de: <?= $classification. ', ' . $fortnight . ' de ' . $month . ' ' . $year ?> </p>
        	<table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col" style="text-align: right;">Sueldo</th>
                        <th scope="col" style="text-align: right;">Quincena</th>
                        <th scope="col" style="text-align: right;">Otros ingresos</th>
                        <th scope="col" style="text-align: right;">Escala</th>
                        <th scope="col" style="text-align: right;">Escalafón</th>
                        <th scope="col" style="text-align: right;">% Imp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $accountEmployee ?></td>
                        <td><?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></td>
                        <td><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>
                        <td><?= $employeesFors->current_position ?></td>
                        <td><?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?></td>
                        <td style="text-align: right;"><?= ($employeesFors->employee->position->type_of_salary == "Por horas") ? number_format($employeesFors->current_basic_salary * $employeesFors->current_monthly_hours, 2, ",", ".") : number_format($employeesFors->current_basic_salary, 2, ",", ".") ?></td>
                        <td style="text-align: right;"><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></td>
                        <td style="text-align: right;"><?= $employeesFors->other_income ?></td>
                        <td style="text-align: right;"><?= $employeesFors->scale * 100 . '%' ?></td>
                        <td style="text-align: right;"><?= number_format($employeesFors->scale * $employeesFors->fortnight, 2, ",", ".") ?></td>
                        <td style="text-align: right;"><?= $employeesFors->percentage_imposed ?></td>
                    </tr>
        <?php else: ?> 
            <?php if ($accountLine > 10): ?>
                </tbody>
            </table>
                <p class="saltopagina" style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
                <?php $accountPage++; ?>
                <h3>UNIDAD EDUCATIVA COLEGIO SAN GABRIEL ARCANGEL C.A.</h2>
                <h4>Rif: J-07573084-4</h4>
                <p>Nómina de: <?= $classification. ', ' . $fortnight . ' de ' . $month . ' ' . $year ?> </p>
            	<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cédula</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Fecha de ingreso</th>
                            <th scope="col" style="text-align: right;">Sueldo</th>
                            <th scope="col" style="text-align: right;">Quincena</th>
                            <th scope="col" style="text-align: right;">Otros ingresos</th>
                            <th scope="col" style="text-align: right;">Escala</th>
                            <th scope="col" style="text-align: right;">Escalafón</th>
                            <th scope="col" style="text-align: right;">% Imp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $accountEmployee ?></td>
                            <td><?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></td>
                            <td><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>
                            <td><?= $employeesFors->current_position ?></td>
                            <td><?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?></td>
                            <td style="text-align: right;"><?= ($employeesFors->employee->position->type_of_salary == "Por horas") ? number_format($employeesFors->current_basic_salary * $employeesFors->current_monthly_hours, 2, ",", ".") : number_format($employeesFors->current_basic_salary, 2, ",", ".") ?></td>
                            <td style="text-align: right;"><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></td>
                            <td style="text-align: right;"><?= $employeesFors->other_income ?></td>
                            <td style="text-align: right;"><?= $employeesFors->scale * 100 . '%' ?></td>
                            <td style="text-align: right;"><?= number_format($employeesFors->scale * $employeesFors->fortnight, 2, ",", ".") ?></td>
                            <td style="text-align: right;"><?= $employeesFors->percentage_imposed ?></td>
                        </tr>
                <?php $accountLine = 1; ?>
            <?php else: ?>
                <tr>
                    <td><?= $accountEmployee ?></td>
                    <td><?= $employeesFors->employee->surname . ' ' . $employeesFors->employee->first_name ?></td>
                    <td><?= $employeesFors->employee->type_of_identification . '-' . $employeesFors->employee->identity_card ?></td>
                    <td><?= $employeesFors->current_position ?></td>
                    <td><?= $employeesFors->employee->date_of_admission->format('d-m-Y') ?></td>
                    <td style="text-align: right;"><?= ($employeesFors->employee->position->type_of_salary == "Por horas") ? number_format($employeesFors->current_basic_salary * $employeesFors->current_monthly_hours, 2, ",", ".") : number_format($employeesFors->current_basic_salary, 2, ",", ".") ?></td>
                    <td style="text-align: right;"><?= number_format($employeesFors->fortnight, 2, ",", ".") ?></td>
                    <td style="text-align: right;"><?= $employeesFors->other_income ?></td>
                    <td style="text-align: right;"><?= $employeesFors->scale * 100 . '%' ?></td>
                    <td style="text-align: right;"><?= number_format($employeesFors->scale * $employeesFors->fortnight, 2, ",", ".") ?></td>
                    <td style="text-align: right;"><?= $employeesFors->percentage_imposed ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
        <?php $accountEmployee++; ?>
        <?php $accountLine++; ?>
    <?php endforeach; ?>
                </tbody>
            </table>
    <p></p><button onclick="myFunction()" class="nover 'btn btn-sm btn-primary">Imprimir</button></p>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>