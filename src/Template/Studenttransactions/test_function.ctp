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
		<?php foreach ($transacciones as $transaccion): ?>
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
								<th scope="col"><b>Fecha factura</b></th>
								<th scope="col"><b>Nro. factura</b></th>
							</tr>
						</thead>
						<tbody>						
				<?php endif ?>
				<?php $accountRecords++; ?>				
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $transaccion->student->id ?></td>
					<td><?= $transaccion->student->full_name ?></td>
					<td><?= $transaccion->id ?></td>
					<td><?= $transaccion->transaction_description ?></td>
					<td><?= $transaccion->amount ?></td>
					<td><?= $transaccion->amount_dollar ?></td>
					<td><?= $vectorFactura[$transaccion->id]->format('Y-m-d') ?></td>
					<td><?= $transaccion->bill_number ?></td>
				</tr>
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