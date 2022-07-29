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
    .noVerImpreso
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
<div class="container" name="previo_cierre" id="previo-cierre" style="font-size: 12px; line-height: 14px;">
    <div class="row">
		<br />
        <div class="col-md-12">
			<div>
				<div class="row">
					<div class="col-md-12">					
						<table>
							<thead>
								<tr>
									<th style="font-size: 14px; line-height: 16px;"><b>TURNO NO CERRADO</b></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>		
            <div class="row">
                <div class="col-md-12">
                    <h3 id="Turno" value=<?= $turn->id ?>><b>Cerrar Turno: <?= $turn->turn ?></b></h3>
                    <h4>Fecha: <?= $turn->start_date->format('d-m-Y') ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h4>
                </div>
            </div>
			<div id='factura-control' class='row noVerImpreso'>
				<div class="col-md-3">
					<p>Por favor introduzca el Nro. de control de la factura <b><?= $lastNumber ?></b></p>	
					<?= $this->Form->input('control_number', ['label' => 'Nro. Control:']) ?>
					<button id="verificar" class="btn btn-success">Verificar si se saltó el número de control</button>
				</div>
			</div>
            <br />
			<div id="contadores" style="font-size: 10px; line-height: 12px;">
				<div>
					<table style="width:100%; font-size: 14px; line-height: 16px;">
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
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th style="font-size: 18px; line-height: 20px;"><b>PAGOS FISCALES</b></th>
										</tr>
										<tr>
											<th>&nbsp;</th>
										</tr>
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>&nbsp;&nbsp;&nbsp;RECIBIDO EN:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>			
					<div>
						<br />
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>	
										<tr>
											<th><b>Concepto</th>
											<th style="text-align: center;"><b>Efvo $</b></th>
											<th style="text-align: center;"><b>Efvo €</b></th>
											<th style="text-align: center;"><b>Efvo Bs.</b></th>
											<th style="text-align: center;"><b>Zelle $</b></th>
											<th style="text-align: center;"><b>Euros €</b></th>
											<th style="text-align: center;"><b>TDB/TDC Bs.</b></th>
											<th style="text-align: center;"><b>Trans Bs.</b></th>
											<th style="text-align: center;"><b>Dep Bs.</b></th>
											<th style="text-align: center;"><b>Chq Bs.</b></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($vectorTotalesRecibidos as $clave => $recibido):
											if ($clave == "Menos reintegros"):
												$reintegroEfectivoDolar = $recibido['Efectivo $'];
												$reintegroEfectivoEuro = $recibido['Efectivo €'];
												$reintegroEfectivoBolivar = $recibido['Efectivo Bs.'];
												$reintegroZelle = $recibido['Zelle $'];
												if (isset($recibido['Euros €'])):
													$reintegroEuros = $recibido['Euros €'];
												else:
													$reintegroEuros = 0;
												endif;
												$reintegroTdbTdc = $recibido['TDB/TDC Bs.'];
												$reintegroTransferencia = $recibido['Transferencia Bs.'];
												$reintegroDeposito = $recibido['Depósito Bs.'];
												$reintegroCheque = $recibido['Cheque Bs.'];										
											else:
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
														<td></td>
													</tr> 
												<?php elseif ($clave == 'Total facturas + anticipos de inscripción'): ?> 												
													<tr>
														<td><b><?= $clave ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></b></td>
														<?php if (isset($recibido['Euros €'])): ?>
															<td style="text-align: center;"><b><?= number_format($recibido['Euros €'], 2, ",", ".") ?></b></td>
														<?php else: ?>
															<td style="text-align: center;"><b><?= "0,00" ?></b></td>
														<?php endif; ?>
														<td style="text-align: center;"><b><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></b></td>
													</tr>		
												<?php elseif ($clave == "Total a recibir de " . $cajero): ?>
													<tr>
														<td><b><?= $clave ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo $'] - $reintegroEfectivoDolar, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo €'] - $reintegroEfectivoEuro, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Efectivo Bs.'] - $reintegroEfectivoBolivar, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Zelle $'] - $reintegroZelle, 2, ",", ".") ?></b></td>
														<?php if (isset($recibido['Euros €'])): ?>
															<td style="text-align: center;"><b><?= number_format($recibido['Euros €'] - $reintegroEuros, 2, ",", ".") ?></b></td>
														<?php else: ?>
															<td style="text-align: center;"><b><?= "0,00" ?></b></td>
														<?php endif; ?>
														<td style="text-align: center;"><b><?= number_format($recibido['TDB/TDC Bs.'] - $reintegroTdbTdc, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Transferencia Bs.'] - $reintegroTransferencia, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Depósito Bs.'] - $reintegroDeposito, 2, ",", ".") ?></b></td>
														<td style="text-align: center;"><b><?= number_format($recibido['Cheque Bs.'] - $reintegroCheque, 2, ",", ".") ?></b></td>
													</tr>														
												<?php else: ?>
													<tr>
														<td><?= $clave ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></td>
														<?php if (isset($recibido['Euros €'])): ?>
															<td style="text-align: center;"><?= number_format($recibido['Euros €'], 2, ",", ".") ?></td>
														<?php else: ?>
															<td style="text-align: center;"><?= "0,00" ?></td>
														<?php endif; ?>													
														<td style="text-align: center;"><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></td>
													</tr>
												<?php endif;
											endif;
										endforeach; ?>	
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<?php for ($i = 1; $i <= 20; $i++): ?>
											<tr>
												<th>&nbsp;</th>
											</tr>
										<?php endfor; ?>									
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>RESUMEN GENERAL DE FORMAS DE PAGO:</b></th>
										</tr>	
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th><b>Forma de pago</th>
											<th style="text-align: center;"><b>Moneda</b></th>
											<th style="text-align: center;"><b>Monto</b></th>
											<th style="text-align: center;"><b>Bs.</b></th>
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
											<td style="text-align: center;">$</td>
											<td style="text-align: center;"><b><?= number_format(round($totalGeneralCompensado / $tasaDolar, 2), 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalGeneralCompensado, 2, ",", ".") ?></b></td>
										</tr>
										<tr>
											<td><b>Menos sobrantes (vueltos pendientes por entregar)</b></td>
											<td style="text-align: center;">$</td>
											<td style="text-align: center;"><b><?= number_format($totalGeneralSobrantes, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format(round($totalGeneralSobrantes * $tasaDolar, 2), 2, ",", ".") ?></b></td>
										</tr>	
										<tr>
											<td><b>Menos reintegros de sobrantes de este turno</b></td>
											<td style="text-align: center;">$</td>
											<td style="text-align: center;"><b><?= number_format($totalGeneralReintegrosSobrantes, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format(round($totalGeneralReintegrosSobrantes * $tasaDolar, 2), 2, ",", ".") ?></b></td>
										</tr>											
										<tr>
											<td><b>Total general cobrado + facturas compensadas - sobrantes (vueltos pendientes por entregar) - reintegros de sobrantes de este turno</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalFormasPago['Total general cobrado Bs.']['montoBs'] + $totalGeneralCompensado - round($totalGeneralSobrantes * $tasaDolar, 2) - round($totalGeneralReintegrosSobrantes * $tasaDolar, 2), 2, ",", ".") ?></b></td>
										</tr>
										<tr>
											<td><b>Total general Facturado</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalGeneralFacturado, 2, ",", ".") ?></b></td>
										</tr>
										<tr>
											<td><b>Menos descuentos más recargos</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalDescuentosRecargos, 2, ",", ".") ?></b></td>
										</tr>
										<tr>
											<td><b>Diferencia (Redondeos y otras diferencias)  </b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format(($totalGeneralFacturado + $totalDescuentosRecargos) - ($totalFormasPago['Total general cobrado Bs.']['montoBs'] + $totalGeneralCompensado - round($totalGeneralSobrantes * $tasaDolar, 2) - round($totalGeneralReintegrosSobrantes * $tasaDolar, 2)), 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="saltopagina">
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 18px; line-height: 20px;"><b>SERVICIO EDUCATIVO</b></th>
										</tr>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th>&nbsp;</th>
										</tr>	
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Ctrol / Fact</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Fact $</b></th>
											<th style="text-align: center;"><b>Fact Bs.</b></th>
											<th style="text-align: center;"><b>Desc / Rec</b></th>
											<th style="text-align: center;"><b>Tasa $ / €</b></th>
											<th style="text-align: center;"><b>E $</b></th>
											<th style="text-align: center;"><b>E €</b></th>
											<th style="text-align: center;"><b>E Bs.</b></th>
											<th style="text-align: center;"><b>Zel $</b></th>
											<th style="text-align: center;"><b>Eur €</b></th>
											<th style="text-align: center;"><b>TD/TC Bs.</b></th>
											<th style="text-align: center;"><b>Trans Bs.</b></th>
											<th style="text-align: center;"><b>Dep Bs.</b></th>
											<th style="text-align: center;"><b>Chq Bs.</b></th>
											<th style="text-align: center;"><b>Tot Cob. Bs.</b></th>
											<th style="text-align: center;"><b>Comp Bs.</b></th>
											<th style="text-align: center;"><b>Dif Bs.</b></th>
											<th style="text-align: center;"><b>TCM</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $cobradoBolivares = 0;  
										$totalCobradoBolivares = 0;  
										$totalFacturaDolar = 0;  
										$totalFacturaBolivar = 0; 
										$totalDescuentosRecargosSE = 0;
										$totalEfectivoDolar = 0;
										$totalEfectivoEuro = 0;
										$totalEfectivoBolivar = 0;
										$totalZelle = 0;
										$totalEuros = 0;
										$totalTdbTdc = 0;
										$totalTransferencias = 0;
										$totalDepositos = 0;
										$totalCheques = 0;
										$compensado = 0;
										$totalCompensado = 0;
										$diferencia = 0;
										$totalDiferencia = 0;
										foreach ($vectorPagos as $pago): 
											$transferenciaDestiempo = "";
											$cuotasAlumnoBecado = "";
											$cambioMontoCuota = "";
											if ($pago['tipoDocumento'] == "Recibo de servicio educativo"): ?>
												<tr>
													<td><?= $pago['familia']; ?></td>
													<td style="text-align: center;"><?= $pago['nroControl'] . " " . $pago['nroFactura']; ?></td>
													<td style="text-align: center;">R</td>
													<td style="text-align: center;"><?= number_format(round($pago['totalFacturaDolar'], 2), 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['totalFacturaBolivar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['descuentoRecargo'])): ?>
														<td style="text-align: center;"><?= number_format($pago['descuentoRecargo'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;">0,00</td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tasaDolar'], 2, ",", ".") . " " . number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['euros'])): ?>
														<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;"><?= "0,00" ?></td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
													<td style="text-align: center;"><?= number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
													<?php $cobradoBolivares = 
														round(($pago['efectivoDolar'] + $pago['zelleDolar']) * $pago['tasaDolar'], 2) +
														round($pago['efectivoEuro'] * $pago['tasaEuro'], 2) +
														$pago['efectivoBolivar'] + 
														$pago['tddTdcBolivar'] + 
														$pago['transferenciaBolivar'] +
														$pago['depositoBolivar'] +
														$pago['chequeBolivar']; 
														if (isset($pago['euros'])): 
															$cobradoBolivares += round($pago['euros'] * $pago['tasaEuro'], 2); 
														endif; ?>														
													<td style="text-align: center;"><?= number_format($cobradoBolivares, 2, ",", ".") ?></td>
													<?php $compensado = round($pago['compensadoDolar'] * $pago['tasaDolar'], 2); ?>
													<td style="text-align: center;"><?= number_format($compensado, 2, ",", ".") ?></td>
													<?php if (isset($pago['descuentoRecargo'])):
														$diferencia = ($pago['totalFacturaBolivar'] + $pago['descuentoRecargo']) - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));
													else: 
														$diferencia = $pago['totalFacturaBolivar'] - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));													
													endif; ?>
													<td style="text-align: center;"><?= number_format($diferencia, 2, ",", ".") ?></td>	
													<?php if (isset($pago['tasaTemporalDolar'])):
														if ($pago['tasaTemporalDolar'] == 1):
															$transferenciaDestiempo = "T";
														endif;
													endif;
													if (isset($pago['tasaTemporalEuro'])):
														if ($pago['tasaTemporalEuro'] == 1):
															$transferenciaDestiempo = "T";
														endif;
													endif;
													if (isset($pago['cuotasAlumnoBecado'])):
														if ($pago['cuotasAlumnoBecado'] > 0):
															$cuotasAlumnoBecado = "C";
														endif;
													endif;
													if (isset($pago['cambioMontoCuota'])):
														if ($pago['cambioMontoCuota'] == 1):
															$cambioMontoCuota = "M";
														endif;
													endif; ?>
													<td style="text-align: center;"><?= $transferenciaDestiempo . $cuotasAlumnoBecado . $cambioMontoCuota; ?></td>
												</tr>
												<?php $totalFacturaDolar += $pago['totalFacturaDolar']; 
												$totalFacturaBolivar += $pago['totalFacturaBolivar']; 
												$totalEfectivoDolar += $pago['efectivoDolar'];
												if (isset($pago['descuentoRecargo'])): 
													$totalDescuentosRecargosSE += $pago['descuentoRecargo'];
												endif;
												$totalEfectivoEuro += $pago['efectivoEuro'];
												$totalEfectivoBolivar += $pago['efectivoBolivar'];
												$totalZelle += $pago['zelleDolar'];
												if (isset($pago['euros'])): 
													$totalEuros += $pago['euros'];
												endif; 
												$totalTdbTdc += $pago['tddTdcBolivar'];
												$totalTransferencias += $pago['transferenciaBolivar'];
												$totalDepositos += $pago['depositoBolivar'];
												$totalCheques += $pago['chequeBolivar'];
												$totalCobradoBolivares += $cobradoBolivares;
												$totalCompensado += $compensado;
												$totalDiferencia += $diferencia;
											endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalFacturaDolar, 2, ",", ".") ?></b></td>	
											<td style="text-align: center;"><b><?= number_format($totalFacturaBolivar, 2, ",", ".") ?></b></td>												
											<td style="text-align: center;"><b><?= number_format($totalDescuentosRecargosSE, 2, ",", ".") ?></b></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoEuro, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoBolivar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEuros, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTdbTdc, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTransferencias, 2, ",", ".") ?></b></td>										
											<td style="text-align: center;"><b><?= number_format($totalDepositos, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCheques, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCobradoBolivares, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCompensado, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalDiferencia, 2, ",", ".") ?></b></td>	
											<td></td>												
										</tr>
										<tr>
											<td><i>Leyenda: T = Transferencia destiempo, C = Convenio y M = Cambio monto cuota</i></td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>				
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="saltopagina">
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS Y ANTICIPOS DE INSCRIPCIÓN:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Ctrol / Fact</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Fact $</b></th>
											<th style="text-align: center;"><b>Fact Bs.</b></th>
											<th style="text-align: center;"><b>Desc / Rec</b></th>
											<th style="text-align: center;"><b>Tasa $ / €</b></th>
											<th style="text-align: center;"><b>E $</b></th>
											<th style="text-align: center;"><b>E €</b></th>
											<th style="text-align: center;"><b>E Bs.</b></th>
											<th style="text-align: center;"><b>Zel $</b></th>
											<th style="text-align: center;"><b>Eur €</b></th>
											<th style="text-align: center;"><b>TD/TC Bs.</b></th>
											<th style="text-align: center;"><b>Trans Bs.</b></th>
											<th style="text-align: center;"><b>Dep Bs.</b></th>
											<th style="text-align: center;"><b>Chq Bs.</b></th>
											<th style="text-align: center;"><b>Tot Cob. Bs.</b></th>
											<th style="text-align: center;"><b>Comp Bs.</b></th>
											<th style="text-align: center;"><b>Dif Bs.</b></th>
											<th style="text-align: center;"><b>TCM</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $cobradoBolivares = 0; 
										$totalCobradoBolivares = 0;
										$totalFacturaDolar = 0;
										$totalFacturaBolivar = 0; 
										$totalEfectivoDolar = 0;
										$totalEfectivoEuro = 0;
										$totalEfectivoBolivar = 0;
										$totalZelle = 0;
										$totalEuros = 0;
										$totalTdbTdc = 0;
										$totalTransferencias = 0;
										$totalDepositos = 0;
										$totalCheques = 0;
										$compensado = 0;
										$totalCompensado = 0;
										$diferencia = 0;
										$totalDiferencia = 0;
										$totalDescuentosRecargosFA = 0;
										foreach ($vectorPagos as $pago): 
											$transferenciaDestiempo = "";
											$cuotasAlumnoBecado = "";
											$cambioMontoCuota = "";
											$facturaDeAnticipo = 0;
											if (isset($pago['facturaDeAnticipo'])):
												$facturaDeAnticipo = $pago['facturaDeAnticipo'];
											endif;
											if ($facturaDeAnticipo == 0):
												if ($pago['tipoDocumento'] == "Factura" || $pago['tipoDocumento'] == "Recibo de anticipo"): ?> 
													<tr>
														<td><?= $pago['familia']; ?></td>
														<td style="text-align: center;"><?= $pago['nroControl'] . " " . $pago['nroFactura']; ?></td>
														<?php if ($pago['tipoDocumento'] == "Factura"): ?>
															<td style="text-align: center;">F</td>
														<?php else: ?>
															<td style="text-align: center;">R</td>
														<?php endif; ?>
														<td style="text-align: center;"><?= number_format(round($pago['totalFacturaDolar'], 2), 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['totalFacturaBolivar'], 2, ",", ".") ?></td>
														<?php if (isset($pago['descuentoRecargo'])): ?>
															<td style="text-align: center;"><?= number_format($pago['descuentoRecargo'], 2, ",", ".") ?></td>
														<?php else: ?>
															<td style="text-align: center;">0,00</td>
														<?php endif; ?>
														<td style="text-align: center;"><?= number_format($pago['tasaDolar'], 2, ",", ".") . " " . number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
														<?php if (isset($pago['euros'])): ?>
															<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".") ?></td>
														<?php else: ?>
															<td style="text-align: center;"><?= "0,00" ?></td>
														<?php endif; ?>
														<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
														<td style="text-align: center;"><?= number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
														<td style="text-align: center;"><?= number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
														<?php $cobradoBolivares = 
															round(($pago['efectivoDolar'] + $pago['zelleDolar']) * $pago['tasaDolar'], 2) +
															round($pago['efectivoEuro'] * $pago['tasaEuro'], 2) +
															$pago['efectivoBolivar'] + 
															$pago['tddTdcBolivar'] + 
															$pago['transferenciaBolivar'] +
															$pago['depositoBolivar'] +
															$pago['chequeBolivar']; 
															if (isset($pago['euros'])): 
																$cobradoBolivares += round($pago['euros'] * $pago['tasaEuro'], 2); 
															endif; ?>														
														<td style="text-align: center;"><?= number_format($cobradoBolivares, 2, ",", ".") ?></td>
														<?php $compensado = round($pago['compensadoDolar'] * $pago['tasaDolar'], 2); ?>
														<td style="text-align: center;"><?= number_format($compensado, 2, ",", ".") ?></td>
														<?php if (isset($pago['descuentoRecargo'])):
															$diferencia = ($pago['totalFacturaBolivar'] + $pago['descuentoRecargo']) - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));
														else: 
															$diferencia = $pago['totalFacturaBolivar'] - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));													
														endif; ?>
														<td style="text-align: center;"><?= number_format($diferencia, 2, ",", ".") ?></td>
														<?php if (isset($pago['tasaTemporalDolar'])):
															if ($pago['tasaTemporalDolar'] == 1):
																$transferenciaDestiempo = "T";
															endif;
														endif;
														if (isset($pago['tasaTemporalEuro'])):
															if ($pago['tasaTemporalEuro'] == 1):
																$transferenciaDestiempo = "T";
															endif;
														endif;
														if (isset($pago['cuotasAlumnoBecado'])):
															if ($pago['cuotasAlumnoBecado'] > 0):
																$cuotasAlumnoBecado = "C";
															endif;
														endif;
														if (isset($pago['cambioMontoCuota'])):
															if ($pago['cambioMontoCuota'] == 1):
																$cambioMontoCuota = "M";
															endif;
														endif; ?>
														<td style="text-align: center;"><?= $transferenciaDestiempo . $cuotasAlumnoBecado . $cambioMontoCuota; ?></td>
													</tr>
													<?php $totalFacturaDolar += $pago['totalFacturaDolar'];  
													$totalFacturaBolivar += $pago['totalFacturaBolivar']; 
													if (isset($pago['descuentoRecargo'])): 
														$totalDescuentosRecargosFA += $pago['descuentoRecargo'];
													endif;
													$totalEfectivoDolar += $pago['efectivoDolar'];
													$totalEfectivoEuro += $pago['efectivoEuro'];
													$totalEfectivoBolivar += $pago['efectivoBolivar'];
													$totalZelle += $pago['zelleDolar'];
													if (isset($pago['euros'])):
														$totalEuros += $pago['euros'];
													endif; 
													$totalTdbTdc += $pago['tddTdcBolivar'];
													$totalTransferencias += $pago['transferenciaBolivar'];
													$totalDepositos += $pago['depositoBolivar'];
													$totalCheques += $pago['chequeBolivar'];
													$totalCobradoBolivares += $cobradoBolivares;
													$totalCompensado += $compensado;
													$totalDiferencia += $diferencia;
												endif;
											endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalFacturaDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalFacturaBolivar, 2, ",", ".") ?></b></td>												
											<td style="text-align: center;"><b><?= number_format($totalDescuentosRecargosFA, 2, ",", ".") ?></b></td>	
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoEuro, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoBolivar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEuros, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTdbTdc, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTransferencias, 2, ",", ".") ?></b></td>										
											<td style="text-align: center;"><b><?= number_format($totalDepositos, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCheques, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCobradoBolivares, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalCompensado, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalDiferencia, 2, ",", ".") ?></b></td>
											<td></td>											
										</tr>
										<tr>
											<td><i>Leyenda: T = Transferencia destiempo, C = Convenio y M = Cambio monto cuota</i></td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>			
					<?php if ($indicadorReintegros == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE REINTEGROS:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>No Recibo</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto $</b></th>
												<th style="text-align: center;"><b>Monto €</b></th>
												<th style="text-align: center;"><b>Monto Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalDolar = 0;
											$totalEuro = 0;
											$totalBolivar = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Recibo de reintegro"): ?> 
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<?php if ($factura->moneda_id == 1):
															$totalBolivar += $factura->amount_paid; ?>
															<td></td><td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
														<?php elseif ($factura->moneda_id == 2):
															$totalDolar += $factura->amount_paid; ?>
															<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td><td></td>
														<?php else:
															$totalEuro += $factura->amount_paid; ?>
															<td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td>
														<?php endif; ?>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalDolar, 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalEuro, 2, ",", ".") ?></b></td>											
												<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorCompras == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE COMPRAS:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>No Recibo</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto $</b></th>
												<th style="text-align: center;"><b>Monto €</b></th>
												<th style="text-align: center;"><b>Monto Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalDolar = 0;
											$totalEuro = 0;
											$totalBolivar = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Recibo de compra"): ?> 
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<?php if ($factura->moneda_id == 1):
															$totalBolivar += $factura->amount_paid; ?>
															<td></td><td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
														<?php elseif ($factura->moneda_id == 2):
															$totalDolar += $factura->amount_paid; ?>
															<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td><td></td>
														<?php else:
															$totalEuro += $factura->amount_paid; ?>
															<td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td>
														<?php endif; ?>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalDolar, 2, ",", ".") ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalEuro, 2, ",", ".") ?></b></td>											
												<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorNotasCredito == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE CRÉDITO:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>Control</b></th>
												<th style="text-align: center;"><b>Factura</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalBolivar = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Nota de crédito"): ?> 
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->control_number ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<?php $totalBolivar += $factura->amount_paid; ?>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorNotasDebito == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE DÉBITO:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>Control</b></th>
												<th style="text-align: center;"><b>Factura</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalBolivar = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Nota de débito"): ?>
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->control_number ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<?php $totalBolivar += $factura->amount_paid; ?>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorFacturasRecibos == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS CORRESPONDIENTES A ANTICIPOS:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>Control</b></th>
												<th style="text-align: center;"><b>Factura</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalBolivar = 0;
											foreach ($facturas as $factura):  
												if ($factura->id_anticipo > 0): ?>
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->control_number ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<?php $totalBolivar += $factura->amount_paid; ?>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorSobrantes == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE SOBRANTES (VUELTOS PENDIENTES POR ENTREGAR):</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>Recibo</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Monto $.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Recibo de sobrante"): ?>
													<tr>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->control_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalGeneralSobrantes, 2, ",", ".") ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorFacturasAnuladas == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS ANULADAS:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Control</b></th>
												<th style="text-align: center;"><b>Factura</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalBolivar = 0;
											foreach ($documentosAnulados as $anulado):  
												if ($anulado->fiscal == 1): ?> 
													<tr>
														<td style="text-align: center;"><?= $anulado->control_number ?></td>
														<td style="text-align: center;"><?= $anulado->bill_number ?></td>
														<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($indicadorRecibosAnulados == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS ANULADOS:</b></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th style="text-align: center;"><b>Recibo</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php $totalBolivar = 0;
											foreach ($documentosAnulados as $anulado):  
												if ($anulado->fiscal == 0): ?> 
													<tr>
														<td style="text-align: center;"><?= $anulado->control_number ?></td>
														<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
							
				<div class="row noVerImpreso">
					<div class="col-md-12">
						<?= $this->Form->create($turn) ?>
							<fieldset>
							</fieldset>
							<?= $this->Form->button(__('Cerrar turno'), ['id' => 'cerrar-turno', 'class' =>'btn btn-success']) ?>
						<?= $this->Form->end() ?>
						<br />
						<br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
		if ('<?= $lastNumber ?>' == 0)
		{
			$('#factura-control').addClass('noverScreen');
		}
		else
		{
			$('#contadores').addClass('noverScreen');
			$('#cerrar-turno').addClass('noverScreen');
		}
		$('#verificar').click(function(e) 
        {
			if ($('#control-number').val() == '<?= $lastControl ?>')
			{
				alert('Felicidades ! Los números de control están correctos, puede continuar con el cierre de turno')
				$('#factura-control').addClass('noverScreen');
				$('#contadores').removeClass('noverScreen');
				$('#cerrar-turno').removeClass('noverScreen');
			}
			else
			{
				$.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "editControl"]); ?>', {turn : '<?= $turn->id ?>'});
			}
		});
	
		$("#exportar-excel").click(function(){
			
			$("#previo-cierre").table2excel({
		
				exclude: ".noExl",
			
				name: "previo_cierre",
			
				filename: $('#previo-cierre').attr('name') 
		
			});
		});
    });
        
</script>