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
		<h2>Previo Reparar Cierre del Turno <?= $idTurno ?></h2>
	</div>
    <div class="row">
		<h3>Documentos de este turno anulados en este mismo turno</h3>
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
				$anulados_este_turno = 0;
				foreach ($documentosAnulados as $anulado): 
					if ($anulado->turn == $anulado->id_turno_anulado):?>  
						<tr>
							<td style="text-align: center;"><?= $anulado->bill_number ?></td>
							<td style="text-align: center;"><?= $numero_control_anulado = $anulado->control_number == 999999 ? "S/N": $anulado->control_number; ?></td>
							<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
							<td style="text-align: center;"><?= $anulado->turn ?></td>
							<td style="text-align: center;"><?= $anulado->id_turno_anulacion ?></td>
						</tr>
						<?php
						$anulados_este_turno++;
					endif; 
				endforeach; ?>
			</tbody>
		</table>
		<p>Total documentos de este turno anulados en este mismo turno: <?= $anulados_este_turno?></p>
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
    <div class="row">
		<h3>Pagos IGTF</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th style="text-align: center;"><b>Número</b></th>
					<th style="text-align: center;"><b>Control</b></th>
					<th style="text-align: center;"><b>Moneda</b></th>
					<th style="text-align: center;"><b>Monto</b></th>
					<th style="text-align: center;"><b>Igtf</b></th>
					<th style="text-align: center;"><b>Igtf Factura</b></th>
				</tr>
			</thead>
			<tbody>				
				<?php 
				$contador_pagos_igtf = 0;
				foreach ($pagos_igtf as $igtf): ?>
					<tr>
						<td style="text-align: center;"><?= $igtf->bill->bill_number ?></td>
						<td style="text-align: center;"><?= $numero_control_anulado = $igtf->bill->control_number == 999999 ? "S/N": $igtf->bill->control_number; ?></td>
						<td style="text-align: center;"><?= $igtf->moneda ?></td>
						<td style="text-align: center;"><?= $igtf->amount ?></td>
						<td style="text-align: center;"><?= $igtf->monto_igtf_dolar ?></td>
						<td style="text-align: center;"><?= $igtf->bill->monto_igtf ?></td>
					</tr>
					<?php
					$contador_pagos_igtf++;
				endforeach; ?>
			</tbody>
		</table>
		<p>Total pagos IGTF: <?= $contador_pagos_igtf ?></p>
    </div>    
	<div class="row">
		<h3>Pagos IGTF Reparados</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th style="text-align: center;"><b>Número</b></th>
					<th style="text-align: center;"><b>Control</b></th>
					<th style="text-align: center;"><b>Moneda</b></th>
					<th style="text-align: center;"><b>Monto</b></th>
					<th style="text-align: center;"><b>Igtf</b></th>
					<th style="text-align: center;"><b>Igtf Factura</b></th>
				</tr>
			</thead>
			<tbody>				
				<?php 
				$contador_pagos_igtf_reparados = 0;
				foreach ($pagos_igtf_reparados as $igtf): ?>
					<tr>
						<td style="text-align: center;"><?= $igtf->bill->bill_number ?></td>
						<td style="text-align: center;"><?= $numero_control_anulado = $igtf->bill->control_number == 999999 ? "S/N": $igtf->bill->control_number; ?></td>
						<td style="text-align: center;"><?= $igtf->moneda ?></td>
						<td style="text-align: center;"><?= $igtf->amount ?></td>
						<td style="text-align: center;"><?= $igtf->monto_igtf_dolar ?></td>
						<td style="text-align: center;"><?= $igtf->bill->monto_igtf ?></td>
					</tr>
					<?php
					$contador_pagos_igtf_reparados++;
				endforeach; ?>
			</tbody>
		</table>
		<p>Total pagos IGTF reparados: <?= $contador_pagos_igtf_reparados ?></p>
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