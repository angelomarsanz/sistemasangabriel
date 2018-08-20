<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
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
<?php if ($swImpresion == 0): ?>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h2>Familias - Alumnos regulares</h2>
				<h3>Selección de columnas a imprimir</h3>
			</div>
			<?= $this->Form->create() ?>
				<fieldset>	
					<div id="columns-report" class="row">
						<div class="col-md-6">
							<h4>Datos de la familia</h4>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-11">
									<h5>Datos del representante:</h5>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.full_name]" id="nombre"> Nombre</p>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.sex]"> Sexo</p>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.identidy_card]"> Cédula o pasaporte</p>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.work_phone]"> Teléfono trabajo</p>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.cell_phone]"> Celular</p>
										<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.email]"> Email</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<h4>Datos del estudiante</h4>
							<p><input class="column-mark" type="checkbox" name="columnsReport[Students.sex]"> Sexo</p>
							<p><input class="column-mark" type="checkbox" name="columnsReport[Students.nationality]"> Nacionalidad</p>
							<p><input class="column-mark" type="checkbox" name="columnsReport[Students.identity_card]"> Cédula o pasaporte</p>
							<p><input class="column-mark" type="checkbox" name="columnsReport[Students.balance]"> Año escolar</p>
							<p><input class="column-mark" type="checkbox" name="columnsReport[Students.section_id]"> Grado y sección</p>
						</div>
					</div>
					<div id="filter" class="row">
						<div class="col-md-3">
							<?php
								echo $this->Form->input('filters_report', ['label' => 'Filtro: *', 'required' => true, 'options' => 
								[null => " ",
								 'Regular' => 'Alumnos nuevos',
								 'Nuevo' => 'Alumnos regulares',
								 '*' => 'Todos'],
								 ]);
							?>
						</div>
						<div class="col-md-9">
						</div>
					</div>
				</fieldset>
				<br /> 					
				<div id="menu-menos" class="menumenos nover">
					<p>
					<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
					</p>
				</div>
				<div id="menu-mas" style="display:none;" class="menumas nover">
					<p>
						<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
						<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
						
						<button id="marcar-todos" class="glyphicon icon-checkbox-checked btn btn-danger" title="Marcar todos" style="padding: 8px 12px 10px 12px;"></button>

						<button id="desmarcar-todos" class="glyphicon icon-checkbox-unchecked btn btn-danger" title="Desmarcar todos" style="padding: 8px 12px 10px 12px;"></button>

						<?= $this->Form->button(__(''), ['id' => 'generar-reporte', 'title' => 'Generar reporte', 'class' => 'glyphicon glyphicon-th-list btn btn-danger']) ?>					
						
						<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
					</p>
				</div>
						
			<?= $this->Form->end() ?>
		</div>
	</div>
