<style type="text/css" media="print">
    .nover {display:none}
</style>
<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
	        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Paysheets', 'action' => 'viewFortnight'], ['class' => 'btn btn-sm btn-default nover']) ?></p>
    		<h3>Nómina de: <?= $classification. ', ' . $fortnight . ' de ' . $month . ' ' . $year ?> </h3>
        </div>
    	<div class="table-responsive">
        	<div class="table-responsive">
        		<table class="table table-striped table-hover">
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
                        <?php 
                            $accountEmployee = 1;
                            foreach ($employeesFor as $employeesFors): 
                        ?>
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
                        <?php 
                            $accountEmployee++;
                            endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Anterior') ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next('Siguiente >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>