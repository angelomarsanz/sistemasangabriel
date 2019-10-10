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
		<?php foreach ($conceptos as $concepto): ?>
				<?php if ($accountRecords == 0): ?>
					<table id="pagos" name="pagos-alumnos" class="noverScreen">
						<thead>
							<tr>
								<th scope="col"><b>Nro.</b></th>
								<th scope="col"><b>Nro. factura</b></th>
								<th scope="col"><b>Fecha</b></th>
								<th scope="col"><b>Total factura $</b></th>
								<th scope="col"><b>Familia</b></th>
								<th scope="col"><b>Concepto</b></th>
								<th scope="col"><b>Monto Bs.S</b></th>
							</tr>
						</thead>
						<tbody>						
				<?php endif ?>
				<?php $accountRecords++; ?>				
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $concepto->bill->bill_number ?></td>
					<td><?= $concepto->bill->date_and_time->format('d-m-Y') ?></td>
					<td><?= number_format($concepto->bill->amount_paid , 2, ",", ".") ?></td>
					<td><?= $concepto->bill->parentsandguardian->family ?></td>
					<td><?= $concepto->concept ?></td>
					<td><?= number_format($concepto->amount, 2, ",", ".") ?></td>
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