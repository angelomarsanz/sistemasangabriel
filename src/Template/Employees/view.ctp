<?php
    use Cake\I18n\Time;
    use Cake\Routing\Router; 
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
    .botonMenu
    {
        margin-bottom: 5 px;
    }
    .ui-autocomplete 
    {
        z-index: 2000;
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
<div class="container">
    <div class="page-header">    
        <?php if (isset($controller)): ?>
			<?php if ($controller == 'Paysheets' && $action == 'edit'): ?>   
				<p><?= $this->Html->link(__(''), ['controller' => $controller, 'action' => $action, $idPaysheet, $classification], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default nover', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>
            <?php endif; ?>
		<?php else: ?>
			<p><?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'index'], ['class' => 'glyphicon glyphicon-chevron-left btn btn-sm btn-default nover', 'title' => 'Volver', 'style' => 'color: #9494b8']) ?></p>
        <?php endif; ?>
		<div style="float: left; width:10%;">
			<br />
			<p><?= $this->Html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
		</div>
		<div style="float: left; width: 70%;">
			<br />
			<h5><b>&nbsp;<?= $school->name ?></b></h5>
			<p>&nbsp;RIF: <?= $school->rif ?></p>
			<h3 style='text-align: center;'>Empleado:&nbsp;<?= h($employee->full_name) ?></h3>
		</div>
		<div  style="width: 20%; float: left;">
			<br />
			<?php if (!(is_null($employee->profile_photo))): ?>
				<?= $this->Html->image('../files/employees/profile_photo/' . $employee->get('profile_photo_dir') . '/'. $employee->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?>
			<?php else: ?>
				<div style="text-align: center; width: 200px; height: 200px; border: 3px solid #555;">
					<p>Foto</p>
				</div>
			<?php endif; ?>
		</div>		
    </div>
	<h4>Datos personales</h4>
    <div class="row panel panel-default" style="padding: 0% 3% 0% 3%;">
        <div class="col col-xs-6">    
            <br />
                <b>Sexo:&nbsp;</b><?= h($employee->sex) ?>
            <br />
            <br />
                <b>Nacionalidad:&nbsp;</b><?= h($employee->nationality) ?>
            <br />
            <br />
                <b>Rif:&nbsp;</b><?= h($employee->type_of_identification . '-' . $employee->rif) ?>
            <br />
            <br />
                <b>Número de teléfono fijo:&nbsp;</b><?= h($employee->landline) ?>
            <br />
            <br />
                <b>Dirección de habitación:&nbsp;</b><?= h($employee->address) ?>
            <br />
            <br />
		</div>
        <div class="col col-xs-5">    
            <br />
                <b>Fecha de nacimiento:&nbsp;</b><?= h($employee->birthdate->format('d-m-Y') ) ?>
            <br />
            <br />
                <b>Documento de identidad:&nbsp;</b><?= h($employee->type_of_identification . '-' . $employee->identity_card) ?>
            <br />
            <br />
                <b>Número de celular:&nbsp;</b><?= h($employee->cell_phone) ?>
            <br />
            <br />
                <b>Correo electrónico:&nbsp;</b><?= h($employee->email) ?>
            <br />
            <br />
                <b>Grado de instrucción:&nbsp;</b><?= h($employee->degree_instruction) ?>
            <br />
            <br />
		</div>
	</div>
	<div class="row panel panel-default" style="padding: 0% 3% 0% 3%;">
		
		<div class="col col-xs-6">
            <br />
				<b>Cargo que ocupa:&nbsp;</b><?= $employee->position->position ?>
            <br />
            <br />
                <b>Fecha de ingreso:&nbsp;</b><?= h($employee->date_of_admission->format('d-m-Y')) ?>
            <br />
            <br />
                <b>Horas semanales de trabajo:&nbsp;</b><?= $this->Number->format($employee->weekly_hours) ?>
            <br />
            <br />
                <b>Porcentaje de ISLR a aplicar:&nbsp;</b><?= $this->Number->format($employee->percentage_imposed) ?>
            <br />
            <br />
        </div>
		<div class="col col-xs-5">
            <br />
                <b>Tipo de empleado:&nbsp;</b><?= h($employee->working_agreement) ?>
            <br />
            <br />
                <b>Horas diarias de trabajo:&nbsp;</b><?= $this->Number->format($employee->daily_hours) ?>
            <br />
            <br />
                <b>Horas mensuales de trabajo:&nbsp;</b><?= $this->Number->format($employee->hours_month) ?>
            <br />
            <br />
        </div>
    </div>
	<?php if (!empty($employee->teachingareas)): ?>
		<div class="row panel panel-default" style="padding: 0% 3% 0% 3%;">
			<h4>Materias que dicta</h4>
			<div class="col col-xs-4">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th scope="col">Materia</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($employee->teachingareas as $teachingareas): ?>
							<tr>
								<td><?= h($teachingareas->description_teaching_area) ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
<div id="menu-menos-employee" class="menumenos">
	<p>
	<a href="#" id="menu-mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger nover'></a>
	</p>
</div>
<div id="menu-mas-employee" style="display:none;" class="menumas">
	<p>
	<?= $this->Html->link(__(''), ['controller' => 'Employees', 'action' => 'edit', $employee->id, 'Employees', 'view', $idPaysheet, $weeksSocialSecurity, $classification, $idEmployeepayments], ['class' => 'glyphicon glyphicon-edit btn btn-danger nover', 'title' => 'Modificar empleado']) ?>
    <a href='#' onclick='myFunction()' id="imprimir" title="Imprimir" class='glyphicon glyphicon-print btn btn-danger nover'></a>
	<a href="#" id="menu-menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger nover'></a>
	</p>
</div>
<script>
function myFunction() 
{
    window.print();
}
$(document).ready(function(){ 
    $('#menu-mas').on('click',function()
    {
        $('#menu-menos-employee').hide();
        $('#menu-mas-employee').show();
    });
    $('#menu-menos').on('click',function()
    {
        $('#menu-mas-employee').hide();
        $('#menu-menos-employee').show();
    });
});
</script>