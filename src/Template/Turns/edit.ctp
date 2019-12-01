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
<div class="container" name="edit" id="edit" style="font-size: 12px; line-height: 14px;">
    <div class="row">
        <div class="col-md-12">
			<br />
			<div>
				<table style="width:100%">
					<tbody>
						<tr>
							<td>Unidad Educativa Colegio</td>
						</tr>
						<tr>
							<td><b>"San Gabriel Arcángel C.A."</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>	
						<tr>
							<td><b>Turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $cajero ?></b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>							
						<tr>
							<td><b>Tasa Oficial Dólar: <?= number_format($tasaDolar, 2, ",", ".") ?> - Tasa Oficial Euro: <?= number_format($tasaEuro, 2, ",", ".") ?></b></td>
						</tr>							
						<tr>
							<td>&nbsp;</td>
						</tr>						
					</tbody>
				</table>
			</div>
			<div>					
				<div>
					<br />
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<td style="font-size: 14px; line-height: 16px;"><b>RECIBIDO EN:</b></td>
									</tr>	
									<tr>
										<th><b>Concepto</th>
										<th style="text-align: center;"><b>Efvo $</b></th>
										<th style="text-align: center;"><b>Efvo €</b></th>
										<th style="text-align: center;"><b>Efvo Bs.</b></th>
										<th style="text-align: center;"><b>Zelle $</b></th>
										<th style="text-align: center;"><b>TDB/TDC Bs.</b></th>
										<th style="text-align: center;"><b>Trans Bs.</b></th>
										<th style="text-align: center;"><b>Dep Bs.</b></th>
										<th style="text-align: center;"><b>Chq Bs.</b></th>
									</tr>
								</thead>
								<tbody>				
									<?php foreach ($vectorTotalesRecibidos as $clave => $recibido):  
										if ($clave == 'Total recibido de ' . $cajero || $clave == "Diferencia"): ?>
											<tr>
												<td><?= $clave ?></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr> 
										<?php elseif ($clave == 'Total facturas + anticipos de inscripción + servicio educativo' || 
											$clave == "Total a recibir de " . $cajero): ?>
											<tr>
												<td><b><?= $clave ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></b></td>
											</tr>											
										<?php else: ?>
											<tr>
												<td><?= $clave ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></td>
											</tr>
										<?php endif; 
									endforeach; ?>
									<tr>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br />
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<td style="font-size: 14px; line-height: 16px;"><b>RESUMEN GENERAL FORMAS DE PAGO:</b></td>
									</tr>	
									<tr>
										<th><b>Forma de pago</th>
										<th style="text-align: center;"><b>Moneda</b></th>
										<th style="text-align: center;"><b>Monto</b></th>
										<th style="text-align: center;"><b>Equivalente en Bs.</b></th>
									</tr>
								</thead>
								<tbody>				
									<?php foreach ($totalFormasPago as $clave => $forma): ?> 
										<?php if ($clave == "Total general cobrado Bs."): ?>
											<tr>
												<td><b><?= $clave ?></b></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($forma['montoBs'], 2, ",", ".") ?></b></td>
											</tr>
										<?php else: ?>
											<tr>
												<td><?= $clave ?></td>
												<td style="text-align: center;"><?= $forma['moneda'] ?></td>
												<td style="text-align: center;"><?= number_format($forma['monto'], 2, ",", ".") ?></td>
												<td style="text-align: center;"><?= number_format($forma['montoBs'], 2, ",", ".") ?></td>
											</tr>
										<?php endif; ?>
									<?php endforeach; ?>
									<tr>
										<td><b>Más facturas compensadas</b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralCompensado, 2, ",", ".") ?></b></td>
									</tr>
									<tr>
										<td><b>Total general cobrado + facturas compensadas</b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalFormasPago['Total general cobrado Bs.']['montoBs'] + $totalGeneralCompensado, 2, ",", ".") ?></b></td>
									</tr>
									<tr>
										<td><b>Total general Facturado</b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralFacturado, 2, ",", ".") ?></b></td>
									</tr>
									<tr>
										<td><b>Diferencia por redondeo en conversión de divisas </b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalGeneralFacturado - $totalFormasPago['Total general cobrado Bs.']['montoBs'] , 2, ",", ".") ?></b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<br />
					<br />
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#edit").table2excel({
		
				exclude: ".noExl",
			
				name: "edit",
			
				filename: $('#edit').attr('name') 
		
			});
		});
    });
        
</script>