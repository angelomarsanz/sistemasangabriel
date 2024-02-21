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
$totalDiferencia = 0;
$acumuladoDiferenciaMatricula = 0;
$acumuladoDiferenciaAgosto = 0;
$acumuladoTotalDiferencia = 0; ?>
<div class="row">
    <div class="col-md-12" name="reporte_estudiantes_nuevos_con_diferencias_inscripcion" id="reporte-estudiantes-nuevos-con-diferencias-inscripcion">
		<div class="page-header">
	        <h3>Reporte de Estudiantes nuevos con Diferencias de Inscripción</h3>
			<h5>Fecha de emisión del reporte: <?=  $currentDate->format('d/m/Y'); ?></h5>
	    </div>
		<div "float: left; width: 100%;">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style="text-align:center;">Nro.</th>
						<th style="text-align:left;">Estudiante</th>
						<th style="text-align:center;">Saldo Matrícula</th>
						<th style="text-align:center;">Saldo Agosto</th>
						<th style="text-align:center;">Total saldo</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($vectorDiferenciasInscripcion as $diferencia): 
						$contadorElementos++;
						$totalDiferencia = $diferencia["diferenciaMatricula"] + $diferencia["diferenciaAgosto"]; 
						$acumuladoDiferenciaMatricula += $diferencia["diferenciaMatricula"];
						$acumuladoDiferenciaAgosto += $diferencia["diferenciaAgosto"]; ?>
						<tr>
							<td style="text-align:center;"><?= $contadorElementos ?></td>
							<td style="text-align:left;"><?= $diferencia["nombreEstudiante"]; ?></td>
							<td style="text-align:center;"><?= number_format($diferencia["diferenciaMatricula"], 2, ",", "."); ?></td>
							<td style="text-align:center;"><?= number_format($diferencia["diferenciaAgosto"], 2, ",", "."); ?></td>
							<td style="text-align:center;"><?= number_format($totalDiferencia, 2, ",", "."); ?></td>
						</tr>  
					<?php
					endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align:center;">Totales</td>
						<td></td>
						<td style="text-align:center;"><?= number_format($acumuladoDiferenciaMatricula, 2, ",", "."); ?></td>
						<td style="text-align:center;"><?= number_format($acumuladoDiferenciaAgosto, 2, ",", "."); ?></td>
						<td style="text-align:center;"><?= number_format($acumuladoDiferenciaAgosto, 2, ",", "."); ?></td>
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
		
		$("#reporte-estudiantes-nuevos-con-diferencias-inscripcion").table2excel({
	
			exclude: ".noExl",
		
			name: "reporte-estudiantes-nuevos-con-diferencias-inscripcion",
		
			filename: $('#reporte-estudiantes-nuevos-con-diferencias-inscripcion').attr('name') 
	
		});
	});
});
</script>