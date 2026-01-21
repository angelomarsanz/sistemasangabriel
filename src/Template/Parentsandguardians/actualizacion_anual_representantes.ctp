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
<div class="row nover">
    <div class="col-md-12 text-center">
        <?= $this->Html->link(__('Continuar con la asignación de secciones'), ['controller' => 'Studenttransactions', 'action' => 'assignSection'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>  
<br />
<div class="row">
    <div class="col-md-12" name="representantes_sin_estudiantes_activos" id="representantes-sin-estudiantes-activos">
        <div>
            <h3>Representantes Con Estudiantes Activos</h3>
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
                    <?php foreach ($representantes_con_estudiantes_activos as $representanteActivo): ?>
                        <tr>
                            <td><?= $contadorRepresentantesConEstudiantesActivos ?></td>
                            <td><?= $representanteActivo['familia'] ?></td>
                            <td><?= $representanteActivo['nombre_representante'] ?></td>
                            <td><?= $representanteActivo['consejoEducativo'] ?></td>
                            <td><?= $representanteActivo['id_representante'] ?></td>
                        </tr>
                        <?php $contadorRepresentantesConEstudiantesActivos++; ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
        </div>
        <div>
            <h3>Representantes Sin Estudiantes Activos</h3>
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
                    <?php foreach ($representantes_sin_estudiantes_activos as $representanteInactivo): ?>
                        <tr>
                            <td><?= $contadorRepresentantesSinEstudiantesActivos ?></td>
                            <td><?= $representanteInactivo['familia'] ?></td>
                            <td><?= $representanteInactivo['nombre_representante'] ?></td>
                            <td><?= $representanteInactivo['motivo'] ?></td>
                            <td><?= $representanteInactivo['id_representante'] ?></td>
                        </tr>
                        <?php $contadorRepresentantesSinEstudiantesActivos++; ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
        </div>
        <div>
            <h3>Estudiantes Eliminados</h3>
            <?php $contador_registros_estudiantes = 1; ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><b>Nro</b></th>	
                            <th scope="col"><b>Estudiante</b></th>
                            <th scope="col"><b>Familia</b></th>
                            <th scope="col"><b>ID</b></th>
                        </tr>
                    </thead>
                    <tbody>						
                    <?php foreach ($estudiantes_eliminados as $estudiante): ?>
                        <tr>
                            <td><?= $contador_registros_estudiantes ?></td>
                            <td><?= $estudiante['estudiante'] ?></td>
                            <td><?= $estudiante['familia'] ?></td>
                            <td><?= $estudiante['id_estudiante'] ?></td>
                        </tr>
                        <?php $contador_registros_estudiantes++; ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function()
{   
	$("#exportar-excel").click(function(){
		
		$("#representantes-sin-estudiantes-activos").table2excel({
	
			exclude: ".noExl",
		
			name: "representantes_sin_estudiantes_activos",
		
			filename: $('#representantes-sin-estudiantes-activos').attr('name') 
	
		});
	});
});
</script>