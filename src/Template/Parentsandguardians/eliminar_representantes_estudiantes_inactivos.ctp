<?php
    /*
        Cambios:
        03/08/2023
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
	<?php $contador_registros = 1; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><b>Nro</b></th>	
                    <th scope="col"><b>Familia</b></th>
                    <th scope="col"><b>Nombre del representante</b></th>
                    <th scope="col"><b>Motivo</b></th>
                    <th scope="col"><b>ID del representante</b></th>
                </tr>
            </thead>
            <tbody>						
            <?php foreach ($representantes_sin_estudiantes as $representante): ?>
				<tr>
					<td><?= $contador_registros ?></td>
                    <td><?= $representante['familia'] ?></td>
					<td><?= $representante['nombre_representante'] ?></td>
                    <td><?= $representante['motivo'] ?></td>
					<td><?= $representante['id_representante'] ?></td>
				</tr>
                <?php $contador_registros++; ?>
    		<?php endforeach ?>
    		</tbody>
	    </table>
</div>
<script>
$(document).ready(function()
{   

});
</script>