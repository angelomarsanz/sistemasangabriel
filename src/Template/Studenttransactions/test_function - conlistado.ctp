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
	<br />
	<?php $accountRecords = 0; ?>
		<?php foreach ($transacciones as $transaccion): ?>
				<?php if ($accountRecords == 0): ?>
					<table id="pagos" name="pagos-alumnos" class="noverScreen">
						<thead>
							<tr>
								<th scope="col"><b>Nro.</b></th>
								<th scope="col"><b>Alumno</b></th>
								<th scope="col"><b>Descuento</b></th>
								<th scope="col"><b>Mensualidad</b></th>
								<th scope="col"><b>Monto $</b></th>
								</tr>
						</thead>
						<tbody>						
				<?php endif ?>
				<?php $accountRecords++; ?>				
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $transaccion->student->full_name ?></td>
					<td><?= $transaccion->student->discount ?></td>
					<td><?= $transaccion->transaction_description ?></td>
					<td><?= $transaccion->amount_dollar ?></td>					
				</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
</div>
<script>
$(document).ready(function(){   
    $("#excel").click(function(){
        
        $("#pagos").table2excel({
    
            exclude: ".noExl",
        
            name: "pagos",
        
            filename: $('#pagos').attr('name') 
    
        });
    });
});
</script>