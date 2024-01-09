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
<div class="row">
    <div class="col-md-12">
		<div class="page-header">
	        <h3>Reporte de Cuentas Cobradas y por Cobrar</h3>
			<h4><?= $tipo_reporte." de la Cuota: ".$concepto_anio ?></h4>
	    </div>
		<div style="float: left; width: 100%;">
			<table  name="reporte_cuentas_cobradas_por_cobrar" id="reporte-cuentas-cobradas-por-cobrar" class="table table-striped table-hover">
				<thead>
					<tr>
						<?php if ($columna_contador_linea == 1): ?> 
							<th style="text-align:center;">Nro.</th>
						<?php endif; ?>
						<?php if ($columna_grado == 1): ?> 
							<th style="text-align:center;">Grado</th>
						<?php endif; ?>
						<?php if ($columna_nombre_estudiante == 1): ?> 
							<th style="text-align:center;">Estudiante</th>
						<?php endif; ?>
						<?php if ($columna_porcentaje_descuento == 1): ?> 
							<th style="text-align:center;">Descuento (%)</th>
						<?php endif; ?>
						<?php if ($columna_cantidad_estudiantes == 1): ?> 
							<th style="text-align:center;">Cantidad de estudiantes</th>
						<?php endif; ?>
						<th style="text-align:center;">Monto a cobrar ($)</th>
						<th style="text-align:center;">Cobrado ($)</th>
						<th style="text-align:center;">Por cobrar ($)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$contador_transacciones = 1;
					foreach ($vector_cuotas as $cuota): ?>
						<tr>
							<?php if ($columna_contador_linea == 1): ?> 
								<td style="text-align:center;"><?= $contador_transacciones ?></td>
							<?php endif; ?>
							<?php if ($columna_grado == 1): ?> 
								<td style="text-align:center;"><?= $cuota["grado"] ?></td>
							<?php endif; ?>
							<?php if ($columna_nombre_estudiante == 1): ?> 
								<td style="text-align:center;"><?= $cuota["nombre_estudiante"] ?></td>
							<?php endif; ?>
							<?php if ($columna_porcentaje_descuento == 1): ?> 
								<td style="text-align:center;"><?= $cuota["porcentaje_descuento"] ?></td>
							<?php endif; ?>
							<?php if ($columna_cantidad_estudiantes == 1): ?> 
								<td style="text-align:center;"><?= $cuota["cantidad_estudiantes"] ?></td>
							<?php endif; ?>
							<td style="text-align:center;"><?= number_format($cuota["monto_cuota"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($cuota["cobrado_cuota"], 2, ",", ".") ?></td>
							<td style="text-align:center;"><?= number_format($cuota["por_cobrar_cuota"], 2, ",", ".") ?></td>
						</tr>  
						<?php $contador_transacciones++; ?>
					<?php 
					endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<?php if ($columna_contador_linea == 1): ?> 
							<td style="text-align:center;"></td>
						<?php endif; ?>
						<?php if ($columna_grado == 1): ?> 
							<td style="text-align:center;"></td>
						<?php endif; ?>
						<?php if ($columna_nombre_estudiante == 1): ?> 
							<td style="text-align:center;"></td>
						<?php endif; ?>
						<?php if ($columna_porcentaje_descuento == 1): ?> 
							<td style="text-align:center;"></td>
						<?php endif; ?>		
						<?php if ($columna_cantidad_estudiantes == 1): ?> 					
							<td style="text-align:center;"><b><?= $cantidad_estudiantes_acumulado ?></td>
						<?php endif; ?>
						<td style="text-align:center;"><b><?= number_format($monto_cuota_acumulado, 2, ",", ".") ?></b></td>
						<td style="text-align:center;"><b><?= number_format($cobrado_acumulado, 2, ",", ".") ?></b></td>
						<td style="text-align:center;"><b><?= number_format($por_cobrar_acumulado, 2, ",", ".") ?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<script>
function myFunction() 
{
    window.print();
}
$(document).ready(function()
{ 
	$("#exportar-excel").click(function(){
		
		$("#reporte-cuentas-cobradas-por-cobrar").table2excel({
	
			exclude: ".noExl",
		
			name: "reporte_cuentas_cobradas_por_cobrar",
		
			filename: $('#reporte-cuentas-cobradas-por-cobrar').attr('name') 
	
		});
	});
});
</script>