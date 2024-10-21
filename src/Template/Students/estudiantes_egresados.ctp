<?php
    use Cake\Routing\Router; 
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
@media print
{
	.saltopagina
	{
		display:block; 
		page-break-before:always;
	}
}
</style>
<div name="egresados" id="egresados" class="container" style="font-size: 12px; line-height: 14px;">
	<br />
    <div class="row">
        <div class="col-md-12">
			<div>
				<table style="width:100%; font-size: 14px; line-height: 16px;">
					<tbody>
						<tr>
							<td>Unidad Educativa Colegio</td>
						</tr>
						<tr>
							<td><b>"San Gabriel Arcángel C.A."</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>	
						<tr>
							<td><b>Estudiantes Egresados</b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">					
			<table class="table table-striped table-hover">
				<thead>	
					<tr>
						<th>Nro.</th>
						<th>Promoción</th>
						<th><b>Estudiante</th>
						<th><b>Grado</th>
						<th><b>Representante</b></th>
						<th><b>Correo representante</b></th>
						<th><b>Celular representante</b></th>
						<th><b>Teléfono fijo representante</b></th>
						<th><b>Teléfono trabajo representante</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$contador = 1; 
					foreach ($egresados as $clave => $egresado): ?>
						<tr>
							<td><?= $contador ?>
							<td><?= $egresado->balance ?>
							<td><?= $egresado->full_name ?></td>
							<td><?= $egresado->section->level.'-'.$egresado->section->sublevel ?></td>
							<td><?= $egresado->parentsandguardian->full_name ?></td>
							<td><?= $egresado->parentsandguardian->email ?></td>
							<td><?= $egresado->parentsandguardian->cell_phone ?></td>
							<td><?= $egresado->parentsandguardian->landline ?></td>
							<td><?= $egresado->parentsandguardian->work_phone ?></td>
						</tr> 
						<?php
						$contador++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#egresados").table2excel({
		
				exclude: ".noExl",
			
				name: "egresados",
			
				filename: $('#egresados').attr('name') 
		
			});
		});
    });
        
</script>