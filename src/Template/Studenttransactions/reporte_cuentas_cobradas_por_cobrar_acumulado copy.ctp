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
		border-style: solid none solid none;	
		border-width: 4px 4px;
		border-color: black;
	}
	.colorBordesTabla
	{
		border-style: solid none solid none;
		border-width: 2px 2px;
		border-color: black;
	}
}
@media print
{
   	.nover 
    {
      display:none;
    }
	.saltopagina
	{
		display:block; 
		page-break-before:always;
	}	
	.estiloEncabezadoTabla
	{
		border-style: solid none solid none;	
		border-width: 4px 4px;
		border-color: black;
	}
	.colorBordesTabla
	{
		border-style: solid none solid none;
		border-width: 2px 2px;
		border-color: black;
	}
}
</style>
<br />
<?php
$nombreNivel =
	[
		0 => "Reporte General",
		1 => "Sin asignar sección",
		2 => "Maternal",
		3 => "Pre-escolar",
		4 => "Primaria",
		5 => "Secundaria"
	]; 
$subtitulo = ""; 
$indicador_tabla_general = 0;
$indicadorSaltoPagina = 0;
$estilosReportes =
[
	"Totales generales" =>
		[
            "totales" => "style='display:none;' class='noExl'",
            "contadorLinea" => "style='display:none;' class='noExl'",
            "nombreEstudiante" => "style='display:none;' class='noExl'",
            "nivelEstudios" => "style='text-align:center;'",
            "grado" => "style='display:none;' class='noExl'",
            "beca" => "style='text-align:center;'",
            "cantidadEstudiantes" => "style='text-align:center;'",
            "quePagaron" => "style='text-align:center;'",
            "porPagar" => "style='text-align:center;'",
            "montoACobrar" => "style='text-align:center;'",
            "cobradoCompleto" => "style='text-align:center;'",
            "abono" => "style='text-align:center;'",
            "prontoPago" => "style='text-align:center;'",
            "porCobrar" => "style='text-align:center;'"
		],
	"Por grado" =>
		[
			"Inscripcion" => 
				[
					"totales" => "style='text-align:left;'",
					"contadorLinea" => "style='display:none;' class='noExl'",
					"nombreEstudiante" => "style='display:none;' class='noExl'",
					"nivelEstudios" => "style='text-align:center;'",
					"grado" => "style='display:none;' class='noExl'",
					"beca" => "style='display:none;' class='noExl'",
					"cantidadEstudiantes" => "style='display:none;' class='noExl'",
					"quePagaron" => "style='display:none;' class='noExl'",
					"porPagar" => "style='display:none;' class='noExl'",
					"montoACobrar" => "style='text-align:center;'",
					"cobradoCompleto" => "style='text-align:center;'",
					"abono" => "style='text-align:center;'",
					"prontoPago" => "style='display:none;' class='noExl'",
					"porCobrar" => "style='text-align:center;'"
				],
			"Mensualidades" => 
				[
					"totales" => "style='display:none;' class='noExl'",
					"contadorLinea" => "style='display:none;' class='noExl'",
					"nombreEstudiante" => "style='display:none;' class='noExl'",
					"nivelEstudios" => "style='text-align:center;'",
					"grado" => "style='display:none;' class='noExl'",
					"beca" => "style='text-align:center;'",
					"cantidadEstudiantes" => "style='display:none;' class='noExl'",
					"quePagaron" => "style='display:none;' class='noExl'",
					"porPagar" => "style='display:none;' class='noExl'",
					"montoACobrar" => "style='text-align:center;'",
					"cobradoCompleto" => "style='text-align:center;'",
					"abono" => "style='text-align:center;'",
					"prontoPago" => "style='text-align:center;'",
					"porCobrar" => "style='text-align:center;'"
				],
		],
	"Por estudiante" =>
		[
			"Inscripcion" => 
				[
					"totales" => "style='display:none;' class='noExl'",
					"contadorLinea" => "style='text-align:center;'",
					"nombreEstudiante" => "style='text-align:center;'",
					"nivelEstudios" => "style='display:none;' class='noExl'",
					"grado" => "style='text-align:center;'",
					"beca" => "style='text-align:center;'",
					"cantidadEstudiantes" => "style='display:none;' class='noExl'",
					"quePagaron" => "style='display:none;' class='noExl'",
					"porPagar" => "style='display:none;' class='noExl'",
					"montoACobrar" => "style='text-align:center;'",
					"cobradoCompleto" => "style='text-align:center;'",
					"abono" => "style='text-align:center;'",
					"prontoPago" => "style='display:none;' class='noExl'",
					"porCobrar" => "style='text-align:center;'"
				],
			"Mensualidades" => 
				[
					"totales" => "style='display:none;' class='noExl'",
					"contadorLinea" => "style='text-align:center;'",
					"nombreEstudiante" => "style='text-align:center;'",
					"nivelEstudios" => "style='display:none;' class='noExl'",
					"grado" => "style='text-align:center;'",
					"beca" => "style='text-align:center;'",
					"cantidadEstudiantes" => "style='display:none;' class='noExl'",
					"quePagaron" => "style='display:none;' class='noExl'",
					"porPagar" => "style='display:none;' class='noExl'",
					"montoACobrar" => "style='text-align:center;'",
					"cobradoCompleto" => "style='text-align:center;'",
					"abono" => "style='text-align:center;'",
					"prontoPago" => "style='text-align:center;'",
					"porCobrar" => "style='text-align:center;'"
				]
		]
]; 
$espaciosColumnas =
[
	"Totales generales" => 10,
	"Por grado" => 7,
	"Por estudiante" => 9]; ?>

