<?php
    /*
        Historial de cambios:
        12/03/2024
        Este es un módulo nuevo que está en pruebas
    */
?>
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
<br />
<br />
<div>
	<?php $contadorRepresentantesConEstudiantesActivos = 1; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><b>Nro</b></th>	
                    <th scope="col"><b>Familia</b></th>
                    <th scope="col"><b>Nombre del Representante</b></th>
                    <th scope="col"><b>Consejo Educativo</b></th>
                    <th scope="col"><b>ID del Representante</b></th>
                </tr>
            </thead>
            <tbody>						
            <?php foreach ($representantes_sin_estudiantes_activos as $representante): ?>
				<tr>
					<td><?= $contadorRepresentantesConEstudiantesActivos ?></td>
                    <td><?= $representante['familia'] ?></td>
					<td><?= $representante['nombre_representante'] ?></td>
                    <td><?= $representante['consejoEducativo'] ?></td>
					<td><?= $representante['id_representante'] ?></td>
				</tr>
                <?php $contadorRepresentantesConEstudiantesActivos++; ?>
    		<?php endforeach ?>
    		</tbody>
	    </table>
</div>
<div>
	<?php $contadorRepresentantesSinEstudiantesActivos = 1; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><b>Nro</b></th>	
                    <th scope="col"><b>Familia</b></th>
                    <th scope="col"><b>Nombre del Representante</b></th>
                    <th scope="col"><b>Motivo</b></th>
                    <th scope="col"><b>ID del representante</b></th>
                </tr>
            </thead>
            <tbody>						
            <?php foreach ($representantes_sin_estudiantes_activos as $representante): ?>
				<tr>
					<td><?= $contadorRepresentantesSinEstudiantesActivos ?></td>
                    <td><?= $representante['familia'] ?></td>
					<td><?= $representante['nombre_representante'] ?></td>
                    <td><?= $representante['motivo'] ?></td>
					<td><?= $representante['id_representante'] ?></td>
				</tr>
                <?php $contadorRepresentantesSinEstudiantesActivos++; ?>
    		<?php endforeach ?>
    		</tbody>
	    </table>
</div>
<div>
	<?php $contador_registros_estudiantes = 1; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><b>Nro</b></th>	
                    <th scope="col"><b>Estudiante</b></th>
                    <th scope="col"><b>ID</b></th>
                </tr>
            </thead>
            <tbody>						
            <?php foreach ($estudiantes_eliminados as $estudiante): ?>
				<tr>
					<td><?= $contador_registros_estudiantes ?></td>
					<td><?= $estudiante['estudiante'] ?></td>
					<td><?= $estudiante['id_estudiante'] ?></td>
				</tr>
                <?php $contador_registros_estudiantes++; ?>
    		<?php endforeach ?>
    		</tbody>
	    </table>
</div>
<script>
$(document).ready(function()
{   

});
</script>