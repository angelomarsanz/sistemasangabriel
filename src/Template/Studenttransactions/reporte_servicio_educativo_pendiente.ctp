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
	.estiloEncabezadoTabla
	{
		border-style: double none double none;
  		border-color: black;
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
	.estiloEncabezadoTabla
	{
		border-style: double none double none;
  		border-color: black;
	}
}
</style>
<br />
<?php
$contadorElementos = 0;
$acumuladoDiferenciaServicioEducativo = 0;
?>
<div class="row">
    <div class="col-md-12" name="reporte_servicio_educativo_pendiente" id="reporte-servicio_educativo_pendiente">
		<div class="page-header">
	        <h3>Reporte de Estudiantes Con Servicio Educativo Pendiente</h3>
			<h5>Fecha de emisión del reporte: <?=  $currentDate->format('d/m/Y'); ?></h5>
	    </div>
		<div "float: left; width: 100%;">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style="text-align:center;">Nro.</th>
						<th style="text-align:left;">Estudiante</th>
						<th style="text-align:center;">Saldo pendiente</th>
						<th style="text-align:center;">Observación</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($vectorDiferenciasInscripcion as $diferencia): 
						$contadorElementos++;
						$acumuladoDiferenciaServicioEducativo += $diferencia["diferenciaServicioEducativo"]; ?>
						<tr>
							<td style="text-align:center;"><?= $contadorElementos ?></td>
							<td style="text-align:left;"><?= $diferencia["nombreEstudiante"]; ?></td>
							<td style="text-align:center;"><?= number_format($diferencia["diferenciaServicioEducativo"], 2, ",", "."); ?></td>
							<td style="text-align:center;"><?= $diferencia["diferenciaServicioEducativo"] == 0 ? 'No se ha establecido el monto del servicio educativo para este estudiante' : ''; ?></td>
						</tr>  
					<?php
					endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align:center;">Totales</td>
						<td></td>
						<td style="text-align:center;"><?= number_format($acumuladoDiferenciaServicioEducativo, 2, ",", "."); ?></td>
						<td></td>
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
		
		$("#reporte-servicio-educativo-pendiente").table2excel({
	
			exclude: ".noExl",
		
			name: "reporte-servicio-educativo-pendiente",
		
			filename: $('#reporte-servicio-educativo-pendiente').attr('name') 
	
		});
	});
});
</script>