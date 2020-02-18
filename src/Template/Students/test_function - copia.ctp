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
	<?php $accountRecords = 0; ?>
	<?php foreach ($estudiantes as $estudiante): ?>
		<?php foreach ($transacciones as $transaccion): ?>
			<?php if ($estudiante->id == $transaccion->student_id): ?>
			<?php if ($transaccion->amount > 0): ?>
				<?php if ($accountRecords == 0): ?>
					<table id="alumnos" name="nuevos" class="table noverScreen">
						<thead>
							<tr>
								<th scope="col"><b>Nro</b></th>	
								<th scope="col"><b>id Alumno</b></th>
								<th scope="col"><b>Alumno</b></th>
								<th scope="col"><b>id Transaccion</b></th>
								<th scope="col"><b>Transacción</b></th>
								<th scope="col"><b>Monto Bs.S</b></th>
								<th scope="col"><b>Monto $</b></th>
								<th scope="col"><b>Fecha modificación</b></th>
							</tr>
						</thead>
						<tbody>						
				<?php endif ?>
				<?php $accountRecords++; ?>				
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $estudiante->id ?></td>
					<td><?= $estudiante->full_name ?></td>
					<td><?= $transaccion->id ?></td>
					<td><?= $transaccion->transaction_description ?></td>
					<td><?= $transaccion->amount ?></td>
					<td><?= $transaccion->amount_dollar ?></td>
					<td><?= $transaccion->modified->format('d-m-Y') ?></td>
				</tr>
			<?php endif; ?>
			<?php endif; ?>	
		<?php endforeach ?>
	<?php endforeach ?>
		</tbody>
	</table>
	<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
</div>
<script>
$(document).ready(function(){   
    $("#excel").click(function(){
        
        $("#alumnos").table2excel({
    
            exclude: ".noExl",
        
            name: "nuevos",
        
            filename: $('#alumnos').attr('name') 
    
        });
    });
});
</script>