<?php
    use Cake\Routing\Router; 
	$tipo_usuario = 0;
	if ($current_user['role'] == 'Seniat' || $current_user['role'] == 'Ventas fiscales' || $current_user['role'] == 'Contabilidad fiscal' ):
		$tipo_usuario = 1;
	endif;
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
<div name="reporte_cierre" id="reporte-cierre" class="container" style="font-size: 12px; line-height: 14px;">
	<br />
    <div class="row">
        <div class="col-md-12">
			<!-- Encabezado -->
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

			<!-- Documentos fiscales -->
			<div>	
				<!-- Pagos fiscales -->
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th style="font-size: 18px; line-height: 20px;"><b>PAGOS FISCALES DEL <?= $turn->start_date->format('d-m-Y') ?></b></th>
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
											<?php 
											elseif ($clave == 'Total facturas + anticipos de inscripción'): ?>
												<tr>
													<?php
													if ($tipo_usuario == 0): ?> 												
														<td><b><?= $clave ?></b></td>
													<?php 
													else: ?>
														<td><b>Total facturas</b></td>
													<?php
													endif; ?>
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
											<?php 
											elseif ($clave == "Total a recibir de " . $cajero): ?>
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
											<?php 
											else: 
												if ($tipo_usuario == 0): ?>
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
												<?php
												else: 
													if ($clave != "Anticipos de inscripción" && $clave != "Menos compras" && $clave != "Más vueltos de compras"): ?>
														<tr>
															<?php
															if ($clave == "Total facturas - notas de crédito + anticipos de inscripción"): ?>
																<td>Total facturas - notas de crédito</td>
															<?php
															else: ?>	
																<td><?= $clave ?></td>
															<?php 
															endif; ?>
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
													<?php
													endif; ?>
												<?php
												endif; ?>
											<?php 
											endif;
										endif;
									endforeach; ?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Resumen general formas de pago -->
				<div class="saltopagina">
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<?php for ($i = 1; $i <= 2; $i++): ?>
										<tr>
											<th>&nbsp;</th>
										</tr>
									<?php endfor; ?>									
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b>RESUMEN GENERAL DE FORMAS DE PAGO DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
										<td><b>Diferencia (Redondeos, IGTF y otras diferencias)  </b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format(($totalGeneralFacturado + $totalDescuentosRecargos) - ($totalFormasPago['Total general cobrado Bs.']['montoBs'] + $totalGeneralCompensado - round($totalGeneralSobrantes * $tasaDolar, 2) - round($totalGeneralReintegrosSobrantes * $tasaDolar, 2)), 2, ",", ".") ?></b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Detalle de facturas y anticipos de inscripción -->
				<div class="saltopagina">
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<?php 
										if ($tipo_usuario == 0): ?>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS Y ANTICIPOS DE INSCRIPCIÓN DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
										<?php
										else: ?>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
										<?php
										endif; ?>
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
													<td style="text-align: center;"><?= number_format($pago['totalFacturaDolar'], 2, ",", ".")."<br />".number_format($pago['montoIgtfFacturaDolar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['totalFacturaBolivar'], 2, ",", ".")."<br />".number_format($pago['montoIgtfFacturaBolivar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['descuentoRecargo'])): ?>
														<td style="text-align: center;"><?= number_format($pago['descuentoRecargo'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;">0,00</td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tasaDolar'], 2, ",", ".") . " " . number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoDolar'], 2, ",", ".")."<br />".number_format($pago['IGTFefectivoDolar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoEuro'], 2, ",", ".")."<br />".number_format($pago['IGTFefectivoEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoBolivar'], 2, ",", ".")."<br />".number_format($pago['IGTFefectivoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".")."<br />".number_format($pago['IGTFzelleDolar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['euros'])): ?>
														<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".")."<br />".number_format($pago['IGTFeuros'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;"><?= "0,00<br />0,00" ?></td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".")."<br />".number_format($pago['IGTFtddTdcBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".")."<br />".number_format($pago['IGTFtransferenciaBolivar'], 2, ",", ".") ?></td>										
													<td style="text-align: center;"><?= number_format($pago['depositoBolivar'], 2, ",", ".")."<br />".number_format($pago['IGTFdepositoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['chequeBolivar'], 2, ",", ".")."<br />".number_format($pago['IGTFchequeBolivar'], 2, ",", ".") ?></td>
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
													<td style="text-align: center;"><?= number_format($cobradoBolivares, 2, ",", ".")."<br />".number_format($pago['montoIgtfFacturaBolivar'], 2, ",", ".") ?></td>
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

				<?php 
				if ($indicadorNotasCredito == 1 || $indicadorNotasDebito == 1): ?>
					<div class="saltopagina">
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
													<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE CRÉDITO DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
													<th style="text-align: center;"><b>Fecha</b></th>
													<th style="text-align: center;"><b>Control</b></th>
													<th style="text-align: center;"><b>N/C</b></th>
													<th style="text-align: center;"><b>Tipo doc</b></th>
													<th style="text-align: center;"><b>Control Fact Afect</b></th>
													<th style="text-align: center;"><b>Nro. Fact Afect</b></th>
													<th style="text-align: center;"><b>Fecha Fact Afect</b></th>
													<th style="text-align: center;"><b>Monto Bs.</b></th>
												</tr>
											</thead>
											<tbody>				
												<?php $totalBolivar = 0;
												foreach ($facturas as $factura):  
													if ($factura->tipo_documento == "Nota de crédito"): ?> 
														<tr>
															<td><?= $factura->parentsandguardian->family ?></td>
															<td style="text-align: center;"><?= $factura->date_and_time->format('d-m-Y') ?></td>
															<td style="text-align: center;"><?= $factura->control_number ?></td>
															<td style="text-align: center;"><?= $factura->bill_number ?></td>
															<td><?= $factura->tipo_documento ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['controlAfectada'] ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['numeroAfectada'] ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['fechaAfectada']->format('d-m-Y') ?></td>
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
													<td></td>
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
													<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE DÉBITO DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
													<th style="text-align: center;"><b>Fecha</b></th>
													<th style="text-align: center;"><b>Control</b></th>
													<th style="text-align: center;"><b>N/D</b></th>
													<th style="text-align: center;"><b>Tipo doc</b></th>
													<th style="text-align: center;"><b>Control N/C Afect</b></th>
													<th style="text-align: center;"><b>Nro. N/C Afect</b></th>
													<th style="text-align: center;"><b>Fecha N/C Afect</b></th>
													<th style="text-align: center;"><b>Monto Bs.</b></th>
												</tr>
											</thead>
											<tbody>				
												<?php $totalBolivar = 0;
												foreach ($facturas as $factura):  
													if ($factura->tipo_documento == "Nota de débito"): ?>
														<tr>
															<td><?= $factura->parentsandguardian->family ?></td>
															<td style="text-align: center;"><?= $factura->date_and_time->format('d-m-Y') ?></td>
															<td style="text-align: center;"><?= $factura->control_number ?></td>
															<td style="text-align: center;"><?= $factura->bill_number ?></td>
															<td><?= $factura->tipo_documento ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['controlAfectada'] ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['numeroAfectada'] ?></td>
															<td style="text-align: center;"><?= $facturasNotas[$factura->id_documento_padre]['fechaAfectada']->format('d-m-Y') ?></td>
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
													<td></td>
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
					</div>
				<?php 
				endif; ?>

				<?php 
				if ($indicadorReintegros == 1 || $indicadorSobrantes == 1 || $indicadorFacturasRecibos == 1 || $indicadorCompras == 1): ?>
					<div class="saltopagina">
						<?php 
						if ($indicadorReintegros == 1): ?>
							<div>
								<div class="row">
									<div class="col-md-12">					
										<table>
											<thead>
												<tr>
													<th>&nbsp;</th>
												</tr>	
												<tr>
													<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE REINTEGROS DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
						<?php 
						endif; 
						if ($indicadorSobrantes == 1): ?>
							<div>
								<div class="row">
									<div class="col-md-12">					
										<table>
											<thead>
												<tr>
													<th>&nbsp;</th>
												</tr>	
												<tr>
													<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE SOBRANTES (VUELTOS PENDIENTES POR ENTREGAR) DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
						<?php 
						endif; 
						if ($tipo_usuario == 0): 
							if ($indicadorFacturasRecibos == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS CORRESPONDIENTES A ANTICIPOS DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
							<?php 
							endif; 
							if ($indicadorCompras == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE COMPRAS DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
							<?php 
							endif; 
						endif; ?>	
					</div>
				<?php 
				endif;
				if ($tipo_usuario == 0): 
					if ($indicadorFacturasAnuladas == 1 || $indicadorRecibosAnulados == 1): ?>
						<div class="saltopagina">
							<?php 
							if ($indicadorFacturasAnuladas == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS ANULADAS EL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
																<td style="text-align: center;"><?= $numero_control_anulado = $anulado->control_number == 999999 ? "S/N": $anulado->control_number; ?></td>
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
							<?php 
							endif;
							if ($indicadorRecibosAnulados == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS ANULADOS EL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
														if ($anulado->fiscal == 0):  
															if ($anulado->tipo_documento != "Pedido"
																&& $anulado->tipo_documento != "Recibo de compra de pedido"
																&& $anulado->tipo_documento != "Recibo de reintegro de pedido"
																&& $anulado->tipo_documento != "Recibo de sobrante de pedido"
																&& $anulado->tipo_documento != "Recibo de seguro"
																&& $anulado->tipo_documento != "Recibo de compra de pedido"): ?> 
																	<tr>
																		<td style="text-align: center;"><?= $anulado->control_number ?></td>
																		<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
																	</tr>
															<?php 
															endif;
														endif;
													endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							<?php 
							endif; ?>
						</div>
					<?php 
					endif; 
				endif; ?>					
			</div>
			<!-- Espacio de firmas de conformidad de los documentos fiscales -->
			<div>
				<div class="row">
					<div class="col-md-12">					
						<table>
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>Entregado por:</th>
									<th>______________________________</th>
									<th>&nbsp;</th>
									<th>Recibido por:</th>
									<th>______________________________</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>

			<!-- Documentos no fiscales -->
			<div>
				<?php
				if ($tipo_usuario == 0): ?>
					<!-- Pedidos -->
					<?php 
					if (isset($vectorTotalesRecibidosPedidos)): ?>
						<div class="saltopagina">
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th style="font-size: 18px; line-height: 20px;"><b>PEDIDOS DEL <?= $turn->start_date->format('d-m-Y') ?></b></th>
											</tr>
											<tr>
												<th style="font-size: 16px; line-height: 18px;">Cajero: <?= $cajero ?></th>
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
											<?php foreach ($vectorTotalesRecibidosPedidos as $clave => $recibido):
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
					<?php 
					endif; ?>

					<!-- Detalle de pedidos -->
					<div class="saltopagina">
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 18px; line-height: 20px;"><b>DETALLE DE PEDIDOS DEL <?= $turn->start_date->format('d-m-Y') ?></b></th>
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
											<th style="text-align: center;"><b>Ctrol / Ped</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Ped $</b></th>
											<th style="text-align: center;"><b>Ped Bs.</b></th>
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
											if ($pago['tipoDocumento'] == "Pedido"): ?>
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

					<?php 
					if ($indicadorReintegrosPedidos == 1 || $indicadorSobrantesPedidos == 1 || $indicadorComprasPedidos == 1): ?>
						<div class="saltopagina">
							<?php if ($indicadorReintegrosPedidos == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE REINTEGROS DE PEDIDOS DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
														if ($factura->tipo_documento == "Recibo de reintegro de pedido"): ?> 
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

							<?php if ($indicadorSobrantesPedidos == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE SOBRANTES DE PEDIDOS (VUELTOS PENDIENTES POR ENTREGAR) DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
														if ($factura->tipo_documento == "Recibo de sobrante de pedido"): ?>
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

							<?php if ($indicadorComprasPedidos == 1): ?>
								<div>
									<div class="row">
										<div class="col-md-12">					
											<table>
												<thead>
													<tr>
														<th>&nbsp;</th>
													</tr>	
													<tr>
														<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE COMPRAS DE PEDIDO DEL <?= $turn->start_date->format('d-m-Y') ?>:</b></th>
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
														if ($factura->tipo_documento == "Recibo de compra de pedido"): ?> 
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
						</div>
					<?php 
					endif; ?>	

					<?php 
					if ($indicadorPedidosAnulados == 1 || $indicadorRecibosAnuladosPedidos == 1): ?>
						<div class="saltopagina">

						<?php if ($indicadorPedidosAnulados == 1): ?>
							<div>
								<div class="row">
									<div class="col-md-12">					
										<table>
											<thead>
												<tr>
													<th>&nbsp;</th>
												</tr>	
												<tr>
													<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE PEDIDOS ANULADOS:</b></th>
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
													<th style="text-align: center;"><b>Fecha</b></th>
													<th style="text-align: center;"><b>Familia</b></th>
													<th style="text-align: center;"><b>Nro. Pedido</b></th>
													<th style="text-align: center;"><b>Monto $</b></th>
													<th style="text-align: center;"><b>Monto Bs.</b></th>
												</tr>
											</thead>
											<tbody>				
												<?php 
												$totalBolivar = 0;

												foreach ($documentosAnulados as $anulado):  
													if ($anulado->fiscal == 0):
														if ($anulado->tipo_documento == "Pedido"): ?> 
															<tr>												
																<td style="text-align: center;"><?= $anulado->date_and_time->format('d-m-Y') ?></td>
																<td style="text-align: center;"><?= $anulado->parentsandguardian->family ?></td>
																<td style="text-align: center;"><?= $anulado->bill_number ?></td>
																<td style="text-align: center;"><?= number_format(round($anulado->amount_paid / $anulado->tasa_cambio, 2), 2, ",", ".") ?></td>
																<td style="text-align: center;"><?= number_format($anulado->amount_paid, 2, ",", ".")   ?></td>
															</tr>
														<?php 
														endif;
													endif;
												endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ($indicadorRecibosAnuladosPedidos == 1): ?>
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
													<th style="text-align: center;"><b>Nro. Recibo</b></th>
													<th style="text-align: center;"><b>Tipo doc</b></th>
												</tr>
											</thead>
											<tbody>				
												<?php 
												$totalBolivar = 0;

												foreach ($documentosAnulados as $anulado):  
													if ($anulado->fiscal == 0):
														if ($anulado->tipo_documento == "Recibo de reintegro de pedido"
															|| $anulado->tipo_documento == "Recibo de sobrante de pedido"
															|| $anulado->tipo_documento == "Recibo de compra de pedido"
															|| $anulado->tipo_documento == "Recibo de vuelto de compra de pedido"): ?> 
															<tr>
																<td style="text-align: center;"><?= $anulado->control_number ?></td>
																<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
															</tr>
														<?php 
														endif;
													endif;
												endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php endif; ?>
						</div>
					<?php 
					endif; ?>	

					<!-- Espacio de firmas de conformidad de pedidos -->
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
										</tr>
										<tr>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
										</tr>
										<tr>
											<th>&nbsp;</th>
											<th>Entregado por:</th>
											<th>______________________________</th>
											<th>&nbsp;</th>
											<th>Recibido por:</th>
											<th>______________________________</th>
										</tr>
										<tr>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>

					<!-- Recibos de seguro -->
					<?php // if ($indicadorRecibosSeguro == 1): ?>
						<div class="saltopagina">
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th style="font-size: 18px; line-height: 20px;"><b>RECIBOS DE SEGURO DEL <?= $turn->start_date->format('d-m-Y') ?></b></th>
											</tr>
											<tr>
												<th style="font-size: 16px; line-height: 18px;">Cajero: <?= $cajero ?></th>
											</tr>	

											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS DE SEGURO:</b></th>
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
												<th style="text-align: center;"><b>Fecha</b></th>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>No Recibo</b></th>
												<th style="text-align: center;"><b>Tipo doc</b></th>
												<th style="text-align: center;"><b>Efectivo $</b></th>
												<th style="text-align: center;"><b>Zelle $</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php 
											$totalEfectivo = 0;
											$totalZelle = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Recibo de seguro"): 
													$efectivos = [];
													$zelles = [];
													foreach ($pagosFacturas as $pago)
													{
														if ($pago->bill_id == $factura->id)
														{ 
															if ($pago->payment_type == "Efectivo")
															{
																$efectivos[] = number_format($pago->amount, 2, ",", ".")."&nbsp;".$pago->moneda." ";
																$totalEfectivo += $pago->amount;
															}
															elseif ($pago->bank == "Zelle")
															{
																$zelles[] = number_format($pago->amount, 2, ",", ".")."&nbsp;".$pago->moneda." ";
																$totalZelle += $pago->amount;
															}
														}
													} ?> 
													<tr>
														<td style="text-align: center;"><?= $factura->date_and_time->format('d-m-Y') ?></td>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td><?= $factura->tipo_documento ?></td>
														<td style="text-align: center;">
															<?php
															foreach ($efectivos as $efectivo):
																echo $efectivo;
															endforeach; ?>
														</td>
														<td style="text-align: center;">
															<?php
															foreach ($zelles as $zelle):
																echo $zelle;
															endforeach; ?>
														</td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalEfectivo, 2, ",", ".")."&nbsp;$ " ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".")."&nbsp;$ " ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php // endif; ?>	

					<?php 
					if ($indicadorRecibosSeguroAnulados == 1): ?>
						<div>
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS DE SEGURO ANULADOS:</b></th>
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
												<th style="text-align: center;"><b>Fecha</b></th>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>Nro. Pedido</b></th>
												<th style="text-align: center;"><b>Monto $</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php 
											$totalBolivar = 0;

											foreach ($documentosAnulados as $anulado):  
												if ($anulado->fiscal == 0):
													if ($anulado->tipo_documento == "Recibo de seguro"): ?> 
														<tr>												
															<td style="text-align: center;"><?= $anulado->date_and_time->format('d-m-Y') ?></td>
															<td style="text-align: center;"><?= $anulado->parentsandguardian->family ?></td>
															<td style="text-align: center;"><?= $anulado->bill_number ?></td>
															<td style="text-align: center;"><?= number_format(round($anulado->amount_paid/$factura->tasa_cambio, 2), 2, ",", ".") ?></td>
														</tr>
													<?php 
													endif;
												endif;
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php 
					endif; ?>

					<!-- Recibos de consejo educativo -->
					<?php // if ($indicadorRecibosConsejoEducativo == 1): ?> 	
						<div class="saltopagina">
							<div class="row">
								<div class="col-md-12">					
									<table>
										<thead>
											<tr>
												<th style="font-size: 18px; line-height: 20px;"><b>RECIBOS DE CONSEJO EDUCATIVO <?= $turn->start_date->format('d-m-Y') ?></b></th>
											</tr>
											<tr>
												<th style="font-size: 16px; line-height: 18px;">Cajero: <?= $cajero ?></th>
											</tr>	
											<tr>
												<th>&nbsp;</th>
											</tr>	
											<tr>
												<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS DE CONSEJO EDUCATIVO:</b></th>
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
												<th style="text-align: center;"><b>Fecha</b></th>
												<th style="text-align: center;"><b>Familia</b></th>
												<th style="text-align: center;"><b>No Recibo</b></th>
												<th style="text-align: center;"><b>Concepto</b></th>
												<th style="text-align: center;"><b>Efectivo</b></th>
												<th style="text-align: center;"><b>Zelle</b></th>
												<th style="text-align: center;"><b>Transferencia</b></th>
												<th style="text-align: center;"><b>Monto Total Bs.</b></th>
											</tr>
										</thead>
										<tbody>				
											<?php 
											$totalBs = 0;
											$totalEfectivo = 0;
											$totalZelle = 0;
											$totalTransferencias = 0;
											foreach ($facturas as $factura):  
												if ($factura->tipo_documento == "Recibo de Consejo Educativo"): 
													$efectivos = [];
													$zelles = [];
													$transferencias = [];
													foreach ($pagosFacturas as $pago)
													{
														if ($pago->bill_id == $factura->id)
														{ 
															if ($pago->payment_type == "Efectivo")
															{
																$efectivos[] = number_format($pago->amount, 2, ",", ".")."&nbsp;".$pago->moneda." ";
																$totalEfectivo += $pago->amount;
															}
															elseif ($pago->bank == "Zelle")
															{
																$zelles[] = number_format($pago->amount, 2, ",", ".")."&nbsp;".$pago->moneda." ";
																$totalZelle += $pago->amount;
															}
															elseif ($pago->payment_type == "Transferencia")
															{
																$transferencias[] = number_format($pago->amount, 2, ",", ".")."&nbsp;".$pago->moneda." ";
																$totalTransferencias += $pago->amount;
															}
														}
													} ?> 
													<tr>
														<td style="text-align: center;"><?= $factura->date_and_time->format('d-m-Y') ?></td>
														<td><?= $factura->parentsandguardian->family ?></td>
														<td style="text-align: center;"><?= $factura->bill_number ?></td>
														<td style="text-align: center;"><?= $conceptosConsejoEducativo[$factura->id] ?></td>
														<td style="text-align: center;">
															<?php
															foreach ($efectivos as $efectivo):
																echo $efectivo;
															endforeach; ?>
														</td>
														<td style="text-align: center;">
															<?php
															foreach ($zelles as $zelle):
																echo $zelle;
															endforeach; ?>
														</td>
														<td style="text-align: center;">
															<?php
															foreach ($transferencias as $transferencia):
																echo $transferencia;
															endforeach; ?>
														</td>
														<?php 
														$montoReciboBs = round($factura->amount_paid * $factura->tasa_cambio, 2);
														$totalBs += $montoReciboBs; ?>
														<td style="text-align: center;"><?= number_format($montoReciboBs, 2, ",", ".")."&nbsp;Bs." ?></td>
													</tr>
												<?php endif;
											endforeach; ?>
											<tr>
												<td><b>Totales</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="text-align: center;"><b><?= number_format($totalEfectivo, 2, ",", ".")."&nbsp;$ " ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".")."&nbsp;$ " ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalTransferencias, 2, ",", ".")."&nbsp;$ " ?></b></td>
												<td style="text-align: center;"><b><?= number_format($totalBs, 2, ",", ".")."&nbsp;Bs." ?></b></td>
											</tr>
										</tbody>
									</table>
									<p>Recibido: ______________________________</p>
									<br />
									<p>Diferencia: ____________________________</p>
								</div>
							</div>
						</div>
					<?php // endif; ?>	

					<!-- Servicio educativo -->
					<div class="saltopagina">
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 18px; line-height: 20px;"><b>SERVICIO EDUCATIVO DEL <?= $turn->start_date->format('d-m-Y') ?></b></th>
										</tr>
										<tr>
											<th style="font-size: 16px; line-height: 18px;">Cajero: <?= $cajero ?></th>
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
											<th style="text-align: center;"><b>Estudiante(s)</b></th>
											<th style="text-align: center;"><b>Ctrol / Fact</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Fact $</b></th>
											<th style="text-align: center;"><b>Fact Bs.</b></th>
											<th style="text-align: center;"><b>Desc / Rec</b></th>
											<th style="text-align: center;"><b>Tasa $ / €</b></th>
											<th style="text-align: center;"><b>E $</b></th>
											<th style="text-align: center;"><b>E €</b></th>
											<th style="text-align: center;"><b>Zel $</b></th>
											<th style="text-align: center;"><b>Eur €</b></th>
											<th style="text-align: center;"><b>TD/TC Bs.</b></th>
											<th style="text-align: center;"><b>Trans Bs.</b></th>
											<th style="text-align: center;"><b>Tot Cob. Bs.</b></th>
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
										foreach ($vectorPagos as $indice => $pago): 
											$transferenciaDestiempo = "";
											$cuotasAlumnoBecado = "";
											$cambioMontoCuota = "";
											if ($pago['tipoDocumento'] == "Recibo de servicio educativo"): ?>
												<tr>
													<td><?= $pago['familia']; ?></td>
													<td>
														<?php
														foreach ($conceptosServicioEducativo as $concepto)
														{
															if ($concepto['bill_id'] == $indice)
															{
																echo $concepto['concepto'].'<br />';
															} 
														}
														?>
													</td>
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
													<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['euros'])): ?>
														<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;"><?= "0,00" ?></td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
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
													<?php if (isset($pago['descuentoRecargo'])):
														$diferencia = ($pago['totalFacturaBolivar'] + $pago['descuentoRecargo']) - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));
													else: 
														$diferencia = $pago['totalFacturaBolivar'] - ($cobradoBolivares + round($pago['compensadoDolar'] * $pago['tasaDolar'], 2));													
													endif; ?>
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
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalFacturaDolar, 2, ",", ".") ?></b></td>	
											<td style="text-align: center;"><b><?= number_format($totalFacturaBolivar, 2, ",", ".") ?></b></td>												
											<td style="text-align: center;"><b><?= number_format($totalDescuentosRecargosSE, 2, ",", ".") ?></b></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEfectivoEuro, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEuros, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTdbTdc, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalTransferencias, 2, ",", ".") ?></b></td>										
											<td style="text-align: center;"><b><?= number_format($totalCobradoBolivares, 2, ",", ".") ?></b></td>
											<td></td>												
										</tr>
										<tr>
											<td><i>Leyenda: T = Transferencia destiempo, C = Convenio y M = Cambio monto cuota</i></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
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
									</tbody>
								</table>
							</div>
						</div>
					</div>	
				<?php
				endif; ?>
			</div>			
        </div>
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