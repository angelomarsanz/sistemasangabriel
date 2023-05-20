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
	.saltopagina
	{
		display:block; 
		page-break-before:always;
	}
}
</style>
<div class="container" style="font-size: 12px; line-height: 14px;">
	<div class="row">
		<h2>Posterior Reparar Cierre del Turno <?= $idTurno ?></h2>
	</div>
    <div class="row">
		<h3>Documentos de este turno anulados en otro turno</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th style="text-align: center;"><b>Número</b></th>
					<th style="text-align: center;"><b>Control</b></th>
					<th style="text-align: center;"><b>Tipo</b></th>
					<th style="text-align: center;"><b>Turno Creación Documento</b></th>
					<th style="text-align: center;"><b>Turno Anulación</b></th>
				</tr>
			</thead>
			<tbody>				
				<?php 
				$anulados_otro_turno = 0;
				foreach ($documentosAnulados as $anulado): 
					if ($anulado->turn != $anulado->id_turno_anulado):?>  
						<tr>
							<td style="text-align: center;"><?= $anulado->bill_number ?></td>
							<td style="text-align: center;"><?= $numero_control_anulado = $anulado->control_number == 999999 ? "S/N": $anulado->control_number; ?></td>
							<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
							<td style="text-align: center;"><?= $anulado->turn ?></td>
							<td style="text-align: center;"><?= $anulado->id_turno_anulacion ?></td>
						</tr>
						<?php
						$anulados_otro_turno++;
					endif; 
				endforeach; ?>
			</tbody>
		</table>
		<p>Total documentos de este turno anulados en otro turno: <?= $anulados_otro_turno?></p>
    </div> 
</div>   
<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#reporte-cierre").table2excel({
		
				exclude: ".noExl",
			
				name: "reporte_cierre",
			
				filename: $('#reporte-cierre').attr('name') 
		
			});
		});
    });
        
</script>