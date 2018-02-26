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
<div>
    <br />
	<div>
		<div style="float: left; width:10%;">
			<p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
		</div>
		<div style="float: left; width: 90%;">
			<h5><b><?= $school->name ?></b></h5>
			<p>RIF: <?= $school->rif ?></p>
			<h3 style="text-align: center;">Reporte Contacto Alumnos al: <?= $currentDate->format('d-m-Y') ?></h3>
		</div>
	</div>
	<div>
		<table id="general" class="table">
			<thead>
				<tr>
					<th scope="col">Nro.</th>		
					<th scope="col">Alumno</th>	
					<th scope="col">Estatus</th>					
					<th scope="col">Representante</th>
					<th scope="col">Email</th>
					<th scope="col">Celular</th>
					<th scope="col">Teléfono fijo</th>
					<th scope="col">Teléfono trabajo</th>
					
				</tr>
			</thead>
			<tbody>
				<?php $accountStudent = 0; ?>
				<?php foreach ($studentsFor as $studentsFors): ?> 
					<?php $accountStudent++; ?>
						<tr>
							<td><?= $accountStudent ?></td>
							<td><?= $studentsFors->surname ?>&nbsp;<?= $studentsFors->second_surname . ' ' . $studentsFors->first_name ?>&nbsp;<?= $studentsFors->second_name ?></td>
							<td><?= $studentObservations[$studentsFors->id]['observation'] ?></td>
							<td><?= $studentsFors->parentsandguardian->surname ?>&nbsp;<?= $studentsFors->parentsandguardian->second_surname . ' ' . $studentsFors->parentsandguardian->first_name ?><?= $studentsFors->parentsandguardian->first_name ?></td>
							<td><?= $studentsFors->parentsandguardian->email ?></td>
							<td><?= $studentsFors->parentsandguardian->cell_phone ?></td>
							<td><?= $studentsFors->parentsandguardian->landline ?></td>
							<td><?= $studentsFors->parentsandguardian->work_phone ?></td>
							
						</tr>
					<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
        <a href='#' id="excel" title="EXCEL" class='glyphicon glyphicon-list-alt btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
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
    
    $("#excel").click(function(){
        
        $("#general").table2excel({
    
            exclude: ".noExl",
        
            name: "Reporte contacto alumnos",
        
            filename: "reporte contacto alumnos" 
    
        });
    });
});
</script>