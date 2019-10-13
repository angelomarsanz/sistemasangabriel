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
		<?php foreach ($vectorPagos as $pagos): ?>
				<?php if ($accountRecords == 0): ?>
					<table id="pagos" name="pagos-alumnos" class="noverScreen">
						<thead>
							<tr>
								<th scope="col"><b>Nro.</b></th>
								<th scope="col"><b>Nro Factura</b></th>
								<th scope="col"><b>id Factura</b></th>
								<th scope="col"><b>Fecha</b></th>
								<th scope="col"><b>Alumno</b></th>
								<th scope="col"><b>Concepto</b></th>
								<th scope="col"><b>Monto concepto</b></th>
								<th scope="col"><b>Descripción transacción</b></th>
								<th scope="col"><b>Monto original</b></th>
								<th scope="col"><b>Monto abonado</b></th>
								<th scope="col"><b>Monto dolar</b></th>
								<th scope="col"><b>Indicador pagado</b></th>
								<th scope="col"><b>Pago parcial</b></th>
							</tr>
						</thead>
						<tbody>						
				<?php endif ?>
				<?php $accountRecords++; ?>				
				<tr>
					<td><?= $accountRecords ?></td>
					<td><?= $pagos['nroFactura'] ?></td>
					<td><?= $pagos['idFactura'] ?></td>
					<td><?= $pagos['fechaFactura']->format('d-m-Y') ?></td>
					<td><?= $pagos['alumno'] ?></td>
					<td><?= $pagos['concepto'] ?></td>
					<td><?= $pagos['montoConcepto'] ?></td>
					<td><?= $pagos['descripcionTransaccion'] ?></td>
					<td><?= $pagos['montoOriginal'] ?></td>
					<td><?= $pagos['montoAbonado'] ?></td>
					<td><?= $pagos['montoDolar'] ?></td>
					<td><?= $pagos['indicadorPagado'] ?></td>
					<td><?= $pagos['pagoParcial'] ?></td>
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