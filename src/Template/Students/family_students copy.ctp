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
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h2>Familias - Alumnos</h2>
		</div>
		<?= $this->Form->create() ?>
			<fieldset>	
				<div id="filter-order" class="row">
					<div class="col-md-3">
						<?php
							echo $this->Form->input('filters_report', ['label' => 'Seleccionar: *', 'required' => true, 'options' => 
							[null => " ",
							 'Nuevos' => 'Alumnos nuevos',
							 'Regulares' => 'Alumnos regulares',
							 'Regulares próximo año escolar' => 'Alumnos regulares inscritos para el próximo año escolar',
							 'Nuevos y regulares' => 'Alumnos nuevos y regulares',
							 'Nuevos próximo año escolar' => 'Alumnos nuevos inscritos para el próximo año escolar',
							 'Todos' => 'Nuevos, regulares, egresados, expulsados, etc.'
							 ]]);
						?>
					</div>
					<div class="col-md-3">
						<?php
							echo $this->Form->input('order_report', ['label' => 'Ordenar por: *', 'required' => true, 'options' => 
							[null => " ",
							 'Familia' => 'Familia',
							 'Alumno' => 'Alumno'],
							 ]);
						?>
					</div>
					<div class="col-md-6">
					</div>
				</div>
				<div id="columns-report" class="row">
					<div class="col-md-6">
						<h4>Datos del estudiante</h4>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.estatus]"> Estatus del alumno</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.sex]"> Sexo</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.nationality]"> Nacionalidad</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.identity_card]"> Cédula o pasaporte</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.balance]"> Año escolar</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.section_id]"> Grado y sección actual</p>
						<p><input class="column-mark" type="checkbox" name="columnsReport[Students.grado_renovacion]"> Grado renovación inscripción</p>
						
					</div>
					<div class="col-md-6">
						<h4>Datos de la familia</h4>
						<div class="row">
							<div class="col-md-1">
							</div>
							<div class="col-md-11">
								<h5><b>Datos del representante:</b></h5>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.full_name]" id="nombre"> Nombre</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.sex]"> Sexo</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.identidy_card]"> Cédula o pasaporte</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.work_phone]"> Teléfono trabajo</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.cell_phone]"> Celular</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.email]"> Email</p>
								<h5><b>Datos del padre:</b></h5>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.nombre_completo_padre]" id="nombre"> Nombre</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.documento_identidad_padre]"> Cédula o pasaporte</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.work_phone_father]"> Teléfono trabajo</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.cell_phone_father]"> Celular</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.email_father]"> Email</p>
								<h5><b>Datos de la madre:</b></h5>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.nombre_completo_madre]" id="nombre"> Nombre</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.documento_identidad_madre]"> Cédula o pasaporte</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.work_phone_mother]"> Teléfono trabajo</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.cell_phone_mother]"> Celular</p>
									<p><input class="column-mark" type="checkbox" name="columnsReport[Parentsandguardians.email_mother]"> Email</p>
							</div>
						</div>
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