<?php else: ?>
	<br />
	<br />
	<div>
		<?php $accountRecords = 0; ?>
		<?php foreach ($familyStudents as $familyStudent): ?>
			<?php 
				$lastYearRegistration = $familyStudent->balance;		
				if ($familyStudent->student_condition == "Regular"):
					if ($familyStudent->new_student == 0):
						$studentCondition = $familyStudent->student_condition;
					else:
						$studentCondition = "Nuevo";
					endif;
					if ($familyStudent->balance == $currentYearRegistration && isset($arraySignedUp[$familyStudent->id])):
						$lastYearRegistration .= '-' . $arraySignedUp[$familyStudent->id];
					endif;
				else:
					$studentCondition = $familyStudent->student_condition;
				endif;
			?>
			<?php if ($accountRecords == 0): ?>
				<?php $accountRecords++; ?>
				<table id="family-students" name="family_students" class="table noverScreen">
					<thead>
						<tr>
							<th></th>
							<th><?= 'Fecha: ' . $currentDate->format('d-m-Y') ?></th>
						</tr>
						<tr>
							<th></th>
							<th><b>Colegio San Gabriel Arcángel</b></th>
						</tr>
						<tr>
							<th></th>
							<th><b>Resumen de familias - estudiantes</b></th>
						</tr>			
						<tr>
							<th></th>
							<th></th>
						</tr>						
						<tr>
							<th></th>
							<th><?= 'Alumnos regulares: ' . $accountStudents['Regular'] ?></th>
						</tr>
						<tr>
							<th></th>
							<th><?= 'Alumnos nuevos: ' . $accountStudents['New'] ?></th>
						</tr>
						<tr>
							<th></th>
							<th><?= 'Alumnos egresados: ' . $accountStudents['Graduated'] ?></th>
						</tr>
						<tr>
							<th></th>
							<th><?= 'Alumnos retirados: ' . $accountStudents['Retired'] ?></th>
						</tr>
						<tr>
							<th></th>
							<th><?= 'Alumnos expulsados: ' . $accountStudents['Expelled'] ?></th>
						</tr>
						<tr>
							<th></th>
							<th><?= 'Alumnos suspendidos: ' . $accountStudents['Discontinued'] ?></th>
						</tr>						
						<tr>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th></th>
							<th><b>Detalle de familias - estudiantes</b></th>
						</tr>			
						<tr>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th scope="col"><b>Nro.</b></th>
							<th scope="col"><b>Familia</b></th>
							<th scope="col"><b>Estatus</b></th>
							<th scope="col"><b>Alumno</b></th>
							<th scope="col" class=<?= $arrayMark['Students.sex'] ?>><b>Sexo</b></th>
							<th scope="col" class=<?= $arrayMark['Students.nationality'] ?>><b>Nacionalidad alumno</b></th>
							<th scope="col" class=<?= $arrayMark['Students.identity_card'] ?>><b>Cédula o pasaporte alumno</b></th>	
							<th scope="col"><b>Año Inscripción</b></th>							
							<th scope="col" class=<?= $arrayMark['Students.section_id'] ?>><b>Grado y sección</b></th>	
							
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.full_name'] ?>><b>Nombre Representante</b></th>
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.sex'] ?>><b>Sexo</b></th>
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.identidy_card'] ?>><b>Cédula o pasaporte representante</b></th>
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.work_phone'] ?>><b>Teléfono trabajo representante</b></th>
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.cell_phone'] ?>><b>Celular representante</b></th>
							<th scope="col" class=<?= $arrayMark['Parentsandguardians.email'] ?>><b>Email representante</b></th>
							
							<th scope="col"><b>Nombre del padre</b></th>
							<th scope="col"><b>Cédula o pasaporte del padre</b></th>
							<th scope="col"><b>Teléfono trabajo del padre</b></th>
							<th scope="col"><b>Celular del padre</b></th>
							<th scope="col"><b>Email del padre</b></th>
							
							<th scope="col"><b>Nombre de la madre</b></th>
							<th scope="col"><b>Cédula o pasaporte de la madre</b></th>
							<th scope="col"><b>Teléfono trabajo de la madre</b></th>
							<th scope="col"><b>Celular de la madre</b></th>
							<th scope="col"><b>Email de la madre</b></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $accountRecords ?></td>
							<td><?= $familyStudent->parentsandguardian->family ?></td>                        
							<td><?= $studentCondition ?></td>
							<td><?= $familyStudent->full_name ?></td>
							<td class=<?= $arrayMark['Students.sex'] ?>><?= $familyStudent->sex ?></td>
							<td class=<?= $arrayMark['Students.nationality'] ?>><?= $familyStudent->nationality ?></td>
							<td class=<?= $arrayMark['Students.identity_card'] ?>><?= $familyStudent->type_of_identification . '-' . $familyStudent->identity_card ?></td>
							<td><?= $lastYearRegistration ?></td>
							<td class=<?= $arrayMark['Students.section_id'] ?>><?= $familyStudent->section->level .', ' . $familyStudent->section->sublevel . ', ' . $familyStudent->section->section ?></td>

							<td class=<?= $arrayMark['Parentsandguardians.full_name'] ?>><?= $familyStudent->parentsandguardian->full_name ?></td>							
							<td class=<?= $arrayMark['Parentsandguardians.sex'] ?>><?= $familyStudent->parentsandguardian->sex ?></td>
							<td class=<?= $arrayMark['Parentsandguardians.identidy_card'] ?>><?= $familyStudent->parentsandguardian->type_of_identification . '-' . $familyStudent->parentsandguardian->identidy_card ?></td>
							<td class=<?= $arrayMark['Parentsandguardians.work_phone'] ?>><?= $familyStudent->parentsandguardian->work_phone ?></td>
							<td class=<?= $arrayMark['Parentsandguardians.cell_phone'] ?>><?= $familyStudent->parentsandguardian->cell_phone ?></td>
							<td class=<?= $arrayMark['Parentsandguardians.email'] ?>><?= $familyStudent->parentsandguardian->email ?></td>
						
							<td><?= $familyStudent->parentsandguardian->second_surname_father . ' ' . $familyStudent->parentsandguardian->surname_father . ' ' . $familyStudent->parentsandguardian->first_name_father . ' ' . $familyStudent->parentsandguardian->second_name_father ?></td>							
							<td><?= $familyStudent->parentsandguardian->type_of_identification_father . '-' . $familyStudent->parentsandguardian->identidy_card_father ?></td>
							<td><?= $familyStudent->parentsandguardian->work_phone_father ?></td>
							<td><?= $familyStudent->parentsandguardian->cell_phone_father ?></td>
							<td><?= $familyStudent->parentsandguardian->email_father ?></td>
							
							<td><?= $familyStudent->parentsandguardian->second_surname_mother . ' ' . $familyStudent->parentsandguardian->surname_mother . ' ' . $familyStudent->parentsandguardian->first_name_mother . ' ' . $familyStudent->parentsandguardian->second_name_mother ?></td>							
							<td><?= $familyStudent->parentsandguardian->type_of_identification_mother . '-' . $familyStudent->parentsandguardian->identidy_card_mother ?></td>
							<td><?= $familyStudent->parentsandguardian->work_phone_mother ?></td>
							<td><?= $familyStudent->parentsandguardian->cell_phone_mother ?></td>
							<td><?= $familyStudent->parentsandguardian->email_mother ?></td>
						</tr>
			<?php else: ?>
				<?php $accountRecords++; ?>
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $familyStudent->parentsandguardian->family ?></td>
					<td><?= $studentCondition ?></td>
					<td><?= $familyStudent->full_name ?></td>
					<td class=<?= $arrayMark['Students.sex'] ?>><?= $familyStudent->sex ?></td>
					<td class=<?= $arrayMark['Students.nationality'] ?>><?= $familyStudent->nationality ?></td>
					<td class=<?= $arrayMark['Students.identity_card'] ?>><?= $familyStudent->type_of_identification . '-' . $familyStudent->identity_card ?></td>
					<td><?= $lastYearRegistration ?></td>
					<td class=<?= $arrayMark['Students.section_id'] ?>><?= $familyStudent->section->level .', ' . $familyStudent->section->sublevel . ', ' . $familyStudent->section->section ?></td>

					<td class=<?= $arrayMark['Parentsandguardians.full_name'] ?>><?= $familyStudent->parentsandguardian->full_name ?></td>
					<td class=<?= $arrayMark['Parentsandguardians.sex'] ?>><?= $familyStudent->parentsandguardian->sex ?></td>
					<td class=<?= $arrayMark['Parentsandguardians.identidy_card'] ?>><?= $familyStudent->parentsandguardian->type_of_identification . '-' . $familyStudent->parentsandguardian->identidy_card ?></td>
					<td class=<?= $arrayMark['Parentsandguardians.work_phone'] ?>><?= $familyStudent->parentsandguardian->work_phone ?></td>
					<td class=<?= $arrayMark['Parentsandguardians.cell_phone'] ?>><?= $familyStudent->parentsandguardian->cell_phone ?></td>
					<td class=<?= $arrayMark['Parentsandguardians.email'] ?>><?= $familyStudent->parentsandguardian->email ?></td>

					<td><?= $familyStudent->parentsandguardian->second_surname_father . ' ' . $familyStudent->parentsandguardian->surname_father . ' ' . $familyStudent->parentsandguardian->first_name_father . ' ' . $familyStudent->parentsandguardian->second_name_father ?></td>							
					<td><?= $familyStudent->parentsandguardian->type_of_identification_father . '-' . $familyStudent->parentsandguardian->identidy_card_father ?></td>
					<td><?= $familyStudent->parentsandguardian->work_phone_father ?></td>
					<td><?= $familyStudent->parentsandguardian->cell_phone_father ?></td>
					<td><?= $familyStudent->parentsandguardian->email_father ?></td>
					
					<td><?= $familyStudent->parentsandguardian->second_surname_mother . ' ' . $familyStudent->parentsandguardian->surname_mother . ' ' . $familyStudent->parentsandguardian->first_name_mother . ' ' . $familyStudent->parentsandguardian->second_name_mother ?></td>							
					<td><?= $familyStudent->parentsandguardian->type_of_identification_mother . '-' . $familyStudent->parentsandguardian->identidy_card_mother ?></td>
					<td><?= $familyStudent->parentsandguardian->work_phone_mother ?></td>
					<td><?= $familyStudent->parentsandguardian->cell_phone_mother ?></td>
					<td><?= $familyStudent->parentsandguardian->email_mother ?></td>

				</tr>
			<?php endif; ?>
		<?php endforeach ?>
		</tbody>
		</table>
		<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
	</div>
	<div id="menu-menos" class="menumenos nover">
		<p>
		<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
		</p>
	</div>
	<div id="menu-mas" style="display:none;" class="menumas nover">
		<p>
			<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
			<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
			
			<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
		</p>
	</div>
<?php endif; ?>
<script>
$(document).ready(function(){ 
    $('#mas').on('click',function()
    {
        $('#menu-menos').hide();
        $('#menu-mas').show();
    });
    
    $('#menos').on('click',function()
    {
        $('#menu-mas').hide();
        $('#menu-menos').show();
    });
    
    $("#excel").click(function(){
        
        $("#family-students").table2excel({
    
            exclude: ".noExl",
        
            name: "family_students",
        
            filename: $('#family-students').attr('name') 
    
        });
    });
	
	$('#marcar-todos').click(function(e)
	{			
		e.preventDefault();
		
		$(".column-mark").each(function (index) 
		{ 
			$(this).attr('checked', true);
			$(this).prop('checked', true);
		});
	});
	
	$('#desmarcar-todos').click(function(e)
	{			
		e.preventDefault();
		
		$(".column-mark").each(function (index) 
		{ 
			$(this).attr('checked', false);
			$(this).prop('checked', false);
		});
	});
});
</script>