<div class="row">
    <div class="col-md-12" name="reporte_cuentas_cobradas_por_cobrar" id="reporte-cuentas-cobradas-por-cobrar">
		<div class="page-header">
	        <h3>Reporte de Cuentas Cobradas y por Cobrar (Acumulado)</h3>
			<h4><?= $tipo_reporte." de la Cuota: ".$concepto_anio_desde ?></h4>
			<h5>Fecha de emisión del reporte: <?=  $currentDate->format('d/m/Y'); ?></h5>
	    </div>
		<?php 
		foreach ($vector_cuotas as $indiceNivel => $nivel): 
			$indicador_tabla_general++; 
			$indicadorSaltoPagina++;
			if ($tipo_reporte == "Totales generales"):
				if ($indicadorSaltoPagina == 3): 
					$indicadorSaltoPagina = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>
					<div>
				<?php
				endif; 
			else: ?>
				<div>
			<?php
			endif; ?> 
				<table class="table table-hover" style="width:100%;">
					<thead>
						<?php
						if ($tipo_reporte == "Totales generales"):
							if ($indicador_tabla_general == 2): ?>
								<tr>
									<th style="text-align:center;" colspan=<?= $espaciosColumnas[$tipo_reporte] ?>><h3>Detalle Por Niveles</h3></th>
								</tr>
							<?php
							endif; 
							$subtitulo = $nombreNivel[$indiceNivel];
						elseif ($tipo_reporte == "Por grado"):
							$subtitulo = $nivel[0]["grado"];
						endif; 
						if ($subtitulo == "Reporte General"): ?>
							<tr>
								<th style="text-align:center;" colspan=<?= $espaciosColumnas[$tipo_reporte] ?>><h3><?= $subtitulo ?></h3></th>
							</tr>
						<?php
						else: ?>
							<tr>
								<th colspan=<?= $espaciosColumnas[$tipo_reporte] ?>><h4><b><?= $subtitulo ?></b></h4></th>
							</tr>
						<?php
						endif; ?>
						<tr class="estiloEncabezadoTabla">
							<th <?= $estilosReportes[$tipo_reporte]["totales"] ?>></th>
							<th <?= $estilosReportes[$tipo_reporte]["contadorLinea"] ?>>Nro.</th>
							<th <?= $estilosReportes[$tipo_reporte]["nombreEstudiante"] ?>>Estudiante</th>
							<th <?= $estilosReportes[$tipo_reporte]["grado"] ?>>Grado</th>
							<th <?= $estilosReportes[$tipo_reporte]["beca"] ?>>Beca (%)</th>
							<th <?= $estilosReportes[$tipo_reporte]["cantidadEstudiantes"] ?>>Cant. de estudiantes</th>
							<th <?= $estilosReportes[$tipo_reporte]["quePagaron"] ?>>Estudiantes que pagaron</th>
							<th <?= $estilosReportes[$tipo_reporte]["porPagar"] ?>>Estudiantes por pagar</th>
							<th <?= $estilosReportes[$tipo_reporte]["montoACobrar"] ?>>Monto a cobrar ($)</th>
							<th <?= $estilosReportes[$tipo_reporte]["cobradoCompleto"] ?>>Cobrado completo ($)</th>
							<th <?= $estilosReportes[$tipo_reporte]["abono"] ?>>Abono ($)</th>
							<th <?= $estilosReportes[$tipo_reporte]["prontoPago"] ?>>Pronto pago ($)</th>
							<th <?= $estilosReportes[$tipo_reporte]["porCobrar"] ?>>Por cobrar ($)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$contador_transacciones = 1;
						$acumuladoCantidadEstudiantes = 0;
						$acumuladoQuePagaron = 0;
						$acumuladoPorPagar = 0;
						$acumuladoMontoACobrar = 0;
						$acumuladoCobradoCompleto = 0;
						$acumuladoAbono = 0;
						$acumuladoProntoPago = 0;
						$acumuladoPorCobrar = 0; 
						foreach ($nivel as $cuota): ?>
							<tr class="colorBordesTabla">
								<td <?= $estilosReportes[$tipo_reporte]["totales"] ?>></td>
								<td <?= $estilosReportes[$tipo_reporte]["contadorLinea"] ?>><?= $contador_transacciones ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["nombreEstudiante"] ?>><?= $cuota["nombre_estudiante"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["grado"] ?>><?= $cuota["grado"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["beca"] ?>><?= $cuota["porcentaje_descuento"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["cantidadEstudiantes"] ?>><?= $cuota["cantidad_estudiantes"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["quePagaron"] ?>><?= $cuota["que_pagaron"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["porPagar"] ?>><?= $cuota["por_pagar"] ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["montoACobrar"] ?>><?= number_format($cuota["monto_cuota"], 2, ",", ".") ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["cobradoCompleto"] ?>><?= number_format($cuota["cobrado_completo"], 2, ",", ".") ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["abono"] ?>><?= number_format($cuota["abono"], 2, ",", ".") ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["prontoPago"] ?>><?= number_format($cuota["pronto_pago"], 2, ",", ".") ?></td>
								<td <?= $estilosReportes[$tipo_reporte]["porCobrar"] ?>><?= number_format($cuota["por_cobrar_cuota"], 2, ",", ".") ?></td>
							</tr>  
							<?php 
							$contador_transacciones++; 
							$acumuladoCantidadEstudiantes += $cuota["cantidad_estudiantes"];
							$acumuladoQuePagaron += $cuota["que_pagaron"];
							$acumuladoPorPagar += $cuota["por_pagar"];
							$acumuladoMontoACobrar += $cuota["monto_cuota"];
							$acumuladoCobradoCompleto += $cuota["cobrado_completo"];
							$acumuladoAbono += $cuota["abono"];
							$acumuladoProntoPago += $cuota["pronto_pago"];
							$acumuladoPorCobrar += $cuota["por_cobrar_cuota"]; 
						endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td <?= $estilosReportes[$tipo_reporte]["totales"] ?>>Totales</td>
							<td <?= $estilosReportes[$tipo_reporte]["contadorLinea"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["nombreEstudiante"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["grado"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["beca"] ?>>Totales</td>
							<td <?= $estilosReportes[$tipo_reporte]["cantidadEstudiantes"] ?>><?= $acumuladoCantidadEstudiantes ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["quePagaron"] ?>><?= $acumuladoQuePagaron ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["porPagar"] ?>><?= $acumuladoPorPagar ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["montoACobrar"] ?>><?= number_format($acumuladoMontoACobrar, 2, ",", ".") ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["cobradoCompleto"] ?>><?= number_format($acumuladoCobradoCompleto, 2, ",", ".") ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["abono"] ?>><?= number_format($acumuladoAbono, 2, ",", ".") ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["prontoPago"] ?>><?= number_format($acumuladoProntoPago, 2, ",", ".") ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["porCobrar"] ?>><?= number_format($acumuladoPorCobrar, 2, ",", ".") ?></td>
						</tr>  	
						<tr>
							<td <?= $estilosReportes[$tipo_reporte]["totales"] ?>>Porcentajes</td>
							<td <?= $estilosReportes[$tipo_reporte]["contadorLinea"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["nombreEstudiante"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["grado"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["beca"] ?>>Porcentajes</td>
							<td <?= $estilosReportes[$tipo_reporte]["cantidadEstudiantes"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["quePagaron"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["porPagar"] ?>></td>
							<td <?= $estilosReportes[$tipo_reporte]["montoACobrar"] ?>><?= "100,00%" ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["cobradoCompleto"] ?>><?= number_format(round(($acumuladoCobradoCompleto/$acumuladoMontoACobrar)*100, 2), 2, ",", ".")."%" ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["abono"] ?>><?= number_format(round(($acumuladoAbono/$acumuladoMontoACobrar)*100, 2), 2, ",", ".")."%" ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["prontoPago"] ?>><?= number_format(round(($acumuladoProntoPago/$acumuladoMontoACobrar)*100, 2), 2, ",", ".")."%" ?></td>
							<td <?= $estilosReportes[$tipo_reporte]["porCobrar"] ?>><?= number_format(round(($acumuladoPorCobrar/$acumuladoMontoACobrar)*100, 2), 2, ",", ".")."%" ?></td>
						</tr>  					
					</tfoot>
				</table>
			</div>
		<?php 
		endforeach ?>
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