<?php
    use Cake\Routing\Router;
	if ($menuOption == "Recibo Consejo Educativo"):
		$accionBusquedaFamilia = "findFamilyConsejoEducativo";
	else:
		$accionBusquedaFamilia = "findFamily";
	endif;
	$anoEscolarAnterior = $anoEscolarActual - 1;
	$proximoAnoEscolar = $anoEscolarActual + 1;
	// Inicio cambios Seniat
	$tipo_usuario = 0;
	if ($current_user['role'] == 'Seniat' || $current_user['role'] == 'Ventas fiscales' || $current_user['role'] == 'Contabilidad fiscal' ):
		$tipo_usuario = 1;
	endif;
	// Fin cambios Seniat
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<input type="hidden" id="type-invoice" value="<?= $menuOption ?>">
            <div class="row">
                <div class="col-md-12">
					<?php if ($menuOption == 'Recibo de seguro'): ?>
						<h3><b>Recibo de seguro</b></h3>
					<?php elseif ($menuOption == 'Factura inscripción regulares'): ?>
						<h3><b>Factura inscripción alumnos regulares</b></h3>
					<?php elseif ($menuOption == 'Factura inscripción nuevos'): ?>
						<h3><b>Factura inscripción alumnos nuevos</b></h3>
					<?php elseif ($menuOption == 'Recibo inscripción regulares'): ?>
						<h3><b>Recibo inscripción alumnos regulares</b></h3>
					<?php elseif ($menuOption == 'Recibo inscripción nuevos'): ?>
						<h3><b>Recibo inscripción alumnos nuevos</b></h3>
					<?php elseif ($menuOption == 'Recibo servicio educativo'): ?>
						<h3><b>Recibo servicio educativo</b></h3>
					<?php elseif ($menuOption == 'Mensualidades'): ?>
						<h3><b>Cobro de mensualidades</b></h3>
					<?php elseif ($menuOption == 'Recibo Consejo Educativo'): ?>
						<h3><b>Recibo Consejo Educativo</b></h3>
					<?php endif; ?>
                    <h5 id="Turno" value=<?= $idTurn ?>>Fecha: <?= $dateTurn->format('d-m-Y') ?>, Turno: <?= $turn ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h5>
                </div>
            </div>
			<div class="row panel panel-default">
				<div class="col-md-3">
					<?= $this->Form->input('dollar_exchange_rate', ['label' => 'Tasa oficial $:', 'class' => 'alternative-decimal-separator', 'value' => number_format(($dollarExchangeRate), 2, ",", ".")]) ?>
					<button id="update-dollar" class="btn btn-success">Actualizar</button>
					<p id="dollar-messages"></p>
				</div>
				<div class="col-md-3">
					<?= $this->Form->input('euro', ['label' => 'Tasa oficial €:', 'class' => 'alternative-decimal-separator', 'value' => number_format(($euro), 2, ",", ".")]) ?>
					<button id="update-euro" class="btn btn-success">Actualizar</button>
					<p id="euro-messages"></p>
				</div>
				<div class="col-md-3">
					<?= $this->Form->input('tasa_temporal_dolar', ['label' => 'Tasa temporal $:', 'class' => 'alternative-decimal-separator', 'value' => number_format((0), 2, ",", ".")]) ?>
					<button id="establecer-tasa-dolar" class="btn btn-success">Establecer</button>
					<button id="eliminar-tasa-dolar" class="btn btn-success noverScreen">Eliminar</button>
				</div>
				<div class="col-md-3">
					<?= $this->Form->input('tasa_temporal_euro', ['label' => 'Tasa temporal €:', 'class' => 'alternative-decimal-separator', 'value' => number_format((0), 2, ",", ".")]) ?>
					<button id="establecer-tasa-euro" class="btn btn-success">Establecer</button>
					<button id="eliminar-tasa-euro" class="btn btn-success noverScreen">Eliminar</button>
				</div>
			</div>
            <div class="row panel panel-default">
                <div class="col-md-4">
                    <label for="family">Por favor escriba los apellidos de la familia:</label>
                    <br />
                    <input type="text" class="form-control" id="family-search">
                    <br />
					<?php if ($menuOption == 'Factura inscripción regulares' || $menuOption == 'Recibo inscripción regulares' || $menuOption == 'Mensualidades'): ?>
						<button id="newfamily" class="btn btn-success" disabled>Listar familias nuevas</button>
					<?php else: ?>
						<button id="newfamily" class="btn btn-success">Listar familias nuevas</button>
					<?php endif; ?>
					<br />
					<br />
                    <button id="everyfamily" class="btn btn-success">Listar familias del año escolar actual</button>
                    <br />
                    <br />
                    <div class="panel panel-default pre-scrollable" style="height:120px;">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody id="response-container"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<div id="cuadro-periodo-escolar" class="noverScreen">
						<?php
						echo $this->Form->input('periodo_escolar', ['label' => 'Período escolar: ', 'options' => 
							[
								"" => "",
								$anoEscolarAnterior => $anoEscolarAnterior.'-'.$anoEscolarActual,
								$anoEscolarActual => $anoEscolarActual.'-'.$proximoAnoEscolar
							]]); ?>
					</div>
                </div>
                <div class="col-md-4">
                    <br />
                    <?= $this->Form->input('date_and_time', ['label' => 'Fecha:']) ?>
                    <?= $this->Form->input('family', ['label' => 'Familia:']) ?>
                    <?= $this->Form->input('client', ['label' => 'Cliente:', 'class' => 'campo-resaltado']) ?>
					<div id="mensaje-cliente" class="mensajes-usuario"></div>
                    <?= $this->Form->input('type_of_identification_client', 
                        ['options' => 
                        [null => "",
                        'V' => 'Cédula venezolano',
                        'E' => 'Cédula extranjero',
                        'P' => 'Pasaporte',
                        'J' => 'Rif Jurídico',
                        'G' => 'Rif Gubernamental'],
                        'label' => 'Tipo de documento de identificación:',
						'class' => 'campo-resaltado']) ?>
					<div id="mensaje-tipo-de-identificacion" class="mensajes-usuario"></div>
                    <?= $this->Form->input('identification_number_client', ['label' => 'Número de cédula o RIF:', 'class' => 'entero campo-resaltado']) ?>
					<div id="mensaje-numero-identificacion-cliente" class="mensajes-usuario"></div>
                </div>
                <div class="col-md-4">
                    <br />
                    <?= $this->Form->input('fiscal_address', ['label' => 'Dirección:', 'class' => 'campo-resaltado']) ?>
					<div id="mensaje-direccion-fiscal" class="mensajes-usuario"></div>
                    <?= $this->Form->input('tax_phone', ['label' => 'Teléfono:', 'class' => 'entero campo-resaltado']) ?>
					<div id="mensaje-telefono" class="mensajes-usuario"></div>
                    <?= $this->Form->input('email', ['label' => 'Correo electrónico:']) ?>
                    <br />
                    <button id="update-data" class="btn btn-success">Actualizar datos del cliente</button>
                    <br />
                    <br />
                    <p id="header-messages"></p>
                    <br />
                </div>
            </div>
            <br />
            <div class="row panel panel-default" id="alumnos-relacionados">
                <div class="col-md-3">
                    <br />
                    <p><b>Alumnos relacionados:</b></p>
                    <div class="panel panel-default pre-scrollable" style="height:260px;">
                        <div class="panel-body">
                            <div class="table-responsive">          
                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th scope="col">Apellido</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">&nbsp;&nbsp;&nbsp;Grado&nbsp;&nbsp;&nbsp;</th>
                                            <th scope="col">Sección</th>
                                            <th scope="col">Condición</th>
											<th scope="col">ID</th>
                                        </tr>
                                    </thead>
                                    <tbody id="related-students"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <br />
                    <p><b>Cuotas pendientes:</b></p>
                    <div class="panel panel-default pre-scrollable" style="height:210px;">
                        <div class="panel-body">
                            <div class="table-responsive">          
                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
											<th scope="col" style="width:5%"></th>
                                            <th scope="col" style="font-size: 11px; width:15%">Concepto</th>
											<th scope="col" style="font-size: 11px; width:15%">Cuota($)</th>
                                            <th scope="col" style="font-size: 11px; width:10%">Abonado($)</th>
											<th scope="col" style="font-size: 11px; width:10%">Pendiente($)</th>
											<th scope="col" style="font-size: 11px; width:15%">A pagar($)</th>
											<th scope="col" style="color: blue; font-size: 10px; width:10%">A pagar(€)</th>
											<th scope="col" style="color: red; font-size: 10px; width:10%">A pagar(Bs.)</th>
											<th scope="col" style="font-size: 11px; width:10%">Observación</th>
											<th scope="col" class="noverScreen"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthly-payment"></tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
					<div class="row">
						<div class="col-md-6">
							<div id="nota-credito">
							</div>
							<div id="botones-cuotas">
								<p>
									<button id="mark-quotas" class="btn btn-success" disabled>Cobrar</button>
									<button id="uncheck-quotas" class="btn btn-success" disabled>Reversar</button>  
									<button id="adjust-fee" class="btn btn-success" disabled>Ajustar</button>
								</p>
							</div>
							<div id="botones-notas" class="noverScreen">
								<p>
									<button id="compensar" class="btn btn-success">Compensar</button>
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<p>Cuotas: <b><spam id="student-concept"></spam></b></p>
						</div>
						<div class="col-md-3">
							<p>Sub-total alumno $: <b><spam id="student-balance">0</spam></b></p>
							<p>Sub-total familia $: <b><spam id="total-balance"></spam></b></p>
							<p>Sub-total IGTF $: <b><spam id="sub_total_igtf"></spam></b></p>
							<p>Total con IGTF $: <b><spam id="total_con_igtf"></spam></b></p> 
						</div>  						
					</div>
                </div>
            </div>
			<div class="row"
				<p id="student-messages"></p>
			</div>
			<div class="row">
			    <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12 panel panel-default">
                            <br />
                            <p><b>Registrar pago:</b></p>
                            <div id="accordion">
								<h3>Efectivo</h3>
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-01', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco:', 'value' => 'N/A', 'disabled' => true, 'id' => 'bank-01']) ?>	
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'value' => 'N/A', 'disabled' => true, 'id' => 'banco-receptor-01']); ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-01']) ?>
										</div>
										<div class="col-md-6">	
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-01']) ?>
											<div class="form-group">
												<label for="comentario-01">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-01"></textarea>
											</div>
											<button id="bt-01" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>
                                <h3>Tarjeta de débito</h3>
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-02', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco emisor:', 'id' => 'bank-02', 'options' => $bancosEmisor]); ?>
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco-receptor-02', 'options' => $bancosReceptor]); ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'id' => 'account_or_card-02']) ?>
										</div>
										<div class="col-md-6">	
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-02']) ?>
											<div class="form-group">
												<label for="comentario-02">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-02"></textarea>
											</div>
											<button id="bt-02" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>
                                <h3>Tarjeta de crédito</h3>
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-03', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco emisor:', 'id' => 'bank-03', 'options' => $bancosEmisor]); ?>
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco-receptor-03', 'options' => $bancosReceptor]); ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'id' => 'account_or_card-03']) ?>
										</div>
										<div class="col-md-6">		
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-03']) ?>
											<div class="form-group">
												<label for="comentario-03">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-03"></textarea>
											</div>
											<button id="bt-03" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>
                                <h3>Depósito</h3>
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-04', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco emisor:', 'id' => 'bank-04', 'options' => $bancosEmisor]); ?>
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco-receptor-04', 'options' => $bancosReceptor]); ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-04']) ?>
										</div>
										<div class="col-md-6">
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-04']) ?>
											<div class="form-group">
												<label for="comentario-04">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-04"></textarea>
											</div>
											<button id="bt-04" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>								
                                <h3>Transferencia</h3>
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-05', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco emisor:', 'id' => 'bank-05', 'options' => $bancosEmisor]); ?>	
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco-receptor-05', 'options' => $bancosReceptor]); ?>	
											<?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-05']) ?>
										</div>
										<div class="col-md-6">	
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-05']) ?>
											<div class="form-group">
												<label for="comentario-05">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-05"></textarea>
											</div>
											<button id="bt-05" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>		
                                <h3>Cheque</h3>
								
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-06', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco emisor:', 'id' => 'bank-06', 'options' => $bancosEmisor]); ?>
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'id' => 'banco-receptor-06', 'options' => $bancosReceptor]); ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'id' => 'account_or_card-06']) ?>
										</div>
										<div class="col-md-6">	
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-06']) ?>
											<div class="form-group">
												<label for="comentario-06">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-06"></textarea>
											</div>
											<button id="bt-06" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>								
                                <h3 id="acordion-retencion-impuesto">Retención de impuesto</h3>						
								<div>
									<div class="row">
										 <label class="check-dolar" for="check1">
											<spam><input type="checkbox" class="check-dolar" checked='checked'> Dólar&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-euro" for="check1">
											<spam style="color: blue;"><input type="checkbox" class="check-euro"> Euro&nbsp;&nbsp;&nbsp;</spam>
										</label>
										 <label class="check-bolivar" for="check1">
											<spam style="color: red;"><input type="checkbox" class="check-bolivar"> Bolívar&nbsp;&nbsp;&nbsp;</spam>
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-07', 'class' => 'alternative-decimal-separator']) ?>
											<?= $this->Form->input('bank', ['label' => 'Banco:', 'value' => 'N/A', 'disabled' => true, 'id' => 'bank-07']) ?>
											<?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-07']) ?>
											<?= $this->Form->input('banco_receptor', ['label' => 'Banco receptor:', 'value' => 'N/A', 'disabled' => true, 'id' => 'banco-receptor-07']); ?>
										</div>
										<div class="col-md-6">		
											<?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-07']) ?>
											<div class="form-group">
												<label for="comentario-06">Comentario:</label>
												<textarea class="form-control" rows="3" id="comentario-07"></textarea>
											</div>
											<button id="bt-07" class="record-payment btn btn-success" disabled>Registrar pago</button>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-12 panel panel-default">
							<br />
							<div class="table-responsive">          
								<table class="table table-striped table-hover" >
									<thead>
										<tr>
											<th scope="col" style="width:25%;">Totales factura</th>
											<th scope="col" style="width:15%;"></th>
											<th scope="col" style="width:15%; text-align:center;">Dólar ($)</th>
											<th scope="col" style="color: blue; width:15%; text-align:center;">Euro (€)</th>
											<th scope="col" style="color: red; width:30%; text-align:center;">Bolívar (Bs.)</th>
										</tr>
									</thead>								
										<tbody>
											<tr>
												<td>Sub-total</td>
												<td></td>
												<td id="sub-total-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="sub-total-euro"></td>
												<td style="color: red; text-align:center;" id="sub-total-bolivar"></td>	
											</tr>
											<tr>
												<td>Saldo a favor/contra</td>
												<td></td>
												<td id="saldo-favor-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="saldo-favor-euro"></td>
												<td style="color: red; text-align:center;" id="saldo-favor-bolivar"></td>
											</tr>
											<tr>	
												<td><?= $this->Form->input('descuento_recargo', ['label' => 'Descuento/Recargo:', 'id' => 'descuento-recargo', 'disabled' => 'true', 'options' => 
													[null => '',
													'Descuento $' => 'Descuento: $',
													'Descuento %' => 'Descuento: %',
													'Recargo $' => 'Recargo: $',
													'Recargo %' => 'Recargo: %']]); ?></td>	
												<td><?= $this->Form->input('cantidad_descuento', ['label' => 'Cantidad:', 'type' => 'text', 'id' => 'cantidad-descuento', 'value' => 0, 'disabled' => 'true', 'class' => 'alternative-decimal-separator']); ?></td>													
												<td id="descuento-recargo-dolar" style="text-align:center; vertical-align: middle;">0</td>
												<td style="color: blue; text-align:center; vertical-align: middle;" id="descuento-recargo-euro">0</td>
												<td style="color: red; text-align:center; vertical-align: middle;" id="descuento-recargo-bolivar">0</td>
											</tr>
											<tr>
												<td>Iva 16%</td>
												<td></td>
												<td style="text-align:center;">0,00</td>
												<td style="color: blue; text-align:center;">0,00</td>
												<td style="color: red; text-align:center;">0,00</td>
											</tr>
											<tr>
												<td>IGTF 3%</td>
												<td></td>
												<td id="igtf_dolar" style="text-align:center;"></td>
												<td id="igtf_euro" style="color: blue; text-align:center;"></td>
												<td id="igtf_bolivar" style="color: red; text-align:center;"></td>
											</tr>
											<tr>
												<td>Total</td>
												<td></td>
												<td id="total-balance-descuento-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="total-balance-descuento-euro"></td>
												<td style="color: red; text-align:center;" id="total-balance-descuento-bolivar"></td>
											</tr>
											<tr>	
												<td>Pagado</td>
												<td></td>
												<td id="pagado-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="pagado-euro"></td>
												<td style="color: red; text-align:center;" id="pagado-bolivar"></td>
											</tr>
											<tr>
												<td>Por pagar</td>
												<td></td>
												<td id="por-pagar-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="por-pagar-euro"></td>
												<td style="color: red; text-align:center;" id="por-pagar-bolivar"></td>
											</tr>
											<tr>
												<td>Sobrante</td>
												<td></td>
												<td id="sobrante-dolar" style="text-align:center;"></td>
												<td style="color: blue; text-align:center;" id="sobrante-euro"></td>
												<td style="color: red; text-align:center;" id="sobrante-bolivar"></td>																		
											</tr>
										</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<p>
								<button id="ajuste-automatico" class="btn btn-success" disabled>Ajuste</button>
								<button id="print-invoice" class="btn btn-success" disabled>Guardar factura</button>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 panel panel-default">
							<br />
							<p><b>Pagos realizados:</b></p>
							<div class="panel-body">
								<div class="table-responsive">          
									<table class="table table-striped table-hover" >
										<thead>
											<tr>
												<th scope="col" style="color:red;">&nbsp;(x)&nbsp;</th>
												<th scope="col">Forma&nbsp;de&nbsp;pago&nbsp;&nbsp;</th>
												<th scope="col">Moneda</th>
												<th scope="col">Monto</th>
												<th scope="col">&nbsp;&nbsp;Banco emisor&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th scope="col">&nbsp;&nbsp;Banco receptor&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th scope="col">Cuenta&nbsp;o&nbsp;tarjeta</th>
												<th scope="col">Serial</th>
												<th scope="col">Comentario</th>
											</tr>
										</thead>
										<tbody id="registered-payments"></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<button id="mostrar-registros" type=submit>Todas las cuotas</button>
<button id="mostrar_cuotas_seleccionadas" type=submit>Cuotas seleccionadas</button>
<button id="mostrar-pagos" type=submit>Pagos</button>
<button id="prueba-ajuste">Prueba ajuste</button>
<div id="mensajes"></div>
<div id="results"></div>
<div id="pagos"></div>
<div id='insertar_html'></div>
<script>
//  Variables globales
    var idFamily = 0;
    var nameFamily = " ";
    var selectFamily = -1;
	var typeStudent = 0;
    var customerEmail = " ";
    var totalBalance = 0;
	var totalBalanceEuros = 0;
	var totalBalanceBolivares = 0;
	var saldoPagosRealizados = 0;
	var discountMode = '';
	var discountAmount = 0;
	var discount = 0;
	var descuentoEuros = 0;
	var descuentoBolivares = 0; 
	var balanceDescuento = 0;
	var balanceDescuentoEuros = 0;
	var balanceDescuentoBolivares = 0;
	var totalBalanceDescuento = 0;
	var totalBalanceDescuentoEuros = 0;
	var totalBalanceDescuentoBolivares = 0;	
	var totalGeneral = 0;
	var invoiceDescuento = 0;
    var totalBill = 0;
    var paymentType = " ";
    var monto_cuota = 0;
	var montoPagado = 0;
	var montoPagadoDolar = 0;
	var montoPagadoEuro = 0;
	var montoPagadoBolivar = 0;
    var bank = " ";
	var bancoReceptor = "";
    var accountOrCard = " ";
    var serial = " ";
    var balance = 0;
    var balanceIndicator = 0;
    var accumulatedPayment = 0;
    var acumuladoPagadoEuros = 0;
    var acumuladoPagadoBolivares = 0;
    var accountantPaid = 0;
    var accountant = 1;
    var linePayments = " ";
    var valid = true;
    var studentBalance = 0.00;
    var indicatorUpdateAmount = 0;
    var paymentNumber = " ";
    var change = 0;
    var invoiceLine = " ";
    var amountConcept = 0;
    var transactionCounter = 0;
    var conceptCounter = 0;
    var accountPaid = 0;
    var idParentsandguardians = 0; 
    var reversedDate = " ";
	var schoolYearFrom = 0;
	var biggestYearFrom = 0;
	var biggestYearUntil = 0;

    var selectedStudent = -1;
    var idStudent = 0;
    var studentName = " ";
    var scholarship = 0;
    var studentTransactionsArray = new Array();
	var paymentsArray = new Array();
    var transactionIdentifier = 0;
    var monthlyPayment = " ";
	var tarifaDolar = 0;
	var tarifaDolarSinDescuento = 0;
	var montoPendienteDolar = 0;
	var montoAPagarDolar = 0;
	var montoAPagarEuro = 0;
	var montoAPagarBolivar = 0;
	var montoDolar = 0;
    var transactionAmount = 0;
	var tempAmount = 0;
    var originalAmount = 0;
    var invoiced = 0;
    var partialPayment = 0;
    var paidOut = 0;
	var dollarExchangeRate = 0;
	var tasaDolarEuro = 0;
	var amountMonthly = 0;
	var discountFamily = 0;
	var transactionType = "";
    var firstName = " ";
    var secondName = " ";
    var surname = " ";
    var secondSurname = " ";
    var concept = " ";
    var idStudentTransactions = " ";
	var idAmountTransactions = "";
    var amountPayable = 0;
    var selectedPayment = -1;
    var grade = " ";
    var section = " ";
	var temporalMontoBolivar = 0;
	var saldoNotaCredito = 0;
	var euro = 0;
	var saldoRepresentante = 0;
	var saldoRepresentanteSigno = 0;
	var saldoRepresentanteEuros = 0;
	var saldoRepresentanteSignoEuros = 0;
	var saldoRepresentanteBolivares = 0;
	var saldoRepresentanteSignoBolivares = 0;
	var indicadorCompensacion = 0;
	var deudaMenosPagado = 0;
	var deudaMenosPagadoEuros = 0;
	var deudaMenosPagadoDolares = 0;
	var porPagar = 0;
	var porPagarEuros = 0;
	var porPagarBolivares = 0;
	var sobrante = 0;
	var sobranteEuros = 0;
	var sobranteBolivares = 0;
	var monedaPago = "$";
	var comentario = "";
	var monedaPagoEliminar = "";
	var indicadorAjuste = 0;
	var indicador_abono = 0;
	var indicadorNoCuotas = 0;
	var contadorCuotasSeleccionadas = 0;
	var imprimirReciboSobrante = 0;
	var tasaTemporalDolar = 0;
	var tasaTemporalEuro = 0;
	var cuotasAlumnoBecado = 0;
	var cambioMontoCuota = 0;
	var morosoAnoAnterior = 0;
	var julioAnoAnterior = "";
	var julioExonerado = 0;
	var alumno_nuevo = 0;
	var diferenciaBolivares = 0;
	var becadoAnoAnterior = 0;
	var descuentoAnoAnterior = 0;
	var anoEscolarActual = <?= $anoEscolarActual ?>;
	var anoEscolarAnterior = <?= $anoEscolarActual - 1 ?>;
	var anoEscolarInscripcion = <?= $anoEscolarInscripcion ?>;
	var anoEscolarMensualidad = 0;
    var payments = new Object();
    payments.idTurn = 0;
    payments.idParentsandguardians = 0;
    payments.invoiceDate = " ";
    payments.schoolYear = " ";
    payments.client = " ";
    payments.typeOfIdentificationClient = " ";
    payments.identificationNumberClient = " ";
    payments.fiscalAddress = " ";
    payments.taxPhone = " ";
    payments.invoiceAmount = 0;
	payments.discount = 0;
    payments.fiscal = 0;
	payments.tasaDolar = 0;
	payments.tasaEuro = 0;
	payments.tasaDolarEuro = 0;
	payments.saldoRepresentante = 0;
	payments.sobrante = 0;
	payments.imprimirReciboSobrante = 0;
	payments.tasaTemporalDolar = 0;
	payments.tasaTemporalEuro = 0;
	payments.cuotasAlumnoBecado = 0;
	payments.cambioMontoCuota = 0;
	payments.monto_divisas = 0;
	payments.monto_igtf = 0;
	payments.indicador_pedido = 0;
	payments.indicadorConsejoEducativo = 0;

    var tbStudentTransactions = new Array();
    var tbConcepts = new Array();
    var tbPaymentsMade = new Array();
	
	var indicador_recalcular_cuotas = true;
	var indicador_pedido = 0;
	var ano_mes_actual = <?= $ano_mes_actual ?>;
	var ano_mes_recalculo_cuotas_atrasadas = "202209";
	var conceptos_a_omitir = 
		[
			"Seguro escolar 2020",
			"Seguro escolar 2021",
			"Seguro escolar 2022",
			"Thales 2021",
			"Thales 2022" 
		];

	var porcentaje_calculo_base_igtf = 1.03; // Cuando no se va a cobrar IGTF debe ser 1
	var porcentaje_calculo_igtf = 0.03; // Cuando no se va a cobrar IGTF debe ser 0
	var base_igtf_dolar = 0;
	var monto_divisas = 0;
	var monto_igtf_dolar = 0;
	var monto_igtf_dolar_pedido = 0;
	var acumulado_igtf_dolar = 0;
	var acumulado_igtf_dolar_archivo = 0;
	var acumulado_igtf_euro = 0;
	var acumulado_igtf_bolivar = 0;
	var total_balance_bolivares_igtf = 0;
	var indicador_igtf_recalculado = 0;
	var estudiantes_condiciones = [];
	var mesesTarifas = new Array();
	var otrasTarifas = new Array();

	var indicadorConsejoEducativo = 0;
    var familiasRelacionadasAnterior = '';
	var familiasRelacionadas = '';
    var idFamiliaPagadoraConsejoAnterior = 0;
	var idFamiliaPagadoraConsejo = 0;
    var consejoExoneradoAnterior = 0;
	var consejoExonerado = 0;
    var indicadorConsejoAnterior = false;
    var indicadorConsejoActual = false;
    var indicadorReciboConsejoAnterior = false;
    var indicadorReciboConsejoActual = false;      
	var anioConsejoEducativo = 0;
	var proximoAnioConsejoEducativo = 0;

	const ajustesPagosInscripcion = [];
	ajustesPagosInscripcion['Ago 2025'] = 10;
	var observacionTransaccion = '';
	var ordenGrado = 0;
	var aCobrarRetencion = 0;
	var tipoUsuario = <?= $tipo_usuario ?>;
	
// Funciones Javascript

    function log(message) 
    {
        if (totalBalance > 0)
        {    
            var r = confirm("Si selecciona otra familia, perderá los datos del cobro realizado a la familia: " + nameFamily );
            if (r == false)
            {
                return false;
            }
        }

        cleanPager();
        $("#response-container").html("");
        $("#response-container").html(message);
        
        disableButtons();
    }
    
    function disableButtons()
    {
        $("#mark-quotas").text("cobrar");
        $("#mark-quotas").attr('disabled', true);
        $("#uncheck-quotas").attr('disabled', true);
		$("#adjust-fee").attr('disabled', true);
		$("#descuento-recargo").attr('disabled', true);
		$("#cantidad-descuento").attr('disabled', true);
        $("#ajuste-automatico").attr('disabled', true);
        $("#print-invoice").attr('disabled', true);
        $("#bt-01").attr('disabled', true);
        $("#bt-02").attr('disabled', true);
        $("#bt-03").attr('disabled', true);
        $("#bt-04").attr('disabled', true);
        $("#bt-05").attr('disabled', true);
        $("#bt-06").attr('disabled', true);
        $("#bt-07").attr('disabled', true);
    }
	
    function habilitaBotones()
    {
        $("#mark-quotas").attr('disabled', false);
        $("#uncheck-quotas").attr('disabled', false);
		$("#adjust-fee").attr('disabled', false);
		$("#descuento-recargo").attr('disabled', false);
		$("#cantidad-descuento").attr('disabled', false);
        $("#ajuste-automatico").attr('disabled', false);
        $("#print-invoice").attr('disabled', false);
        $("#bt-01").attr('disabled', false);
        $("#bt-02").attr('disabled', false);
        $("#bt-03").attr('disabled', false);
        $("#bt-04").attr('disabled', false);
        $("#bt-05").attr('disabled', false);
        $("#bt-06").attr('disabled', false);
        $("#bt-07").attr('disabled', false);
    }
    
    function deshabilitarBotonesAjuste()
    {
        $("#mark-quotas").attr('disabled', true);
		$("#uncheck-quotas").attr('disabled', true);
        $("#uncheck-quotas").attr('disabled', true);
		$("#adjust-fee").attr('disabled', true);
		$("#descuento-recargo").attr('disabled', true);
		$("#cantidad-descuento").attr('disabled', true);
        $("#ajuste-automatico").attr('disabled', true);
        $("#bt-01").attr('disabled', true);
        $("#bt-02").attr('disabled', true);
        $("#bt-03").attr('disabled', true);
        $("#bt-04").attr('disabled', true);
        $("#bt-05").attr('disabled', true);
        $("#bt-06").attr('disabled', true);
        $("#bt-07").attr('disabled', true);
		$(".registeredPayments").attr('disabled', true);	
    }
	
    function habilitarBotonesAjuste()
    {
        $("#mark-quotas").attr('disabled', false);
		$("#uncheck-quotas").attr('disabled', false);
        $("#uncheck-quotas").attr('disabled', false);
		$("#adjust-fee").attr('disabled', false);
		$("#descuento-recargo").attr('disabled', false);
		$("#cantidad-descuento").attr('disabled', false);
        $("#ajuste-automatico").attr('disabled', false);
        $("#bt-01").attr('disabled', false);
        $("#bt-02").attr('disabled', false);
        $("#bt-03").attr('disabled', false);
        $("#bt-04").attr('disabled', false);
        $("#bt-05").attr('disabled', false);
        $("#bt-06").attr('disabled', false);
        $("#bt-07").attr('disabled', false);
    }
	
    function markStudent(id)
    {
        $('#st' + id + ' td').each(function ()
        {
            $(this).css('background-color', '#c2c2d6'); 
        });
    }
    
    function uncheckStudent(id)
    {
        $('#st' + id + ' td').each(function ()
        {
            $(this).css('background-color', 'white'); 
        });
    }
    
    function markTransaction(id)
    {
        $('#tra' + id + ' td').each(function ()
        {
            $(this).css('background-color', '#c2c2d6'); 
        });
    }
    
    function uncheckTransaction(id)
    {
        $('#tra' + id + ' td').each(function ()
        {
            $(this).css('background-color', 'white'); 
        });
    }

    function cleanPager()
    {
		studentTransactionsArray = [];
		paymentsArray = [];

		$('#family-search').val(" ");
        $('#family').val(" ");
        $("#date-and-time").val(" ");
        $('#client').val(" ");
        $('#type-of-identification-client').val("");
		$('#identification-number-client').val("");		
        $('#fiscal-address').val(" ");
        $('#tax-phone').val(" ");
        $('#email').val(" ");
        $("#header-messages").html("");
        $("#student-messages").html("");
        $("#invoice-messages").html("");
        $("#related-students").html("");
        $("#student-name").html("");
        $("#monthly-payment").html("");
        $("#student-concept").text(" ");
        $("#invoice-lines").text(" ");
        $("#registered-payments").text(" ");
        $("#student-balance").html("");
        $("#total-balance").html("");
		$("#total-general").html("");
		$("#total-general-bolivar").html("");
		$("#invoice-descuento").html("");
        $("#invoice-subtotal").html(" ");
        $("#total-bill").html(" ");
        $('#paid-out').text(" ");
        $('#to-pay').text(" ");
        $('#change').text(" ");
		$('.mensajes-usuario').html("");
		$('.campo-resaltado').css('background-color', "white");
		$('#nota-credito').html("");
		$("#nota-credito").removeClass("noverScreen");
		$("#botones-cuotas").removeClass("noverScreen");
		$("#botones-notas").addClass("noverScreen");
		$('#descuento-recargo').val(null);		
		$('#cantidad-descuento').val(0);
		$("#sub-total-dolar").html("");
		$("#sub-total-euro").html("");
		$("#sub-total-bolivar").html("");
		$("#saldo-favor-dolar").html("");
		$("#saldo-favor-euro").html("");
		$("#saldo-favor-bolivar").html("");
		$("#descuento-recargo-dolar").html("");
		$("#descuento-recargo-euro").html("");
		$("#descuento-recargo-bolivar").html("");
		$("#total-balance-descuento-dolar").html("");
		$("#total-balance-descuento-euro").html("");
		$("#total-balance-descuento-bolivar").html("");
		$("#pagado-dolar").html("");
		$("#pagado-euro").html("");
		$("#pagado-bolivar").html("");
		$("#por-pagar-dolar").html("");
		$("#por-pagar-euro").html("");
		$("#por-pagar-bolivar").html("");
		$("#sobrante-dolar").html("");
		$("#sobrante-euro").html("");
		$("#sobrante-bolivar").html("");

        for (var i = 0, item = 0; i < 7; i++)
        {
            item = i + 1;
            paymentNumber = "0" + item;

            $("#amount-" + paymentNumber).css('background-color', '#ffffff');
            $("#amount-" + paymentNumber).val(0);
			$("#comentario-" + paymentNumber).css('background-color', '#ffffff');
            $('#comentario-' + paymentNumber).val(null);
            
            if (item > 1 && item < 4)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
                $("#account_or_card-" + paymentNumber).css('background-color', '#ffffff');
                $('#account_or_card-' + paymentNumber).val(null);
            }
            else if (item > 3 && item < 6)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
                $("#serial-" + paymentNumber).css('background-color', '#ffffff');
                $('#serial-' + paymentNumber).val(null);
            }
            else if (item == 6)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
                $("#account_or_card-" + paymentNumber).css('background-color', '#ffffff');
                $('#account_or_card-' + paymentNumber).val(null);
                $("#serial-" + paymentNumber).css('background-color', '#ffffff');
                $('#serial-' + paymentNumber).val(null);
            }
            else if (item == 7)
            {
                $("#serial-" + paymentNumber).css('background-color', '#ffffff');
                $('#serial-' + paymentNumber).val(null);
            }
        }    

        studentBalance = 0;
        totalBalance = 0;
		discount = 0;
		discountMode = '';
		discountAmount = 0;
		totalGeneral = 0;
        totalBill = 0;
		invoiceDescuento = 0;
        accumulatedPayment = 0;
        balance = 0;
        balanceIndicator = 0;
		saldoNotaCredito = 0;
		indicadorCompensacion = 0;
		indicador_pedido = 0;

		base_igtf_dolar = 0;
		monto_divisas = 0;
		monto_igtf_dolar = 0;
		monto_igtf_dolar_pedido = 0;
		acumulado_igtf_dolar = 0;
		acumulado_igtf_dolar_archivo = 0;
		acumulado_igtf_euro = 0;
		acumulado_igtf_bolivar = 0;
		total_balance_bolivares_igtf = 0;
		indicador_igtf_recalculado = 0;
		indicadorAjuste = 0;
		indicador_abono = 0;
		familiasRelacionadasAnterior = '';	
		familiasRelacionadas = '';
		idFamiliaPagadoraConsejoAnterior = 0;
		idFamiliaPagadoraConsejo = 0;
		consejoExoneradoAnterior = 0;
		consejoExonerado = 0;
		indicadorConsejoAnterior = false;
		indicadorConsejoActual = false;
		indicadorReciboConsejoAnterior = false;
		indicadorReciboConsejoActual = false;      		
		anioConsejoEducativo = 0;
		proximoAnioConsejoEducativo = 0;
    }
    
    function validateFields()
    {
        if($("#amount-" + paymentIdentifier).val().length < 1) 
        {  
            $("#amount-" + paymentIdentifier).css('background-color', '#f2f2f2');
            alert("El monto es obligatorio");
            return false;
        }
        if($("#bank-" + paymentIdentifier).val().length < 1) 
        {  
            $("#bank-" + paymentIdentifier).css('background-color', '#f2f2f2');
            alert("El nombre del banco emisor es obligatorio");
            return false;
        }
        if($("#banco-receptor-" + paymentIdentifier).val().length < 1) 
        {  
            $("#banco-receptor-" + paymentIdentifier).css('background-color', '#f2f2f2');
            alert("El nombre del banco receptor es obligatorio");
            return false;
        }
        if($("#account_or_card-" + paymentIdentifier).val().length < 1) 
        {  
            $("#account_or_card-" + paymentIdentifier).css('background-color', '#f2f2f2');
            alert("El Nro. de tarjeta o cuenta es obligatorio");
            return false;
        }
        if($("#serial-" + paymentIdentifier).val().length < 1) 
        {  
            $("#serial-" + paymentIdentifier).css('background-color', '#f2f2f2');
            alert("El serial de la transacción es obligatorio");
            return false;
        }
    }
	
	function checkPredeterminado()
	{
		monedaPago = "$";
		$('.check-dolar').attr('checked', true);
		$('.check-dolar').prop('checked', true);
		$('.check-euro').attr('checked', false);
		$('.check-euro').prop('checked', false);
		$('.check-bolivar').attr('checked', false);
		$('.check-bolivar').prop('checked', false);
	}

    function updateAmount()
    {       
        if (deudaMenosPagado > 0)
        {
			aCobrar = deudaMenosPagado;
			aCobrarRetencion = dosDecimales(totalBalanceDescuento * 0.02);
		}
		else
		{
			aCobrar = 0;
		}
		$('#amount-01').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-02').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-03').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-04').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-05').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-06').val(formatoNumero(aCobrar)).css("color", "black");
		$('#amount-07').val(formatoNumero(aCobrarRetencion)).css("color", "black");
	}
	
    function aCobrarEuros()
    {       
        if (deudaMenosPagadoEuros > 0)
        {
			aCobrar = deudaMenosPagadoEuros;
			aCobrarRetencion = dosDecimales(totalBalanceDescuentoEuros * 0.02);
		}
		else
		{
			aCobrar = 0;
		}
		$('#amount-01').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-02').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-03').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-04').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-05').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-06').val(formatoNumero(aCobrar)).css("color", "blue");
		$('#amount-07').val(formatoNumero(aCobrarRetencion)).css("color", "blue");
	}
	
    function aCobrarBolivares()
    {       
        if (deudaMenosPagado > 0)
        {
			aCobrar = deudaMenosPagadoBolivares;
			aCobrarRetencion = dosDecimales(totalBalanceDescuentoBolivares * 0.02);
		}
		else
		{
			aCobrar = 0;
		}
		$('#amount-01').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-02').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-03').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-04').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-05').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-06').val(formatoNumero(aCobrar)).css("color", "red");
		$('#amount-07').val(formatoNumero(aCobrarRetencion)).css("color", "red");
	}
	
	function inicializarCampos()
	{
		$("#amount-" + paymentIdentifier).css('background-color', '#ffffff');
		$("#comentario-" + paymentIdentifier).css('background-color', '#ffffff');
		$('#comentario-' + paymentIdentifier).val(null);
		if (paymentType != 'Efectivo')
		{
			if (paymentType == 'Retención de impuesto')
			{
				$("#serial-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#serial-' + paymentIdentifier).val(null);
			}
			else if (paymentType == 'Tarjeta de débito' || paymentType == 'Tarjeta de crédito')
			{
				$("#bank-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#bank-' + paymentIdentifier).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
				$("#account_or_card-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#account_or_card-' + paymentIdentifier).val(null);
			}
			else if (paymentType == 'Transferencia' || paymentType == 'Depósito')
			{
				$("#bank-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#bank-' + paymentIdentifier).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
				$("#serial-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#serial-' + paymentIdentifier).val(null);
			}
			else
			{
				$("#bank-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#bank-' + paymentIdentifier).val(null);
                $("#banco-receptor-" + paymentNumber).css('background-color', '#ffffff');
                $('#banco-receptor-' + paymentNumber).val(null);
				$("#account_or_card-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#account_or_card-' + paymentIdentifier).val(null);
				$("#serial-" + paymentIdentifier).css('background-color', '#ffffff');
				$('#serial-' + paymentIdentifier).val(null);
			}
		}
    }

	function insertRecord(observacionRecibida)
	{
		let vector_registro_transacciones = new Array();
		let aplicarDescuento = 0;
		if (anoEscolarMensualidad == anoEscolarActual)
		{	
			aplicarDescuento = discountFamily;
		}
		else
		{
			aplicarDescuento = descuentoAnoAnterior;
		}
		vector_registro_transacciones = {
			"dbId" : transactionIdentifier,
        	"dbIdStudent" : idStudent,
        	"dbStudentName" : studentName + " - " + grade,
        	"dbMonthlyPayment" : monthlyPayment,
        	"dbScholarship" : scholarship,
			"dbDescuentoAlumno" : aplicarDescuento,
			"dbMorosoAnoAnterior" : morosoAnoAnterior,
			"dbTasaCambioDolar" : dollarExchangeRate,
			"dbTasaCambioEuro" : euro,
			"dbTarifaDolarOriginal" : tarifaDolar,
			"dbTarifaDolar" : tarifaDolar,
			"dbMontoAbonadoDolar" : montoDolar,
			"dbMontoPendienteDolar" : montoPendienteDolar,
			"dbMontoAPagarDolar" : montoAPagarDolar,
			"dbMontoAPagarEuro" : montoAPagarEuro,
			"dbMontoAPagarBolivar" : montoAPagarBolivar,
        	"dbInvoiced" : invoiced,
        	"dbPartialPayment" : partialPayment,
        	"dbPaidOut" : paidOut,
			"dbSchoolYearFrom" : schoolYearFrom,
			"dbSeleccionada" : false,
        	"dbObservation" : observacionRecibida	};
			
		studentTransactionsArray.push(vector_registro_transacciones);
		
		if (montoPendienteDolar < 0 && monthlyPayment.substring(0, 18) != "Servicio educativo")
		{
			saldoNotaCredito = saldoNotaCredito + montoPendienteDolar;
		}
	}

    function insertRecordPayments() 
	{
		let vector_registro_pagos = new Array();
		
		vector_registro_pagos = {
			payId : accountant,
			payMoneda : monedaPago,
			payPaymentType : paymentType,
			payAmountPaid : montoPagado,
			payMontoIgtfDolar : monto_igtf_dolar,
			payBank : bank,
			payBancoReceptor : bancoReceptor,
			payAccountOrCard : accountOrCard,
			paySerial : serial,
			payComentario : comentario }; 
		
		paymentsArray.push(vector_registro_pagos);
    }
		
	function actualizarPago(id_pago, pago_monto_igtf_dolar) 
    {
		indice_elemento = paymentsArray.findIndex((objeto => objeto.payId == id_pago));
		paymentsArray[indice_elemento].payMontoIgtfDolar = pago_monto_igtf_dolar;
    }
    
    function deletePayment(locIdPayment) 
    {
		indice_elemento = paymentsArray.findIndex((objeto => objeto.payId == locIdPayment));
		paymentsArray.splice(indice_elemento, 1);
	}
 
    function updateRecord(id, seleccionada) 
    {
		indice_elemento = studentTransactionsArray.findIndex((objeto => objeto.dbId == id));
		studentTransactionsArray[indice_elemento].dbSeleccionada = seleccionada;
	}
    
    function updateInstallment(id, updOriginalMontoDolar, updMontoModificadoDolar, updMontoPendienteDolar, updAPagarDolar, updAPagarEuro, updAPagarBolivar, updObservation) 
    {
		indice_elemento = studentTransactionsArray.findIndex((objeto => objeto.dbId == id));

		studentTransactionsArray[indice_elemento].dbTarifaDolarOriginal = updOriginalMontoDolar;
		studentTransactionsArray[indice_elemento].dbTarifaDolar = updMontoModificadoDolar;
		studentTransactionsArray[indice_elemento].dbMontoPendienteDolar = updMontoPendienteDolar;
		studentTransactionsArray[indice_elemento].dbMontoAPagarDolar = updAPagarDolar;
		studentTransactionsArray[indice_elemento].dbMontoAPagarEuro = updAPagarEuro;
		studentTransactionsArray[indice_elemento].dbMontoAPagarBolivar = updAPagarBolivar;
		studentTransactionsArray[indice_elemento].dbObservation = updObservation;
    }
	
    function actualizarPagar(id, actAPagarDolar, actAPagarEuro, actAPagarBolivar, actSeleccionada, actObservacion) 
    {
		indice_elemento = studentTransactionsArray.findIndex((objeto => objeto.dbId == id));

		studentTransactionsArray[indice_elemento].dbMontoAPagarDolar = actAPagarDolar;
		studentTransactionsArray[indice_elemento].dbMontoAPagarEuro = actAPagarEuro;
		studentTransactionsArray[indice_elemento].dbMontoAPagarBolivar = actAPagarBolivar;
		studentTransactionsArray[indice_elemento].dbSeleccionada = actSeleccionada;
		studentTransactionsArray[indice_elemento].dbObservation = actObservacion;
    }

    function showRecords() 
    {	
        var detailLine = "";
        var nextPayment = "";
        var indicatorPaid = 0;
        var firstInstallment = "";
        var lastInstallment = "";
        studentBalance = 0;

		let indicador_julio_moroso = 0;

		for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
		{
			item = studentTransactionsArray[i];

			if (item['dbIdStudent'] == idStudent)
			{
				if (item['dbMorosoAnoAnterior'] == 1)
				{
					if ($('#type-invoice').val() == 'Factura inscripción regulares' || $('#type-invoice').val() == 'Recibo inscripción regulares' || $('#type-invoice').val() == 'Recibo de seguro')
					{
						if (indicador_julio_moroso == 0)
						{
							indicador_julio_moroso = 1;
							alert("Este alumno no se debe inscribir hasta que pague la mensualidad de julio");
						}
					}

				}
			}
		}

		if (estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] == true)
		{
			if ($('#type-invoice').val() == 'Mensualidades')
			{
				alert("Debe alguno de los siguientes conceptos: Matrícula, Agosto, seguro o servicio educativo");
			}
		}
		
		for (var i = 0, item = null, indicador_estudiante_encontrado = 0; i < studentTransactionsArray.length; i++) 
		{
			item = studentTransactionsArray[i];

			if (item['dbIdStudent'] == idStudent)
			{
				if (indicador_estudiante_encontrado == 0)
				{
					if (item['dbScholarship'] == 1)
					{
						if ($('#type-invoice').val() == 'Mensualidades')
						{
							alert("Este alumno es becado, no se le deben cobrar cuotas");
							return false;
						}
					}
					if (item['dbSchoolYearFrom'] < anoEscolarInscripcion && $('#type-invoice').val() == 'Recibo servicio educativo' )
					{
						alert("Este estudiante debe pagar primero la matrícula");
						return false;
					}
					studentName = item['dbStudentName'];
				}
				indicador_estudiante_encontrado = 1;
				
				monthlyPayment = item['dbMonthlyPayment'];

				if (item['dbPaidOut'] == false)
				{					
					if (item['dbSeleccionada'] == true)
					{
						studentBalance = studentBalance + item['dbMontoAPagarDolar'];
						detailLine += "<tr id=tra" + item['dbId'] + "> \
							<td style='background-color:#c2c2d6;'><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbMontoPendienteDolar'] + " checked='checked' disabled></td> \
							<td style='background-color:#c2c2d6;'>" + item['dbMonthlyPayment'] + "</td> \
							<td style='background-color:#c2c2d6;'><input type='text' id=am" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + formatoNumero(item['dbTarifaDolar']) + " disabled></td> \
							<td style='background-color:#c2c2d6;'><input type='text' class='form-control amount-paid' value=" + formatoNumero(item['dbMontoAbonadoDolar']) + " disabled></td>";

						if (item['dbMontoPendienteDolar'] < 0)
						{
							detailLine += 	"<td style='background-color:#c2c2d6; color: red;'>" + formatoNumero(item['dbMontoPendienteDolar']) + "</td> \
											<td style='background-color:#c2c2d6;'><input type='text' id=a_pagar_dolar_" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + item['dbMontoAPagarDolar'] + " disabled></td> \
											<td style='background-color:#c2c2d6; color: red;'>" + formatoNumero(item['dbMontoAPagarEuro']) + "</td> \
											<td style='background-color:#c2c2d6; color: red;'>" + formatoNumero(item['dbMontoAPagarBolivar']) + "</td> \
											<td style='background-color:#c2c2d6; color: red;'>Hacer NC</td> \
											<td><input type='number' class='form-control original-amount noverScreen' value=" + item['dbTarifaDolar'] + "></td><td></td></tr>";
						}
						else
						{
							detailLine += 	"<td style='background-color:#c2c2d6;'>" + formatoNumero(item['dbMontoPendienteDolar']) + "</td> \
											<td style='background-color:#c2c2d6;'><input type='text' id=a_pagar_dolar_" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + item['dbMontoAPagarDolar'] + " disabled></td> \
											<td style='background-color:#c2c2d6; color: blue;'>" + formatoNumero(item['dbMontoAPagarEuro']) + "</td> \
											<td style='background-color:#c2c2d6; color: red;'>" + formatoNumero(item['dbMontoAPagarBolivar']) + "</td> \
											<td style='background-color:#c2c2d6;'>" + item['dbObservation'] + "</td> \
											<td><input type='number' class='form-control original-amount noverScreen' value=" + item['dbTarifaDolar'] + "></td><td></td></tr>";
						}
						
						$('#uncheck-quotas').attr('disabled', false);
						
						if (firstInstallment == "")
						{
							firstInstallment = item['dbMonthlyPayment'];
						}
						lastInstallment = item['dbMonthlyPayment'];
					}
					else
					{
						if (indicatorPaid == 0)
						{
							nextPayment = monthlyPayment;
							indicatorPaid = 1;                            
						}
						detailLine += "<tr id=tra" + item['dbId'] + "> \
							<td><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbMontoPendienteDolar'] + " disabled></td> \
							<td>" + item['dbMonthlyPayment'] + "</td> \
							<td><input type='text' id=am" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + formatoNumero(item['dbTarifaDolar']) + "></td> \
							<td><input type='text' class='form-control amount-paid' value=" + formatoNumero(item['dbMontoAbonadoDolar']) + " disabled></td>";

						if (item['dbMontoPendienteDolar'] < 0)
						{
							detailLine += 	"<td style='color: red;'>" + item['dbMontoPendienteDolar'] + "</td> \
											<td><input type='text' id=a_pagar_dolar_" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + item['dbMontoAPagarDolar'] + "></td> \
											<td style='color: red;'>" + item['dbMontoAPagarEuro'] + "</td> \
											<td style='color: red;'>" + item['dbMontoAPagarBolivar'] + "</td> \
											<td style='color: red;'>Hacer NC</td> \
											<td><input type='number' class='form-control original-amount noverScreen' value=" + item['dbTarifaDolar'] + "></td><td></td></tr>";
						}
						else
						{
							detailLine += 	"<td>" + formatoNumero(item['dbMontoPendienteDolar']) + "</td> \
											<td><input type='text' id=a_pagar_dolar_" + item['dbId'] + " class='form-control modifiable-fee alternative-decimal-separator' value=" + item['dbMontoAPagarDolar'] + "></td> \
											<td style='color: blue;'>" + formatoNumero(item['dbMontoAPagarEuro']) + "</td> \
											<td style='color: red;'>" + formatoNumero(item['dbMontoAPagarBolivar']) + "</td> \
											<td>" + item['dbObservation'] + "</td> \
											<td><input type='number' class='form-control original-amount noverScreen' value=" + item['dbTarifaDolar'] + "></td><td></td></tr>";
						}
					}
				}
			}
		}
		$("#monthly-payment").html(detailLine);
		$(".alternative-decimal-separator").numeric({ altDecimal: "," });
		if (nextPayment == "" && studentBalance == 0)
		{
			disableButtons();
			alert('No existen cuotas a pagar de este alumno');
		}
		else
		{
			habilitaBotones();
			$("#student-name").html(studentName);
			$("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + ')');
			concept = firstInstallment + ' - ' + lastInstallment;
			$("#student-balance").html(formatoNumero(studentBalance));

			$("#mark-quotas").html(nextPayment); 
								
			if (indicadorAjuste == 0)
			{
				$("#mark-quotas").attr('disabled', false);
				$("#adjust-fee").attr('disabled', false);
			}
			else
			{
				deshabilitarBotonesAjuste();
			}
			
			if (saldoNotaCredito < 0)
			{
				$("#nota-credito").html("<spam style='text-align: center; font-size: 18px; color: red;'><b>Estimado usuario no puede facturar hasta que haga una o más notas de crédito por un total de " + -1 * saldoNotaCredito + " $</b></spam>");
				$("#botones-cuotas").addClass("noverScreen");
				$("#print-invoice").attr('disabled', true);
				$("#ajuste-automatico").attr('disabled', true);
				$(".record-payment").attr('disabled', true);
			}
			else if (saldoRepresentante > 0)
			{
				if (indicadorCompensacion == 0)
				{
					$("#nota-credito").html("<spam style='text-align: center; font-size: 18px; color: blue;'><b>Estimado usuario, este representante tiene un saldo a favor/contra de " + saldoRepresentante + " $ ¿Quiere usarlo para compensar el pago de las cuotas?</b></spam>");
					$("#print-invoice").attr('disabled', true);
					$("#ajuste-automatico").attr('disabled', true);
					$(".record-payment").attr('disabled', true);							
					$("#botones-cuotas").addClass("noverScreen");
					$("#botones-notas").removeClass("noverScreen");
					$("#saldo-favor-dolar").html(saldoRepresentanteSigno);
					$("#saldo-favor-euro").html(formatoNumero(saldoRepresentanteSigno / tasaDolarEuro));
					$("#saldo-favor-bolivar").html(formatoNumero(saldoRepresentante * dollarExchangeRate));
				}
			}
		}
    }
	
    function showDatabase() // Para uso del desarrollador
    {
		console.log("showDatabase", studentTransactionsArray);
    }

    function mostrarCuotasSeleccionadas() // Para uso del desarrollador
    {
		for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
		{					
			item = studentTransactionsArray[i];

			if (item['dbSeleccionada'] == true)
			{
				console.log("mostrarCuotasSeleccionadas", item);
			}
		}
    }

    function ajustarCuotas() 
    {
		var posicion_elemento = 0;
		var vector_estudiantes_seleccionados = [];

		if (discountMode == "Porcentaje")
		{
			alert("Estimado usuario, no se puede hacer el ajustar la factura si el descuento es un porcentaje. Por favor cambie el descuento a un monto fijo y después haga el ajuste")
			return false;
		}
		
        confirmar = confirm('Estimado usuario, después que ajuste la factura no podrá realizar cambios. ¿Está seguro de que desea ajustar la factura?');
        if (confirmar == false)
        {
            return false;
        }

		saldoPagosRealizados = dosDecimales(accumulatedPayment + saldoRepresentante - discount - acumulado_igtf_dolar);
		
		totalBalance = 0;
				        				                
		for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
		{					
			item = studentTransactionsArray[i];

			if (item['dbSeleccionada'] == true)
			{
				posicion_elemento = $.inArray(item['dbIdStudent'], vector_estudiantes_seleccionados);

				if (posicion_elemento == -1)
				{ 
					vector_estudiantes_seleccionados.push(item['dbIdStudent']);
				}
				
				if (saldoPagosRealizados == 0)
				{
					updateRecord(item['dbId'], false);
				}
				else if (saldoPagosRealizados < item['dbMontoPendienteDolar'])
				{
					saldoPagosRealizadosEuros = dosDecimales(saldoPagosRealizados / tasaDolarEuro);
					saldoPagosRealizadosBolivares = dosDecimales(saldoPagosRealizados * dollarExchangeRate);
					
					actualizarPagar(item['dbId'], saldoPagosRealizados, saldoPagosRealizadosEuros, saldoPagosRealizadosBolivares, true, 'Abono');
					totalBalance = totalBalance + saldoPagosRealizados;
					saldoPagosRealizados = 0;
					indicadorAjuste = 1;
				}
				else
				{
					saldoPagosRealizados = dosDecimales(saldoPagosRealizados - item['dbMontoPendienteDolar']);
					totalBalance = dosDecimales(totalBalance + item['dbMontoPendienteDolar']);
				}
			}
		}

		if (saldoPagosRealizados > 0)
		{
			let cuota_no_seleccionada = 0;
			for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
			{					
				item = studentTransactionsArray[i];
				if (item['dbSeleccionada'] == false)
				{
					cuota_no_seleccionada = 1;
					break;
				}
			}
			
			if (cuota_no_seleccionada == 0)
			{
				indicadorNoCuotas = 1;
				alert("No hay cuotas disponibles para ajustar la factura");
				return false;
			}
			else
			{               
				for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
				{					
					item = studentTransactionsArray[i];
					if (item['dbSeleccionada'] == false)
					{
						posicion_elemento = $.inArray(item['dbIdStudent'], vector_estudiantes_seleccionados);

						if (posicion_elemento != -1)
						{									
							if (saldoPagosRealizados >= item['dbMontoPendienteDolar']) 
							{
								updateRecord(item['dbId'], true);
								saldoPagosRealizados = dosDecimales(saldoPagosRealizados - item['dbMontoPendienteDolar']);
								totalBalance = dosDecimales(totalBalance + item['dbMontoPendienteDolar']);
							}
							else if (saldoPagosRealizados > 0 && saldoPagosRealizados < item['dbMontoPendienteDolar'])
							{
								saldoPagosRealizadosEuros = dosDecimales(saldoPagosRealizados / tasaDolarEuro);
								saldoPagosRealizadosBolivares = dosDecimales(saldoPagosRealizados * dollarExchangeRate);
								
								actualizarPagar(item['dbId'], saldoPagosRealizados, saldoPagosRealizadosEuros, saldoPagosRealizadosBolivares, true, 'Abono');
								totalBalance = totalBalance + saldoPagosRealizados;
								saldoPagosRealizados = 0;
								indicadorAjuste = 1;
							}
						}
					}
				}

				if (saldoPagosRealizados > 0)
				{
					alert("No hay cuotas disponibles para ajustar la factura");
					return false;
				}
				else
				{
					showRecords();
					actualizarTotales();
				}
			}
		}
		else
		{
			showRecords();
			actualizarTotales();
		}
    }
			
    function showPayments() // Para uso del desarrollador
    {
		console.log("showPayments", paymentsArray);
	}

    function buscarMoneda(idPago) 
    {
        var detailLine = "";

		indice_elemento = paymentsArray.findIndex((objeto => objeto.payId == idPago));

		item = paymentsArray[indice_elemento];
		
		monedaPagoEliminar = item['payMoneda'];
										
		if (monedaPagoEliminar == "$")
		{
			montoPagadoDolar = montoPagado;
			montoPagadoEuro = dosDecimales(montoPagado / tasaDolarEuro);
			montoPagadoBolivar = dosDecimales(montoPagado * dollarExchangeRate);
		}
		else if (monedaPagoEliminar == "€")
		{
			montoPagadoDolar = dosDecimales(montoPagado * tasaDolarEuro);
			montoPagadoEuro = montoPagado;
			montoPagadoBolivar = dosDecimales(montoPagado * euro);
		}
		else
		{
			montoPagadoDolar = dosDecimales(montoPagado / dollarExchangeRate);
			montoPagadoEuro = dosDecimales(montoPagado / euro);
			montoPagadoBolivar = montoPagado;
		}
											
		accumulatedPayment -= dosDecimales(montoPagadoDolar);	
		acumuladoPagadoEuros -= dosDecimales(montoPagadoEuro);
		acumuladoPagadoBolivares -= dosDecimales(montoPagadoBolivar);

		if (indicador_pedido == 0 && indicadorConsejoEducativo == 0)
		{
			acumulado_igtf_dolar = dosDecimales(acumulado_igtf_dolar - item['payMontoIgtfDolar']);
			acumulado_igtf_euro = dosDecimales(acumulado_igtf_dolar / tasaDolarEuro);
			acumulado_igtf_bolivar = dosDecimales(acumulado_igtf_dolar * dollarExchangeRate);
		}
		
		monto_divisas = dosDecimales(monto_divisas - item['payMontoIgtfDolar']);
		acumulado_igtf_dolar_archivo = dosDecimales(acumulado_igtf_dolar_archivo - item['payMontoIgtfDolar']);
		
		actualizarTotales();		
    }

    function printPayments()
    {
        linePayments = " ";
	        
        linePayments += "<tr id=pa" + accountant + "> \
            <td><button id=p" + accountant + " name='" + paymentType + "' value=" + montoPagado + " class='registeredPayments glyphicon glyphicon-trash'></button></td> \
			<td style='text-align: center;'>" + paymentType + "</td>";
			
		if (monedaPago == "$")
		{
			linePayments += "<td style='text-align: center;'>" + monedaPago + "</td><td style='text-align: center;'>" + formatoNumero(montoPagado) + "</td>";
		}
		else if (monedaPago == "€")
		{
			linePayments += "<td style='color: blue; text-align: center;'>" + monedaPago + "</td><td style='color: blue; text-align: center;'>" + formatoNumero(montoPagado) + "</td>";
		}
		else
		{
			linePayments += "<td style='color: red; text-align: center;'>" + monedaPago + "</td><td style='color: red; text-align: center;'>" + formatoNumero(montoPagado) + "</td>";
		}
		
		linePayments +=
            "<td style='text-align: center;'>" + bank + "</td> \
			<td style='text-align: center;'>" + bancoReceptor + "</td> \
            <td style='text-align: center;'>" + accountOrCard + "</td> \
            <td style='text-align: center;'>" + serial + "</td> \
			<td style='text-align: left;'>" + comentario + "</td></tr>";
			
        $("#registered-payments").append(linePayments);
        
        insertRecordPayments();
        
        accountant++;
    }
    
    function activarBotonesPago()
    {
        $("#bt-01").attr('disabled', false);
        $("#bt-02").attr('disabled', false);
        $("#bt-03").attr('disabled', false);
        $("#bt-04").attr('disabled', false);
        $("#bt-05").attr('disabled', false);
        $("#bt-06").attr('disabled', false);
        $("#bt-07").attr('disabled', false);
    }
	
    function desactivarBotonesPago()
    {
        $("#bt-01").attr('disabled', true);
        $("#bt-02").attr('disabled', true);
        $("#bt-03").attr('disabled', true);
        $("#bt-04").attr('disabled', true);
        $("#bt-05").attr('disabled', true);
        $("#bt-06").attr('disabled', true);
        $("#bt-07").attr('disabled', true);
    }

    function uploadTransactions()
    {
		biggestYearFrom = schoolYearFrom;
		
		var idCuotaAbono = 0;
		var idCuotaExonerada = 0;
		var diferenciaBolivaresDividida = diferenciaBolivares;
		var diferenciaUltimoElemento = diferenciaBolivares;
		var diferenciaBolivaresTotal = diferenciaBolivares;
		var cantidadElementos = 0;
		var contadorElementos = 1;

		if (indicadorConsejoEducativo == 1)
		{
			tbStudentTransactions[transactionCounter] = new Object();
			tbStudentTransactions[transactionCounter].studentName = "";
			tbStudentTransactions[transactionCounter].transactionIdentifier = 999999;
			tbStudentTransactions[transactionCounter].descuentoAlumno = 0;
			tbStudentTransactions[transactionCounter].tarifaDolarOriginal = 0;
			tbStudentTransactions[transactionCounter].tarifaDolar = tarifaDolar;
			tbStudentTransactions[transactionCounter].monthlyPayment = "Consejo Educativo "+anioConsejoEducativo+"-"+proximoAnioConsejoEducativo;
			tbStudentTransactions[transactionCounter].montoAPagarDolar = totalBalance;
			tbStudentTransactions[transactionCounter].montoAPagarEuro = totalBalanceEuros;
			tbStudentTransactions[transactionCounter].montoAPagarBolivar = totalBalanceBolivares;
			tbStudentTransactions[transactionCounter].observation = ""; 
			biggestYearFrom = parseInt(anioConsejoEducativo);	
		}
		else
		{				
			for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
			{
				item = studentTransactionsArray[i];

				if (item['dbSeleccionada'] == true)
				{
					cantidadElementos++;
				}
			}

			for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
			{
				item = studentTransactionsArray[i];

				if (item['dbSeleccionada'] == true)
				{
					if (item['dbObservation'] == 'Abono')
					{
						idCuotaAbono = item['dbId'];
					}
					
					if (item['dbObservation'] == '(Exonerado)')
					{
						idCuotaAbono = item['dbId'];
						cantidadElementos -= 1;
					}
				}
			}
			
			if (cantidadElementos > 1)
			{
				diferenciaBolivaresDividida = dosDecimales(diferenciaBolivares / cantidadElementos);
				diferenciaUltimoElemento = diferenciaBolivaresDividida;
				
				diferenciaBolivaresTotal = dosDecimales(diferenciaBolivaresDividida * cantidadElementos);
				
				if (diferenciaBolivares != diferenciaBolivaresTotal)
				{
					diferenciaUltimoElemento = dosDecimales(diferenciaUltimoElemento + (diferenciaBolivares - diferenciaBolivaresTotal));
				}
			}
			
			for (var i = 0, item = null; i < studentTransactionsArray.length; i++) 
			{
				item = studentTransactionsArray[i];

				if (item['dbSeleccionada'] == true)
				{
					tbStudentTransactions[transactionCounter] = new Object();
					tbStudentTransactions[transactionCounter].studentName = item['dbStudentName'];
					tbStudentTransactions[transactionCounter].transactionIdentifier = item['dbId'];
					tbStudentTransactions[transactionCounter].descuentoAlumno = item['dbDescuentoAlumno'];
					tbStudentTransactions[transactionCounter].tarifaDolarOriginal = item['dbTarifaDolarOriginal'];
					tbStudentTransactions[transactionCounter].tarifaDolar = item['dbTarifaDolar'];
					tbStudentTransactions[transactionCounter].monthlyPayment = item['dbMonthlyPayment'];
					tbStudentTransactions[transactionCounter].montoAPagarDolar = dosDecimales(item['dbMontoAPagarDolar']);
					tbStudentTransactions[transactionCounter].montoAPagarEuro = dosDecimales(item['dbMontoAPagarEuro']);
					
					if (item['Observation'] == '(Exonerado')
					{
						tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar']);	
					}
					else if (cantidadElementos == 1)
					{
						tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar'] + diferenciaBolivares);
					}
					else if (idCuotaAbono > 0)
					{
						if (item['dbId'] == idCuotaAbono)
						{
							tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar'] + diferenciaBolivares);
						}
						else
						{
							tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar']);	
						}													
					}
					else
					{
						if (contadorElementos == cantidadElementos)
						{
							tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar'] + diferenciaUltimoElemento);
						}
						else
						{
							tbStudentTransactions[transactionCounter].montoAPagarBolivar = dosDecimales(item['dbMontoAPagarBolivar'] + diferenciaBolivaresDividida);
						}
					}
					contadorElementos++;
										
					tbStudentTransactions[transactionCounter].observation = item['dbObservation']; 	
					
					transactionCounter++;
					
					if (item['dbMonthlyPayment'].substring(0, 9) == "Matrícula")
					{
						biggestYearFrom = parseInt(item['dbMonthlyPayment'].substring(10, 14));
					}
					if (item['dbScholarship'] == 1 || item['dbDescuentoAlumno'] < 1)
					{
						cuotasAlumnoBecado++;
					}
				}
			}
		}
		biggestYearUntil = biggestYearFrom + 1;
		payments.schoolYear = "Año escolar " + biggestYearFrom + "-" + biggestYearUntil;
    }

    function loadPayments()
    {                
		for (var i = 0, item = null; i < paymentsArray.length; i++) 
		{
			item = paymentsArray[i];
			
			if (item['payPaymentType'] != "Cambio")
			{
				tbPaymentsMade[accountPaid] = new Object();

				tbPaymentsMade[accountPaid].id = item['payId'];
				tbPaymentsMade[accountPaid].moneda = item['payMoneda'];
				tbPaymentsMade[accountPaid].paymentType = item['payPaymentType'];
				tbPaymentsMade[accountPaid].amountPaid = item['payAmountPaid'];
				tbPaymentsMade[accountPaid].monto_igtf_dolar = item['payMontoIgtfDolar'];
				tbPaymentsMade[accountPaid].bank = item['payBank'];
				tbPaymentsMade[accountPaid].bancoReceptor = item['payBancoReceptor'];
				tbPaymentsMade[accountPaid].accountOrCard = item['payAccountOrCard'];
				tbPaymentsMade[accountPaid].serial = item['paySerial'];
				tbPaymentsMade[accountPaid].comentario = item['payComentario'];
				tbPaymentsMade[accountPaid].idTurn = $("#Turno").attr('value');
				tbPaymentsMade[accountPaid].family = nameFamily;
				accountPaid++;						
			}
		}
		
		payments.cuotasAlumnoBecado = cuotasAlumnoBecado;
		
		var stringStudentTransactions = JSON.stringify(tbStudentTransactions);
						
		var stringPaymentsMade = JSON.stringify(tbPaymentsMade);

		cleanPager();
		
		$.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "recordInvoiceData"]); ?>', {headboard : payments, studentTransactions : stringStudentTransactions, paymentsMade : stringPaymentsMade }); 
    }

    function listFamilies(newFamily)
    {	
        $.post('<?php echo Router::url(["controller" => "Students", "action" => "everyFamily"]); ?>', {"newFamily" : newFamily}, null, "json")
            
        .done(function(response) 
        {
            if (response.success) 
            {
                var output = " "; 
                $.each(response.data.families, function(key, value) 
                {
                    $.each(value, function(userkey, uservalue) 
                    {
                        if (userkey == 'id')
						{
                            output += "<tr id=fa" + uservalue + " class='family'><td>";
						}
						else if (userkey == 'family')
						{
                            output += uservalue + " (";
						}
                        else if (userkey == 'surname')
						{
                            output += uservalue + " ";
						}
                        else
						{
                            output += uservalue + ")</td></tr>";
						}
                    });
                });
                $("#header-messages").html("");
                $("#response-container").html(output);
            } 
            else 
            {
				$("#header-messages").html("");
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
            }
                
        })
        .fail(function(jqXHR, textStatus, errorThrown) 
		{
			$("#header-messages").html("");        
            $("#response-container").html("Algo ha fallado: " + textStatus);
                
        });
    }
	
	function validarDatosFiscales()
	{
		var resultado = 0;
		
		$('.mensajes-usuario').html("");
		$('.campo-resaltado').css('background-color', "white");
		
		if ($("#client").val().length < 5) 
		{  		
			$('#client').css('background-color', "#ffffe6");
			$('#mensaje-cliente').html("El nombre o razón social está incompleto").css('color', 'red');
			resultado = 1;
		}

		if ($("#type-of-identification-client").val().length == 0) 
		{  		
			$('#type-of-identification-client').css('background-color', "#ffffe6");
			$('#mensaje-tipo-de-identificacion').html("El tipo de identificacion no puede ser blancos").css('color', 'red');
			resultado = 1;
		}
		else
		{
			if ($("#type-of-identification-client").val() == "J" || $("#type-of-identification-client").val() == "G") 
			{
				if ($("#identification-number-client").val().length < 9) 
				{	
					$('#identification-number-client').css('background-color', "#ffffe6");
					$('#mensaje-numero-identificacion-cliente').html("El número del RIF está incompleto").css('color', 'red');
					resultado = 1;
				}
			}
			else
			{
				if ($("#identification-number-client").val().length < 7) 
				{	
					$('#identification-number-client').css('background-color', "#ffffe6");
					$('#mensaje-numero-identificacion-cliente').html("El número de cédula o pasaporte está incompleto").css('color', 'red');
					resultado = 1;
				}				
			}	
		}
		if ($("#fiscal-address").val().length < 10) 
		{	
			$('#fiscal-address').css('background-color', "#ffffe6");
			$('#mensaje-direccion-fiscal').html("La dirección está incompleta").css('color', 'red');
			resultado = 1;
		}	

		if ($("#tax-phone").val().length < 10) 
		{	
			$('#tax-phone').css('background-color', "#ffffe6");
			$('#mensaje-telefono').html("El número de teléfono está incompleto").css('color', 'red');
			resultado = 1;
		}
		return resultado;
	}
	
	function actualizarTotales()
	{
		signoDescuento = 1;
		descuentoPrevio = 0;
		
		$("#student-balance").html(formatoNumero(studentBalance));
		$("#total-balance").html(formatoNumero(totalBalance));
		
		let sub_total_igtf = 0;

		if (indicador_pedido == 0 && indicadorConsejoEducativo == 0)
		{
			sub_total_igtf = dosDecimales(totalBalance * porcentaje_calculo_igtf);
		}

		$("#sub_total_igtf").html(formatoNumero(sub_total_igtf));
		$("#total_con_igtf").html(formatoNumero(dosDecimales(totalBalance + sub_total_igtf)));

		totalBalanceEuros = dosDecimales(totalBalance / tasaDolarEuro);
		totalBalanceBolivares = dosDecimales(totalBalance * dollarExchangeRate);
		total_balance_bolivares_igtf = dosDecimales((totalBalance + acumulado_igtf_dolar) * dollarExchangeRate);
	
		$("#sub-total-dolar").html(formatoNumero(totalBalance));
		$("#sub-total-euro").html(formatoNumero(totalBalanceEuros));
		$("#sub-total-bolivar").html(formatoNumero(totalBalanceBolivares));
				
		if (discountMode == 'Porcentaje')
		{
			if (discountAmount < 0)
			{
				signoDescuento = -1;
				descuentoPrevio = dosDecimales(discountAmount * signoDescuento);
			}
			else
			{
				descuentoPrevio = discountAmount;
			}
			discount = dosDecimales(totalBalance * descuentoPrevio);
			discount = dosDecimales(discount * signoDescuento);
		}
		else
		{
			discount = discountAmount;		
		}
		
		descuentoEuros = dosDecimales(discount / tasaDolarEuro);
		descuentoBolivares = dosDecimales(discount * dollarExchangeRate);
						
		$("#descuento-recargo-dolar").html(formatoNumero(discount));
		$("#descuento-recargo-euro").html(formatoNumero(descuentoEuros));
		$("#descuento-recargo-bolivar").html(formatoNumero(descuentoBolivares));

		$("#igtf_dolar").html(formatoNumero(acumulado_igtf_dolar));
		$("#igtf_euro").html(formatoNumero(acumulado_igtf_euro));
		$("#igtf_bolivar").html(formatoNumero(acumulado_igtf_bolivar));

		balanceDescuento = dosDecimales(totalBalance + discount + acumulado_igtf_dolar);
		totalBalanceDescuento = dosDecimales(totalBalance - saldoRepresentante + discount + acumulado_igtf_dolar);

		balanceDescuentoEuros = dosDecimales(balanceDescuento / tasaDolarEuro);
		totalBalanceDescuentoEuros = dosDecimales(totalBalanceDescuento / tasaDolarEuro);

		balanceDescuentoBolivares = dosDecimales(total_balance_bolivares_igtf + descuentoBolivares);
		totalBalanceDescuentoBolivares = dosDecimales(total_balance_bolivares_igtf - saldoRepresentanteBolivares + descuentoBolivares);
		
		$("#total-balance-descuento-dolar").html(formatoNumero(totalBalanceDescuento));
		$("#total-balance-descuento-euro").html(formatoNumero(totalBalanceDescuentoEuros));
		$("#total-balance-descuento-bolivar").html(formatoNumero(totalBalanceDescuentoBolivares));
		
		$('#pagado-dolar').html(formatoNumero(accumulatedPayment));
		$('#pagado-euro').html(formatoNumero(acumuladoPagadoEuros));
		$('#pagado-bolivar').html(formatoNumero(acumuladoPagadoBolivares));
		
		deudaMenosPagado = dosDecimales(totalBalanceDescuento - accumulatedPayment);
		deudaMenosPagadoEuros = dosDecimales(deudaMenosPagado / tasaDolarEuro);
		deudaMenosPagadoBolivares = dosDecimales(totalBalanceDescuentoBolivares - acumuladoPagadoBolivares);

		if (deudaMenosPagado > 0)
		{
			porPagar = deudaMenosPagado;
			sobrante = 0;
		}
		else if (deudaMenosPagado < 0)
		{
			porPagar = 0;
			if (saldoRepresentante < balanceDescuento)
			{
				sobrante = dosDecimales(deudaMenosPagado * -1);
			}
			else
			{
				sobrante = 0;
			}
		}
		else
		{
			porPagar = 0;
			sobrante = 0;
		}
		
		porPagarEuros = dosDecimales(porPagar / tasaDolarEuro);
		sobranteEuros = dosDecimales(sobrante / tasaDolarEuro);
			
		if (deudaMenosPagadoBolivares > 0)
		{
			porPagarBolivares = deudaMenosPagadoBolivares;
			sobranteBolivares = 0;
		}
		else if (deudaMenosPagadoBolivares < 0)
		{
			porPagarBolivares = 0;
			if (saldoRepresentanteBolivares < balanceDescuentoBolivares)
			{
				sobranteBolivares = dosDecimales(deudaMenosPagadoBolivares * -1);
			}
			else
			{
				sobranteBolivares = 0;
			}
		}
		else
		{
			porPagarBolivares = 0;
			sobranteBolivares = 0;
		}
		
		$('#por-pagar-dolar').html(formatoNumero(porPagar));
		$('#por-pagar-euro').html(formatoNumero(porPagarEuros));
		$('#por-pagar-bolivar').html(formatoNumero(porPagarBolivares));				
		
		$('#sobrante-dolar').html(formatoNumero(sobrante));
		$('#sobrante-euro').html(formatoNumero(sobranteEuros));
		$('#sobrante-bolivar').html(formatoNumero(sobranteBolivares));
			
		checkPredeterminado();
		updateAmount();

		if (indicadorConsejoEducativo == 1)
		{
			$("#print-invoice").attr('disabled', false);
		}
		else
		{
			if (contadorCuotasSeleccionadas > 0)
			{
				$("#ajuste-automatico").attr('disabled', false);
				$("#print-invoice").attr('disabled', false);
			}
			else
			{
				$("#ajuste-automatico").attr('disabled', true);
				$("#print-invoice").attr('disabled', true);			
			}
		}

		if (totalBalanceDescuento > 0)
		{
			activarBotonesPago();
		}
		else
		{
			desactivarBotonesPago();
		}
	}
	
	function guardarFactura()
	{		
		$("#invoice-messages").html("Por favor espere...");
		payments.idTurn = $("#Turno").attr('value');
		payments.idParentsandguardians = idParentsandguardians;
		payments.invoiceDate = reversedDate;
		payments.client = $('#client').val();
		payments.typeOfIdentificationClient = $('#type-of-identification-client').val();
		payments.identificationNumberClient = $('#identification-number-client').val();;
		payments.fiscalAddress = $('#fiscal-address').val();
		payments.taxPhone = $('#tax-phone').val();

		if (indicadorConsejoEducativo == 1)
		{
			payments.invoiceAmount = totalBalance;
		}
		else
		{
			if (deudaMenosPagadoBolivares == 0)
			{
				payments.invoiceAmount = dosDecimales(totalBalance * dollarExchangeRate);
			}
			else
			{
				if (deudaMenosPagadoBolivares < 0)
				{
					diferenciaSinSigno = deudaMenosPagadoBolivares * -1;
				}
				else
				{
					diferenciaSinSigno = deudaMenosPagadoBolivares;
				}
				
				if (diferenciaSinSigno < dosDecimales(0.01 * dollarExchangeRate))
				{
					diferenciaBolivares = deudaMenosPagadoBolivares * -1;
					payments.invoiceAmount = dosDecimales((totalBalance * dollarExchangeRate) + diferenciaBolivares);
				}
				else
				{
					payments.invoiceAmount = dosDecimales(totalBalance * dollarExchangeRate);
				}
			}
		}
								
		payments.discount = descuentoBolivares; 
		
		if ($('#type-invoice').val() == 'Recibo inscripción regulares' || $('#type-invoice').val() == 'Recibo inscripción nuevos' || $('#type-invoice').val() == 'Recibo servicio educativo' || $('#type-invoice').val() == 'Recibo de seguro' || indicador_pedido == 1 || indicadorConsejoEducativo == 1)
		{
			payments.fiscal = 0;
		}
		else
		{
			payments.fiscal = 1;
		}

		payments.tasaDolar = dollarExchangeRate;
		payments.tasaEuro = euro;
		payments.tasaDolarEuro = dosDecimales(tasaDolarEuro);
		if (saldoRepresentante > totalBalance)
		{
			payments.saldoCompensado = totalBalance;
		}
		else
		{
			payments.saldoCompensado = saldoRepresentante;		
		}
		payments.sobrante = sobrante;
		payments.imprimirReciboSobrante = imprimirReciboSobrante;
		payments.tasaTemporalDolar = tasaTemporalDolar;
		payments.tasaTemporalEuro = tasaTemporalEuro;
		payments.cambioMontoCuota = cambioMontoCuota;
		payments.monto_divisas = monto_divisas;
		payments.monto_igtf = acumulado_igtf_dolar_archivo;
		payments.indicador_pedido = indicador_pedido;
		payments.indicadorConsejoEducativo = indicadorConsejoEducativo;
		
		uploadTransactions();
		loadPayments();
	}

	function verificar_impuestos(proxima_funcion_a_ejecutar, indicador_sobrante)
	{
		if (indicador_igtf_recalculado == 0 && acumulado_igtf_dolar_archivo > 0)
		{
			var todos_los_pagos = "SELECT * FROM payments";
			var pagos_en_divisas = 0;
			var pagos_en_bolivares = 0;
			var saldo_igtf_dolar = 0;
			var saldo_igtf_euro = 0;
			var saldo_igtf_bolivar = 0;
			var recalculo_divisas = monto_divisas; 
			var recalculo_igtf_dolar = acumulado_igtf_dolar;
			var recalculo_igtf_bolivar = acumulado_igtf_bolivar;
								
			// Aquí hay un error porque se está considerando que el dólar tiene el mismo valor que el euro. Se debe desglosar y hacer la conversión de monedas de euros a dolares
			for (var i = 0, item = null; i < paymentsArray.length; i++) 
			{
				item = paymentsArray[i];
				if (item['payMoneda'] == "$" || item['payMoneda'] == "€")
				{
					pagos_en_divisas += item['payAmountPaid'];
				}
				else
				{
					pagos_en_bolivares += item['payAmountPaid'];
				}
			}

			if (indicador_sobrante == 0)
			{
				recalculo_divisas = pagos_en_divisas;
				recalculo_igtf_dolar = dosDecimales(pagos_en_divisas * porcentaje_calculo_igtf);
				recalculo_igtf_bolivar = dosDecimales(recalculo_igtf_dolar * dollarExchangeRate);
			}

			if (pagos_en_bolivares < recalculo_igtf_bolivar)
			{
				if (indicador_sobrante == 0 && indicador_pedido == 0 && indicadorConsejoEducativo == 0)
				{
					recalculo_divisas = dosDecimales(pagos_en_divisas/porcentaje_calculo_base_igtf);
					recalculo_igtf_dolar = dosDecimales((pagos_en_divisas/porcentaje_calculo_base_igtf) * porcentaje_calculo_igtf);
				}

				if (indicador_pedido == 0 && indicadorConsejoEducativo == 0)
				{
					saldo_igtf_dolar = recalculo_igtf_dolar;
					for (var i = 0, item = null; i < paymentsArray.length; i++) 
					{
						item = paymentsArray[i];
						if (item['payMoneda'] == "$")
						{
							monto_igtf_dolar = dosDecimales(item['payAmountPaid'] * porcentaje_calculo_igtf)
							if (saldo_igtf_dolar < monto_igtf_dolar)
							{
								actualizarPago(item['payId'], saldo_igtf_dolar);
								saldo_igtf_dolar -= saldo_igtf_dolar; 		
							}	
							else
							{
								actualizarPago(item['payId'], monto_igtf_dolar);
								saldo_igtf_dolar -= monto_igtf_dolar; 
							}
						}
						else if (item['payMoneda'] == "€")
						{
							monto_igtf_euro = dosDecimales(item['payAmountPaid'] * porcentaje_calculo_igtf);
							monto_igtf_dolar = dosDecimales((item['payAmountPaid'] * porcentaje_calculo_igtf) * tasaDolarEuro);
							saldo_igtf_euro = dosDecimales(saldo_igtf_dolar/tasaDolarEuro);
							if (saldo_igtf_euro < monto_igtf_euro)
							{
								actualizarPago(item['payId'], saldo_igtf_euro);
								saldo_igtf_dolar -= saldo_igtf_dolar; 		
							}	
							else
							{
								actualizarPago(item['payId'], monto_igtf_euro);
								saldo_igtf_dolar -= monto_igtf_dolar; 
							}
						}
						else
						{
							actualizarPago(item['payId'], 0);
						}
					}
				} 
			}
			else
			{
				if (indicador_pedido == 0 && indicadorConsejoEducativo == 0)
				{
					saldo_igtf_bolivar = recalculo_igtf_bolivar;
					for (var i = 0, item = null; i < paymentsArray.length; i++) 
					{
						item = paymentsArray[i];								
						
						if (item['payMoneda'] == "Bs.")
						{
							if (saldo_igtf_bolivar > item['payAmountPaid'])
							{
								actualizarPago(item['payId'], item['payAmountPaid']);
								saldo_igtf_bolivar -= item['payAmountPaid']; 		
							}	
							else
							{
								actualizarPago(item['payId'], saldo_igtf_bolivar);
								saldo_igtf_bolivar -= saldo_igtf_bolivar;
							}	
						}
						else
						{
							actualizarPago(item['payId'], 0);
						}
					}
				} 
			}
			if (indicador_sobrante == 0)
			{
				monto_divisas = recalculo_divisas;
				acumulado_igtf_dolar_archivo = recalculo_igtf_dolar;

				if (indicador_pedido == 0 && indicadorConsejoEducativo == 0)
				{
					acumulado_igtf_dolar = recalculo_igtf_dolar;
					acumulado_igtf_euro = dosDecimales(acumulado_igtf_dolar / tasaDolarEuro);
					acumulado_igtf_bolivar = dosDecimales(acumulado_igtf_dolar * dollarExchangeRate);
				}
			}
			indicador_igtf_recalculado = 1;
			proxima_funcion_a_ejecutar();
		}
		else
		{
			proxima_funcion_a_ejecutar();
		}
	}
	
	function actualizarDescuentos()
	{
		discountMode = "Fijo";
		discountAmount = 0;
		
		if ($('#cantidad-descuento').val() < 0)
		{
			alert("Estimado usuario debe escribir una cantidad mayor a cero");
			return false;	
		}		
		else if ($('#cantidad-descuento').val() == "" || $('#cantidad-descuento').val() == 0)
		{
			actualizarTotales();
		}
		else if ($('#descuento-recargo').val() === "")
		{
			alert("Estimado usuario debe seleccionar el tipo de descuento o recargo");
			return false;				
		}
		else if ($('#descuento-recargo').val() == "Descuento $")
		{						
			discountMode = "Fijo";
			discountAmount = dosDecimales(parseFloat($('#cantidad-descuento').val()) * -1);
			actualizarTotales();	
		}
		else if ($('#descuento-recargo').val() == "Descuento %")
		{
			discountMode = "Porcentaje";
			discountAmount = dosDecimales((parseFloat($('#cantidad-descuento').val()) / 100) * -1);
			actualizarTotales();
		}	
		else if ($('#descuento-recargo').val() == "Recargo $")
		{						
			discountMode = "Fijo";
			discountAmount = dosDecimales(parseFloat($('#cantidad-descuento').val()));
			actualizarTotales();	
		}
		else if ($('#descuento-recargo').val() == "Recargo %")
		{
			discountMode = "Porcentaje";
			discountAmount = dosDecimales(parseFloat($('#cantidad-descuento').val()) / 100);
			actualizarTotales();
		}	
	}
	
	function formatoNumero(num) 
	{
		if (!num || num == 'NaN') return '0,00';
		if (num == 'Infinity') return '&#x221e;';
		num = num.toString().replace(/\$|\,/g, '');
		if (isNaN(num))
			num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num * 100 + 0.50000000001);
		cents = num % 100;
		num = Math.floor(num / 100).toString();
		if (cents < 10)
			cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
			num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
		return (((sign) ? '' : '-') + num + ',' + cents);
	}
		
	function dosDecimales(numero)
	{
		return Number(Math.round(numero+'e'+2)+'e-'+2);
	}
	
	function eliminarComa(cadenaRecibida)
	{
		var indicadorNoPuntos = 0;
		var cadena = "";
		var cadenaConvertida = "";
	
		if (cadenaRecibida.indexOf(",") != -1)
		{	
			cadena = cadenaRecibida;
			
			while (indicadorNoPuntos < 1)
			{
				if (cadena.indexOf(".") != -1)
				{
					cadenaConvertida = cadena.replace(".", "");
					cadena = cadenaConvertida;
				}
				else
				{
					indicadorNoPuntos = 1
					if (cadenaConvertida == "")
					{
						cadenaConPuntoDecimal = cadena.replace(",", ".");
					}
					else
					{
						cadenaConPuntoDecimal = cadenaConvertida.replace(",", ".");
					}
				}
			}
		}
		else
		{
			cadenaConPuntoDecimal = cadenaRecibida;
		}
		return cadenaConPuntoDecimal;	
	}
	function procesarPago()
	{
		base_igtf_dolar = 0;
		monto_igtf_dolar = 0;
		monto_igtf_dolar_pedido = 0;

		if (monedaPago == "$")
		{
			base_igtf_dolar = montoPagado;
		}
		else if (monedaPago == "€")
		{
			base_igtf_dolar = dosDecimales(montoPagado / tasaDolarEuro);
		}

		if (base_igtf_dolar > 0)
		{
			if (base_igtf_dolar > deudaMenosPagado)
			{
				base_igtf_dolar = deudaMenosPagado;		
			}
			else if (base_igtf_dolar <= acumulado_igtf_dolar)
			{
				base_igtf_dolar = 0;							
			}

			if (indicadorConsejoEducativo == 0)
			{
				if (indicador_pedido == 1)
				{
					monto_igtf_dolar_pedido = dosDecimales(base_igtf_dolar * porcentaje_calculo_igtf);
					monto_divisas = dosDecimales(monto_divisas + base_igtf_dolar);
					acumulado_igtf_dolar_archivo = dosDecimales(acumulado_igtf_dolar_archivo + monto_igtf_dolar_pedido);

				}
				else
				{
					monto_igtf_dolar = dosDecimales(base_igtf_dolar * porcentaje_calculo_igtf);
					acumulado_igtf_dolar = dosDecimales(acumulado_igtf_dolar + monto_igtf_dolar);
					acumulado_igtf_euro = dosDecimales(acumulado_igtf_dolar / tasaDolarEuro);
					acumulado_igtf_bolivar = dosDecimales(acumulado_igtf_dolar * dollarExchangeRate);
					monto_divisas = dosDecimales(monto_divisas + base_igtf_dolar);
					acumulado_igtf_dolar_archivo = dosDecimales(acumulado_igtf_dolar_archivo + monto_igtf_dolar);
				}
			}
		}

		if (monedaPago == "$")
		{
			montoPagadoDolar = montoPagado;
			montoPagadoEuro = dosDecimales(montoPagado / tasaDolarEuro);
			montoPagadoBolivar = dosDecimales(montoPagado * dollarExchangeRate);
		}
		else if (monedaPago == "€")
		{
			montoPagadoDolar = dosDecimales(montoPagado * tasaDolarEuro);
			montoPagadoEuro = montoPagado;
			montoPagadoBolivar = dosDecimales(montoPagado * euro);
		}
		else
		{
			montoPagadoDolar = dosDecimales(montoPagado / dollarExchangeRate);
			montoPagadoEuro = dosDecimales(montoPagado / euro);
			montoPagadoBolivar = montoPagado;
		}
	
		printPayments();
		
		alert('Pago registrado con éxito: ' +  monedaPago + ' ' + formatoNumero(montoPagado));
		
		accumulatedPayment += dosDecimales(montoPagadoDolar);
		acumuladoPagadoEuros += dosDecimales(montoPagadoEuro);
		acumuladoPagadoBolivares += dosDecimales(montoPagadoBolivar);

		actualizarTotales();
		inicializarCampos();
	}

	function descuentoProntoPago(anio_mes_transaccion) // Descuento pronto pago
	{
		var descuentos_pronto_pago = 
			{
				"202208" : 0.00,
				"202308" : 5.00,
				"202508" : 10.00
			};

		var monto_descuento_pronto_pago = 0;
		for (var anio_mes_descuento in descuentos_pronto_pago) 
		{
			if (anio_mes_transaccion <= anio_mes_descuento)
			{
				monto_descuento_pronto_pago = descuentos_pronto_pago[anio_mes_descuento];
				return monto_descuento_pronto_pago;
			}
		}
		return 0;
	}
	function datosFiscalesCliente(response)
	{
		nameFamily = response.data.family;
		let nameRepresentative = response.data.first_name + ' ' + response.data.surname;
		let client = response.data.client; 
		let typeOfIdentificationClient = response.data.type_of_identification_client;
		let identificationNumberClient = response.data.identification_number_client;
		let fiscalAddress = response.data.fiscal_address;							
		let taxPhone = response.data.tax_phone;
		customerEmail = response.data.email;

		$("#date-and-time").val(response.data.today);
		$('#family').val(nameFamily + " (" + nameRepresentative + ")");
		$('#client').val(client);
		$('#type-of-identification-client').val(typeOfIdentificationClient);
		$('#identification-number-client').val(identificationNumberClient);
		$('#fiscal-address').val(fiscalAddress);
		$('#tax-phone').val(taxPhone);
		$('#email').val(customerEmail);
	}
	    
// Funciones Jquery

    $(document).ready(function() 
    {
		if ($('#type-invoice').val() == 'Recibo Consejo Educativo')
		{
			$("#alumnos-relacionados").addClass("noverScreen");
			indicadorConsejoEducativo = 1;
		}
		else
		{ 
			var recalcular = $('<p style="background-color: #a9e0ff; color: red;">¿ Estimado usuario desea cobrar las cuotas atrasadas con la tarifa vigente ?</p>').dialog(
			{
				modal: true,
				buttons: 
				{
					"Sí": function() 
					{
						indicador_recalcular_cuotas = true;
						recalcular.dialog('close');
						
					},
					"No":  function() 
					{
						indicador_recalcular_cuotas = false;
						recalcular.dialog('close');
					}
				}
			});
		}

		$('.entero').numeric();
		
		$(".alternative-decimal-separator").numeric({ altDecimal: "," });
		
        $("#mostrar-registros").click(showDatabase);

		$("#mostrar_cuotas_seleccionadas").click(mostrarCuotasSeleccionadas);
        
        $("#mostrar-pagos").click(showPayments);

        $('#family-search').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => $accionBusquedaFamilia)); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + " - ID "+ ui.item.id + "</td></tr>");
              }
        });

        $('#newfamily').click(function(e) 
        {
            e.preventDefault();
            
            if (totalBalance > 0)
            {    
                var r = confirm("Si selecciona otra familia, perderá los datos del cobro realizado a la familia: " + nameFamily );
                if (r == false)
                {
                    return false;
                }
            }

            cleanPager();
            
            $("#response-container").html("");
            
            disableButtons();
            
            // Mostramos texto de que la solicitud está en curso
            $("#header-messages").html("Por favor espere...");
            
            listFamilies(1);
        });

        $('#everyfamily').click(function(e) 
        {
            e.preventDefault();
            
            if (totalBalance > 0)
            {    
                var r = confirm("Si selecciona otra familia, perderá los datos del cobro realizado a la familia: " + nameFamily );
                if (r == false)
                {
                    return false;
                }
            }

            cleanPager();
            
            $("#response-container").html("");
            
            disableButtons();
            
            // Mostramos texto de que la solicitud está en curso
            $("#header-messages").html("Por favor espere...");
            
            listFamilies(0);
        });

        $("#response-container").on("click", ".family", function()
        {
			if (totalBalance > 0)
			{    
				var r = confirm("Si selecciona otra familia, perderá los datos de pago de la familia: " + nameFamily );
				if (r == false)
				{
					return false;
				}
			}

			if (indicadorConsejoEducativo == 0 && tipoUsuario == 0)
			{
				let factura_fiscal = $('<p style="background-color: #a9e0ff; color: red;">¿ Factura fiscal ?</p>').dialog(
				{
					modal: true,
					buttons: 
					{
						"Sí": function() 
						{
							indicador_pedido = 0;
							factura_fiscal.dialog('close');
							
						},
						"No":  function() 
						{
							indicador_pedido = 1;
							factura_fiscal.dialog('close');
						}
					}
				});
			}

			idFamily = $(this).attr('id').substring(2);
			
			if (selectFamily > -1)
			{
				$('#fa' + selectFamily).css('background-color', 'white');
			}
			selectFamily = idFamily;
			$('#fa' + selectFamily).css('background-color', '#c2c2d6');  
	
			cleanPager();
			
			disableButtons();
				
			$("#header-messages").html("Por favor espere...");
			
			if ($('#type-invoice').val() == 'Factura inscripción regulares' || $('#type-invoice').val() == 'Recibo inscripción regulares')
			{
				typeStudent = 0;
			}
			else if ($('#type-invoice').val() == 'Factura inscripción nuevos' || $('#type-invoice').val() == 'Recibo inscripción nuevos' || $('#type-invoice').val() == 'Recibo servicio educativo')
			{
				typeStudent = 1;
			}
			else
			{
				typeStudent = 2;
			}
						
			$.post('<?php echo Router::url(["controller" => "Students", "action" => "relatedStudents"]); ?>', {"id" : idFamily, "new" : typeStudent, "tasaTemporalDolar" : $("#tasa-temporal-dolar").val(), "tasaTemporalEuro" : $("#tasa-temporal-euro").val(), "opcionMenu" : $('#type-invoice').val() }, null, "json")				
					
			.done(function(response) 
			{
				if (response.success) 
				{			
					$("#header-messages").html("");
					
					students = " ";

					idParentsandguardians = response.data.parentsandguardian_id;

					reversedDate = response.data.reversedDate;

					dollarExchangeRate = response.data.dollar_exchange_rate;
					euro = response.data.euro;
										
					cadenaTasaDolarEuro = (euro / dollarExchangeRate).toFixed(5);
					tasaDolarEuro = parseFloat(cadenaTasaDolarEuro);

					saldoRepresentante = response.data.balance;
					saldoRepresentanteSigno = dosDecimales(saldoRepresentante * -1);

					saldoRepresentanteEuros = dosDecimales(saldoRepresentante / tasaDolarEuro); 
					saldoRepresentanteSignoEuros = dosDecimales(saldoRepresentanteSigno / tasaDolarEuro);

					saldoRepresentanteBolivares = dosDecimales(saldoRepresentante * dollarExchangeRate); 
					saldoRepresentanteSignoBolivares = dosDecimales(saldoRepresentanteSigno * dollarExchangeRate);
					
					mesesTarifas = response.data.meses_tarifas;
					otrasTarifas = response.data.otras_tarifas;

					datosFiscalesCliente(response);

					if (indicadorConsejoEducativo == 1)
					{
						$("#cuadro-periodo-escolar").removeClass("noverScreen");
						familiasRelacionadasAnterior = response.data.consejo_educativo.familiasRelacionadasAnterior;
						familiasRelacionadas = response.data.consejo_educativo.familiasRelacionadas;
						idFamiliaPagadoraConsejoAnterior = response.data.consejo_educativo.idFamiliaPagadoraConsejoAnterior;
						idFamiliaPagadoraConsejo = response.data.consejo_educativo.idFamiliaPagadoraConsejo;
						consejoExoneradoAnterior = response.data.consejo_educativo.consejoExoneradoAnterior;
						consejoExonerado = response.data.consejo_educativo.consejoExonerado;
						indicadorConsejoAnterior = response.data.consejo_educativo.indicadorConsejoAnterior;
						indicadorConsejoActual = response.data.consejo_educativo.indicadorConsejoActual;
						indicadorReciboConsejoAnterior = response.data.consejo_educativo.indicadorReciboConsejoAnterior;
						indicadorReciboConsejoActual = response.data.consejo_educativo.indicadorReciboConsejoActual;      
					}
					else
					{																															
						$.each(response.data.students, function(key, value) 
						{
							idStudent = value.id;
							julioExonerado = 0;
							morosoAnoAnterior = 0;
							alumno_nuevo = 0;

							estudiantes_condiciones[idStudent] = [];
							estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] = false;
							
							students += "<tr id=st" + idStudent + " class='students'>";

							students += "<td>" + value.surname + " ";
							surname = value.surname;
							
							students += value.second_surname + "</td>";
							secondSurname = value.second_surname;

							students += "<td>" + value.first_name + " ";
							firstName = value.first_name;

							students += value.second_name + "</td>";
							secondName = value.second_name;
							
							if ($('#type-invoice').val() == 'Mensualidades')
							{ 
								students += "<td>" + value.sublevel + "</td>";
								grade = value.sublevel;

								students += "<td>" + value.section + "</td>";
								section = value.section;							
							}
							else
							{
								students += "<td>" + value.level_of_study + "</td>";
								grade = value.level_of_study;

								students += "<td>No asignado</td>";
								section = "No asignado";
							}

							ordenGrado = value.orden_grado;
							
							becadoAnoAnterior = value.becado_ano_anterior;
							
							if (value.scholarship == 0)
							{
								students += "<td>Regular</td>";
								students += "<td>"+idStudent+"</td></tr>";
								scholarship = 0;
							}
							else
							{
								students += "<td>Becado</td>";
								students += "<td>"+idStudent+"</td></tr>";
								scholarship = 1;
								julioExonerado = 1;
							}
							
							schoolYearFrom = value.schoolYearFrom;
																			
							julioAnoAnterior = "Jul " + anoEscolarInscripcion;
							
							if (value.descuento_ano_anterior == 0)
							{
								descuentoAnoAnterior = 1;
							}
							else
							{	
								descuentoAnoAnterior = (100 - value.descuento_ano_anterior) / 100;
							}
							
							if (value.discount_family === null)
							{
								discountFamily = 1;
							}
							else
							{	
								discountFamily = (100 - value.discount_family) / 100;
							}

							alumno_nuevo = value.alumno_nuevo;

							$.each(value.studentTransactions, function(key2, value2) 
							{
								if (conceptos_a_omitir.includes(value2.transaction_description))
								{
									return true;
								}

								observacionTransaccion = '';

								indicadorImpresion = 0;
								
								transactionIdentifier = value2.id;
								
								paymentDate = value2.payment_date;

								partialPayment = value2.partial_payment;						
								paidOut = value2.paid_out;

								let anoMes = paymentDate.substring(0, 4) + paymentDate.substring(5, 7);
								
								transactionType = value2.transaction_type;
								
								anoEscolarMensualidad = value2.ano_escolar;
							
								monthlyPayment = value2.transaction_description;

								monto_cuota = dosDecimales(value2.amount);

								amountMonthly = 0;
								tarifaDolar = 0;

								if (transactionType == "Mensualidad" && monthlyPayment.substring(0, 3) != "Ago")
								{
									if (indicador_recalcular_cuotas == true && anoMes >= ano_mes_recalculo_cuotas_atrasadas && anoMes < ano_mes_actual && paidOut == false)
									{
										anoMes = ano_mes_actual;
									}
									else if (indicador_recalcular_cuotas == false && anoEscolarMensualidad < anoEscolarActual && paidOut == false )
									{
										let proximoAnioEscolar = anoEscolarMensualidad + 1;
										anoMes = proximoAnioEscolar + "07";
									}

									$.each(mesesTarifas, function(key3, value3)											
									{
										if (anoMes == value3.anoMes)
										{
											amountMonthly = value3.tarifaBolivar;
											tarifaDolar = value3.tarifaDolar;
											return false;
										}
									});
								}
								else
								{
									if (monthlyPayment.substring(0, 18) == "Servicio educativo")
									{
										tarifaDolar = monto_cuota;
									}
									else
									{
										$.each(otrasTarifas, function(key3, value3)											
										{
											if (monthlyPayment == value3.conceptoAno)
											{
												amountMonthly = value3.tarifaBolivar;
												tarifaDolar = value3.tarifaDolar;
												return false;
											}
										});
									}
								}
														
								if (tarifaDolar == 0)
								{
									tarifaDolar = monto_cuota;
								}
								
								transactionAmount = dosDecimales(value2.amount);
													
								originalAmount = dosDecimales(value2.original_amount);
								
								diferenciaOriginalActual = dosDecimales(originalAmount - monto_cuota);

								if (diferenciaOriginalActual > 0)
								{
									tarifaDolar = dosDecimales(tarifaDolar - diferenciaOriginalActual);
								}
								
								invoiced = value2.invoiced;
								
								studentName = surname + ' ' + secondSurname + ' ' + firstName + ' ' + secondName;

								montoDolar = dosDecimales(value2.amount_dollar);

								if (value2.porcentaje_descuento == 0)
								{
									porcentajeDescuento = 1;
								}
								else
								{	
									porcentajeDescuento = (100 - value2.porcentaje_descuento) / 100;
								}

								if (paidOut == true)
								{
									if (montoDolar === null)
									{
										montoDolar = 0;
										montoPendienteDolar = 0;
										montoAPagarDolar = 0;
										montoAPagarEuro = 0;
										montoAPagarBolivar = 0;
										indicadorImpresion = 1;
									}
									else
									{						
										if (transactionType == "Mensualidad" && monthlyPayment.substring(0, 3) != "Ago")
										{
											if (anoEscolarMensualidad >= anoEscolarAnterior) 
											{
												tarifaDolarSinDescuento = tarifaDolar;
												
												tarifaDolar = dosDecimales(tarifaDolar * porcentajeDescuento);
												
												if (tarifaDolar == tarifaDolarSinDescuento)
												{										
													if (tarifaDolar > montoDolar)
													{
														let monto_descuento_pronto_pago = descuentoProntoPago(anoMes);
														montoDolar = dosDecimales(montoDolar - monto_descuento_pronto_pago);
														montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar); 
														montoAPagarDolar = montoPendienteDolar;
														montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
														montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);	
														paidOut = false;
														
														if (monthlyPayment == julioAnoAnterior && julioExonerado == 0 && montoDolar < tarifaDolar)
														{
															morosoAnoAnterior = 1;
														}
													}
													else
													{
														montoDolar = 0;
														montoPendienteDolar = 0;
														montoAPagarDolar = 0;
														montoAPagarEuro = 0;
														montoAPagarBolivar = 0
														indicadorImpresion = 1;
													}
												}
												else
												{											
													if (tarifaDolar > montoDolar && tarifaDolarSinDescuento > montoDolar)
													{
														let monto_descuento_pronto_pago = descuentoProntoPago(anoMes);
														montoDolar = dosDecimales(montoDolar - monto_descuento_pronto_pago);
														montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar); 
														montoAPagarDolar = montoPendienteDolar;
														montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
														montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);	
														paidOut = false;
														
														if (monthlyPayment == julioAnoAnterior && julioExonerado == 0 && montoDolar < tarifaDolar)
														{
															morosoAnoAnterior = 1;
														}
													}
													else
													{
														montoDolar = 0;
														montoPendienteDolar = 0;
														montoAPagarDolar = 0;
														montoAPagarEuro = 0;
														montoAPagarBolivar = 0
														indicadorImpresion = 1;
													}
												}
											}
											else
											{
												montoDolar = 0;
												montoPendienteDolar = 0;
												montoAPagarDolar = 0;
												montoAPagarEuro = 0;
												montoAPagarBolivar = 0
												indicadorImpresion = 1;
											} 
										}
										else
										{
											if (tarifaDolar != montoDolar && monthlyPayment.substring(0, 18) != "Servicio educativo")
											{
												if (alumno_nuevo == 1 && schoolYearFrom != anoEscolarMensualidad)
												{
													montoDolar = 0;
													montoPendienteDolar = 0;
													montoAPagarDolar = 0;
													montoAPagarEuro = 0;
													montoAPagarBolivar = 0
													indicadorImpresion = 1;
												}
												else
												{
													if (ordenGrado > 41)
													{
														montoDolar = 0;
														montoPendienteDolar = 0;
														montoAPagarDolar = 0;
														montoAPagarEuro = 0;
														montoAPagarBolivar = 0
														indicadorImpresion = 1;
													}
													else
													{
														if (ajustesPagosInscripcion[monthlyPayment])
														{
															montoDolar = dosDecimales(montoDolar + ajustesPagosInscripcion[monthlyPayment]);
														}
														montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar);
														if (montoPendienteDolar > 0)
														{
															montoAPagarDolar = montoPendienteDolar;
															montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
															montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);
															observacionTransaccion = 'Diferencia';
															paidOut = false;
															if (estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] == false)
															{
																estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] = true;
															}
														}												
													}
												}
											}
											else
											{
												montoDolar = 0;
												montoPendienteDolar = 0;
												montoAPagarDolar = 0;
												montoAPagarEuro = 0;
												montoAPagarBolivar = 0
												indicadorImpresion = 1;
											}									
										}
									}
								}
								else if (transactionType != 'Mensualidad')
								{
									montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar);
									if (montoPendienteDolar > 0 && estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] == false)
									{
										estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] = true;
									}						
									montoAPagarDolar = montoPendienteDolar;
									montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
									montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);	
								}
								else if (monthlyPayment.substring(0, 3) == "Ago")
								{
									if (montoPendienteDolar > 0 && estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] == false)
									{
										estudiantes_condiciones[idStudent]["deuda_conceptos_inscripcion"] = true;
									}
									if (ajustesPagosInscripcion[monthlyPayment])
									{
										tarifaDolar = tarifaDolar - ajustesPagosInscripcion[monthlyPayment];
									}				
									montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar);
									montoAPagarDolar = montoPendienteDolar;
									montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
									montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);											
								}
								else
								{								
									if (anoEscolarMensualidad == anoEscolarActual)
									{
										tarifaDolar = dosDecimales(tarifaDolar * discountFamily);
									}
									else
									{
										tarifaDolar = dosDecimales(tarifaDolar * descuentoAnoAnterior);
									}
									
									montoPendienteDolar = dosDecimales(tarifaDolar - montoDolar);
									montoAPagarDolar = montoPendienteDolar;
									montoAPagarEuro = dosDecimales(montoAPagarDolar / tasaDolarEuro);
									montoAPagarBolivar = dosDecimales(montoAPagarDolar * dollarExchangeRate);
									if (monthlyPayment == julioAnoAnterior && julioExonerado == 0)
									{
										morosoAnoAnterior = 1;
									}
								}
								if ($('#type-invoice').val() == 'Recibo de seguro')
								{
									if (indicadorImpresion == 0)
									{
										if (monthlyPayment.substring(0, 14) == "Seguro escolar")
										{
											insertRecord(observacionTransaccion);
										}
									}
								} 
								else if ($('#type-invoice').val() == 'Factura inscripción regulares')
								{
									if (indicadorImpresion == 0)
									{
										if (monthlyPayment.substring(0, 6) === 'Thales')
										{
											if (montoPendienteDolar < 0)
											{
												insertRecord(observacionTransaccion);
											}
										}									
										else if (monthlyPayment.substring(0, 9) == "Matrícula" ||
											monthlyPayment.substring(0, 3) == "Ago")
										{

											insertRecord(observacionTransaccion);
										}
									}								
								}
								else if ($('#type-invoice').val() == 'Factura inscripción nuevos')
								{
									if (monthlyPayment.substring(0, 9) == "Matrícula" ||
										monthlyPayment.substring(0, 3) == "Ago")
										{
											if (indicadorImpresion == 0)
											{
												insertRecord(observacionTransaccion);
											}
										}								
								}
								else if ($('#type-invoice').val() == 'Recibo inscripción regulares')
								{
									if (indicadorImpresion == 0)
									{
										if (monthlyPayment.substring(0, 6) === 'Thales')
										{
											if (montoPendienteDolar < 0)
											{
												insertRecord(observacionTransaccion);
											}
										}
										else if (monthlyPayment.substring(0, 9) == "Matrícula" ||
											monthlyPayment.substring(0, 3) == "Ago")
										{
											insertRecord(observacionTransaccion);
										}
									}
								}
								else if ($('#type-invoice').val() == 'Recibo inscripción nuevos')
								{
									if (monthlyPayment.substring(0, 9) == "Matrícula" ||
										monthlyPayment.substring(0, 3) == "Ago")
										{
											if (indicadorImpresion == 0)
											{
												insertRecord(observacionTransaccion);
											}
										}
								}
								else if ($('#type-invoice').val() == 'Recibo servicio educativo')
								{
									if (monthlyPayment.substring(0, 18) == 'Servicio educativo')
										{
											if (indicadorImpresion == 0)
											{
												insertRecord(observacionTransaccion);
											}
										}
								}
								else
								{
									if (indicadorImpresion == 0)
									{
										if (monthlyPayment.substring(0, 6) === 'Thales')
										{
											if (montoPendienteDolar < 0)
											{
												insertRecord(observacionTransaccion);
											}
										}
										else
										{
											if (monthlyPayment.substring(0, 14) != "Seguro escolar" && monthlyPayment.substring(0, 9) != "Matrícula" && monthlyPayment.substring(0, 18) != 'Servicio educativo' && monthlyPayment.substring(0, 3) != "Ago")
											{
												insertRecord(observacionTransaccion);
											}
										}
									}
								}
							});				
						});	
						$("#header-messages").html(" ");
						$("#related-students").html(students);
					}
				} 
				else 
				{
					$("#header-messages").html('No se pudieron obtener los datos: ' + response.message);
				}
			})
			.fail(function(jqXHR, textStatus, errorThrown) 
			{
				$("#header-messages").html("Algo ha fallado en el servidor: " + textStatus);
			}); 
        });

        $('#update-data').click(function(e) 
        {
			var resultado = 0;
			
            e.preventDefault();
		
			resultado = validarDatosFiscales();
			
			if (resultado > 0)
			{
				alert("Estimado usuario uno o más datos fiscales presentan errores. Por favor revise");
				window.scrollTo(0, 0);
				return false;
			}
			else
			{
				$("#header-messages").html("Por favor espere...");

				$.post('<?php echo Router::url(["controller" => "Parentsandguardians", "action" => "updateClientData"]); ?>', 
					{"id" : idParentsandguardians, 
					"client" : $('#client').val(),
					"typeOfIdentificationClient" : $('#type-of-identification-client').val(),
					"identificationNumberClient" : $('#identification-number-client').val(),
					"fiscalAddress" : $('#fiscal-address').val(),
					"taxPhone" : $('#tax-phone').val()}, null, "json")          

				.done(function(response) 
				{
					if (response.success) 
					{
						$("#header-messages").html("Los datos fiscales fueron actualizados correctamente...");
					} 
					else 
					{
						$("#header-messages").html("Los datos fiscales no pudieron ser actualizados, intente nuevamente");
					}
				})
				.fail(function(jqXHR, textStatus, errorThrown) 
				{
					$("#header-messages").html("Algo ha fallado, los datos fiscales no pudieron ser actualizados: " + textStatus);
				});  
			}
        });

        $("#related-students").on("click", ".students", function(e)
        {
			e.preventDefault();

			resultado = validarDatosFiscales();
			
			if (resultado > 0)
			{
				alert("Estimado usuario uno o más datos fiscales presentan errores. Por favor revise");
				window.scrollTo(0, 0);
				return false;
			}
			else
			{
				$("#student-messages").html("Por favor espere...");
	
				idStudent = $(this).attr('id').substring(2);
	
				if (selectedStudent > -1)
				{
					uncheckStudent(selectedStudent);
				}
				selectedStudent = idStudent;
				markStudent(selectedStudent); 
				$("#monthly-payment").html("");
				$("#student-name").html("");
				$("#student-concept").text(" ");
				studentBalance = 0;
				$("#student-balance").html("");
				
				showRecords();
				
				$("#student-messages").html("");
			}
        });
        
        $("#mark-quotas").click(function () 
        {
            var firstInstallment = " ";
            var lastInstallment = " ";
            var flaggedFlag = 0;
			var blocked_amount = 0;
			let a_pagar_dolar = 0;
			let inputCounter = 0;		            
            $("#monthly-payment input").each(function (index) 
            {
				if (inputCounter == 0)
				{
					if($(this).attr('value') != "Pagada")
					{
						if(!($(this).is(':checked'))) 
						{
							if (flaggedFlag == 0)
							{
								flaggedFlag = 1;
								$(this).attr('checked', true);
								idStudentTransactions = $(this).attr('id'); 
								markTransaction(idStudentTransactions.substring(2));
								updateRecord(idStudentTransactions.substring(2), true); 
								$('#uncheck-quotas').attr('disabled', false);
								$('#charge').attr('disabled', false);
								if (firstInstallment == " ")
								{
									firstInstallment = $(this).attr('name');
								}
								lastInstallment = $(this).attr('name');
								$("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + ')');
								concept = firstInstallment + ' - ' + lastInstallment;
								contadorCuotasSeleccionadas++;
							}
							else
							{
								$("#mark-quotas").html($(this).attr('name'));
								return false;
							}
						}
						else
						{
							if (firstInstallment == " ")
							{
								firstInstallment = $(this).attr('name');
							}
						}
					}
					inputCounter++;
				}
				else if (inputCounter == 1)
				{
					if (flaggedFlag == 1 && blocked_amount == 0)
					{
						$(this).attr('disabled', true);
						blocked_amount = 1;	
					}
					inputCounter++;
				}
				else if (inputCounter == 3)
				{
					if (flaggedFlag == 1 && a_pagar_dolar == 0)
					{
						$(this).attr('disabled', true);
						a_pagar_dolar = 1;	
						studentBalance = dosDecimales(studentBalance + parseFloat($(this).attr('value')));
						totalBalance = dosDecimales(totalBalance + parseFloat($(this).attr('value')));
						actualizarTotales();
					}
					inputCounter++;
				}
				else if (inputCounter == 4)
				{
					inputCounter = 0;
				}
				else
				{
					inputCounter++;
				}
            }); 
        });

        $("#uncheck-quotas").click(function () 
        {
            var transactionDescription = "";
            var firstInstallment = " ";
            var lastInstallment = " ";
            var markedQuotaCounter = 0;
            var indicatorUnmark = 0;
            idStudentTransactions = " ";
			idAmountTransactions = "";
            transactionDescription = " ";
			inputCounter = 0;
			let id_monto_abono = "";
			let monto_abono = "";

            $("#monthly-payment input").each(function (index) 
            {
				if (inputCounter == 0)
				{				
					if($(this).attr('value') != "Pagada")
					{
						if ($(this).is(':checked'))
						{
							if (firstInstallment == " ")
							{
								firstInstallment = $(this).attr('name');
							}
							if (lastInstallment == " ")
							{
								lastInstallment = $(this).attr('name');
							}
							else
							{
								lastInstallment = transactionDescription;
							}
							markedQuotaCounter++;
					
							idStudentTransactions = $(this).attr('id');

							id_monto_abono = idStudentTransactions.replace("tr", "a_pagar_dolar_");
							monto_abono = parseFloat($("#"+id_monto_abono).attr('value'));

							transactionDescription = $(this).attr('name');
							transactionAmount = parseFloat($(this).attr('value'));
						}
						else 
						{
							if (idStudentTransactions != " ")
							{
								if (indicatorUnmark == 0)
								{
									indicatorUnmark = 1;
								}
								$('#' + idStudentTransactions).attr('checked', false);
								$('#' + idAmountTransactions).attr('disabled', false);
								$('#' + id_monto_abono).attr('disabled', false);								
								uncheckTransaction(idStudentTransactions.substring(2));
								updateRecord(idStudentTransactions.substring(2), false); 
								$("#mark-quotas").html(transactionDescription);
								if (markedQuotaCounter == 1)
								{
									firstInstallment = " ";
									lastInstallment = " ";
									$("#student-concept").text(" ");
								}
								else
								{
									$("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + ')');
									concept = firstInstallment + ' - ' + lastInstallment;
								}
								studentBalance = dosDecimales(studentBalance - monto_abono);															
								totalBalance = dosDecimales(totalBalance - monto_abono);
								contadorCuotasSeleccionadas--;
								actualizarTotales();
								return false;
							}
						}
					}
					inputCounter++;
				}
				else if (inputCounter == 1)
				{
					idAmountTransactions = $(this).attr('id');
					inputCounter++;
				}
				else if (inputCounter == 4)
				{
					inputCounter = 0;
				}
				else
				{
					inputCounter++;
				}
            });

            if (idStudentTransactions == " ")
            {
                alert("Debe cobrar al menos una cuota para poder reversar");
            }
            else 
            {
                if (indicatorUnmark == 0)
                {
                    $('#' + idStudentTransactions).attr('checked', false);
                    uncheckTransaction(idStudentTransactions.substring(2));
                    updateRecord(idStudentTransactions.substring(2), false); 
                            
                    $("#mark-quotas").html(transactionDescription);
                    if (markedQuotaCounter == 1)
                    {
                        firstInstallment = " ";
                        lastInstallment = " ";
                        $("#student-concept").text(" ");
                    }
                    else
                    {
                        $("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + '):');
                        concept = firstInstallment + ' - ' + lastInstallment;
                    }					
					studentBalance = dosDecimales(studentBalance - monto_abono);															
					totalBalance = dosDecimales(totalBalance - monto_abono);
					contadorCuotasSeleccionadas--;
					actualizarTotales();
                }
            }
        }); 
        
		$("#ajuste-automatico").on("click", function(e)
        {
            e.preventDefault();

			if (indicador_abono == 1)
			{
				alert("Estimado usuario usted ya hizo un ajuste manual de abonos a las cuotas y no se puede hacer un ajuste automático");
				return-false				
			}
			
			if (contadorCuotasSeleccionadas == 0)
			{
				alert("Estimado usuario debe seleccionar al menos una cuota antes de hacer un ajuste");
				return-false				
			}
							
			if (deudaMenosPagado == 0)
			{
				alert("Estimado usuario la factura ya está cuadrada y no requiere un ajuste");
				return-false
			}

			if (indicador_pedido == 0 && acumulado_igtf_bolivar > 0 && indicadorConsejoEducativo == 0)
			{
				let verificacion_pagos_en_bolivares = 0;

				for (var i = 0, item = null; i < paymentsArray.length; i++) 
				{
					item = paymentsArray[i];
					if (item['payMoneda'] == "Bs.")
					{
						verificacion_pagos_en_bolivares += item['payAmountPaid'];
					}
				}
				if (verificacion_pagos_en_bolivares == 0)
				{
					let pago_igtf_en_divisas = $('<p style="background-color: #a9e0ff; color: red;">Estimado usuario solo ha registrado pagos en divisas. ¿ Desea agregar un pago en bolívares para cancelar los '+acumulado_igtf_bolivar+' Bs. correspondientes al IGTF ?</p>').dialog(
					{
						modal: true,
						buttons: 
						{
							"Sí": function() 
							{
								pago_igtf_en_divisas.dialog('close');					
							},
							"No":  function() 
							{
								pago_igtf_en_divisas.dialog('close');
								verificar_impuestos(ajustarCuotas, 0);
							}
						}
					});
				}
				else
				{
					verificar_impuestos(ajustarCuotas, 0);
				}
			}
			else
			{
				verificar_impuestos(ajustarCuotas, 0);
			}

        });

        $("#accordion").accordion();

        $('.record-payment').click(function(e) 
        {
            e.preventDefault();
            		
            if (deudaMenosPagado > 0)
            {
                paymentIdentifier = ($(this).attr('id')).substring(3);
                
                valid = validateFields();
                
                if (valid == false)
                {
                    return false;
                }

                switch (paymentIdentifier) 
                {
                    case '01':
                    paymentType = "Efectivo";
                    break;
                    case '02':
                    paymentType = "Tarjeta de débito";
                    break;
                    case '03':
                    paymentType = "Tarjeta de crédito";
                    break;
                    case '04':
                    paymentType = "Depósito";
                    break;
                    case '05':
                    paymentType = "Transferencia";
                    break;
                    case '06':
                    paymentType = "Cheque";
                    break;
                    case '07':
                    paymentType = "Retención de impuesto";
                }
				
				montoPagado = dosDecimales(eliminarComa($('#amount-' + paymentIdentifier).val()));
				bank = $('#bank-' + paymentIdentifier).val();
				bancoReceptor = $('#banco-receptor-' + paymentIdentifier).val();
                accountOrCard = $('#account_or_card-' + paymentIdentifier).val();
                serial = $('#serial-' + paymentIdentifier).val();
				comentario = $('#comentario-' + paymentIdentifier).val();

				if (bank == 'Zelle' && monedaPago != '$')
				{
					alert('Estimado usuario los pagos desde Zelle deben ser en dólares');
					return false;
				}
				else if (bancoReceptor == 'Zelle' && monedaPago != '$')
				{
					alert('Estimado usuario los pagos hacia Zelle deben ser en dólares');
					return false;
				}
				if (bank == 'Euros' && monedaPago != '€')
				{
					alert('Estimado usuario los pagos desde Euros deben ser en euros');
					return false;
				}
				else if (bancoReceptor == 'Euros' && monedaPago != '€')
				{
					alert('Estimado usuario los pagos hacia Euros deben ser en euros');
					return false;
				}
				else if (bank != 'Zelle' && bank != "Euros" && bank != "N/A" && monedaPago != 'Bs.')
				{
					alert('Estimado usuario los pagos desde bancos nacionales deben ser en bolívares');
					return false;
				}
				else if (bancoReceptor != 'Zelle' && bancoReceptor != "Euros" && bancoReceptor != "N/A" && monedaPago != 'Bs.')
				{
					alert('Estimado usuario los pagos hacia bancos nacionales deben ser en bolívares');
					return false;
				}

				if (bank == 'Zelle' && paymentType != 'Transferencia')
				{
					alert('Estimado usuario los pagos desde Zelle solo deben ser en transferencia');
					return false;
				}
				else if (bancoReceptor == 'Zelle' && paymentType != 'Transferencia')
				{
					alert('Estimado usuario los pagos desde Zelle solo deben ser en transferencia');
					return false;
				}	

				if (paymentType == 'Transferencia' || paymentType == 'Deposito')
				{
					crm_processing_modal('Por favor espere mientras se valida el serial');

					$.post('<?php echo Router::url(["controller" => "Payments", "action" => "verificarSerial"]); ?>', 
						{
							"banco" : bank, 
							"serial" : serial
						}, null, "json")          

					.done(function(response) 
					{
						if (response.success) 
						{
							crm_processing_modal_close(); 
							procesarPago();
						} 
						else 
						{
							crm_processing_modal_close(); 
							alert(response.message);
						}
					})
					.fail(function(jqXHR, textStatus, errorThrown) 
					{
						crm_processing_modal_close(); 
						alert ("El serial no pudo ser validado. Código de error " + textStatus);
					});  

				}
				else
				{
					procesarPago();
				}		
            }
            else
            {
                alert('No se pueden registrar más pagos, porque la factura ya fue pagada totalmente');
            }
        });

        $("#registered-payments").on("click", ".registeredPayments", function(e)
        {
			e.preventDefault();
			
            selectedPayment = ($(this).attr('id').substring(1));
            paymentType = $(this).attr('name');
            montoPagado = parseFloat($(this).attr('value'));
            var r = confirm("Está seguro de que desea eliminar este pago");
            if (r == false)
            {
                return false;
            }
            $("#pa" + selectedPayment).remove();
            
			buscarMoneda(parseFloat(selectedPayment));
			
            deletePayment(parseFloat(selectedPayment));
			
        });
		
        $("#print-invoice").click(function (e) 
        {	
            e.preventDefault();

			if (contadorCuotasSeleccionadas == 0 && indicadorConsejoEducativo == 0)
			{
				alert('Estimado usuario debe seleccionar al menos una cuota para poder facturar');
				return false;				
			}
			else if (deudaMenosPagado > 0)
			{
				alert('Estimado usuario debe registrar más pagos para completar el total de la factura o hacer un ajuste');
				return false;
			}
            else if (deudaMenosPagado < 0)
            {
				if (saldoRepresentante < balanceDescuento)
				{
					var dialog = $('<p>Estimado usuario hay un sobrante a favor del representante. ¿Qué desea hacer?</p>').dialog(
					{
						buttons: 
						{
							"Abonar a cuotas": function() 
							{
								dialog.dialog('close');
							},
							"Dejarlo a favor":  function() 
							{
								imprimirReciboSobrante = 1;
								verificar_impuestos(guardarFactura, 1);
							},
							"Cancelar":  function() 
							{
								dialog.dialog('close');
							}
						}
					});
				}
				else
				{
					r= confirm('¿Está seguro de que desea guardar la facturar? Después no podrá hacer cambios');
					if (r == false)
					{
						return false;
					}
					else
					{
						verificar_impuestos(guardarFactura, 0);
					}
				}
            }   
			else
			{
				r= confirm('¿Está seguro de que desea guardar la facturar? Después no podrá hacer cambios');
				if (r == false)
				{
					return false;
				}
				else
				{
					verificar_impuestos(guardarFactura, 0);
				}
			}
        });
		
        $('#descuento-recargo').change(function(e) 
        {
			e.preventDefault();
			actualizarDescuentos();
        });
		
		$('#cantidad-descuento').change(function(e) 
        { 
			e.preventDefault();
			actualizarDescuentos();					

        });
				
        $('#update-dollar').click(function(e) 
        {
            e.preventDefault();
			
			if (totalBalance > 0)
			{    
				var r = confirm("Si actualiza la tasa de cambio, perderá los datos de la cobranza a la familia: " + nameFamily );
				if (r == false)
				{
					return false;
				}
			}

			$('#quota-adjustment').val("");
			cleanPager();
			$("#response-container").html("");
			disableButtons();
		
            $.post('<?php echo Router::url(["controller" => "Monedas", "action" => "actualizarTasa"]); ?>', 
                {"amount" : $('#dollar-exchange-rate').val(), "tipo" : "Dolar" }, null, "json")          

            .done(function(response) 
            {
                if (response.success) 
                {
                    $("#dollar-messages").html("La tasa de cambio fue actualizada correctamente");
                } 
                else 
                {
                    $("#dollar-messages").html("La tasa de cambio no pudo ser actualizada");
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#dollar-messages").html("Algo ha fallado, la tasa de cambio no pudo ser actualizada: " + textStatus);
            });  
        });
		
        $('#update-euro').click(function(e) 
        {
            e.preventDefault();
			
			if (totalBalance > 0)
			{    
				var r = confirm("Si actualiza la tasa de cambio, perderá los datos de la cobranza a la familia: " + nameFamily );
				if (r == false)
				{
					return false;
				}
			}

			$('#quota-adjustment').val("");
			cleanPager();
			$("#response-container").html("");
			disableButtons();
		
            $.post('<?php echo Router::url(["controller" => "Monedas", "action" => "actualizarTasa"]); ?>', 
                {"amount" : $('#euro').val(), "tipo" : "Euro" }, null, "json")          

            .done(function(response) 
            {
                if (response.success) 
                {
                    $("#euro-messages").html("La tasa de cambio fue actualizada correctamente");
                } 
                else 
                {
                    $("#euro-messages").html("La tasa de cambio no pudo ser actualizada");
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#euro-messages").html("Algo ha fallado, la tasa de cambio no pudo ser actualizada: " + textStatus);
            });  
        });		
		
        $('#establecer-tasa-dolar').click(function(e) 
        {
			e.preventDefault();
																			
			if ($("#tasa-temporal-dolar").val() > 0)
			{
				if (totalBalance > 0)
				{    
					var r = confirm("Si establece una tasa temporal, perderá los datos de la cobranza a la familia: " + nameFamily );
					if (r == false)
					{
						return false;
					}
				}

				$('#quota-adjustment').val("");
				cleanPager();
				$("#response-container").html("");
				disableButtons();  
				$('#tasa-temporal-dolar').css('background-color', '#ffb3b3');
				$("#establecer-tasa-dolar").addClass("noverScreen");
				$("#eliminar-tasa-dolar").removeClass("noverScreen");
				tasaTemporalDolar = 1;
				alert("Estimado usuario, por favor recuerde establecer también la tasa temporal del Euro");
				$( "#tasa-temporal-euro" ).focus();
			}
			else
			{
				alert("La tasa temporal debe ser mayor a cero");		
			}
        });
		
        $('#eliminar-tasa-dolar').click(function(e) 
        {
			e.preventDefault();
			if (totalBalance > 0)
			{    
				var r = confirm("Si elimina una tasa temporal, perderá los datos de la cobranza a la familia: " + nameFamily );
				if (r == false)
				{
					return false;
				}
			}

			$('#quota-adjustment').val("");
			cleanPager();
			$("#response-container").html("");
			disableButtons();  
			$('#tasa-temporal-dolar').val('0,00');			
			$('#tasa-temporal-dolar').css('background-color', 'white');
			$("#establecer-tasa-dolar").removeClass("noverScreen");
			$("#eliminar-tasa-dolar").addClass("noverScreen");
			tasaTemporalDolar = 0;
			alert("Estimado usuario, por favor recuerde eliminar también la tasa temporal del Euro");
			$( "#tasa-temporal-euro" ).focus();
        });
		
        $('#establecer-tasa-euro').click(function(e) 
        {
			e.preventDefault();
			if ($("#tasa-temporal-euro").val() > 0)
			{
				if (totalBalance > 0)
				{    
					var r = confirm("Si establece una tasa temporal, perderá los datos de la cobranza a la familia: " + nameFamily );
					if (r == false)
					{
						return false;
					}
				}

				$('#quota-adjustment').val("");
				cleanPager();
				$("#response-container").html("");
				disableButtons();  
				$('#tasa-temporal-euro').css('background-color', '#ffb3b3');
				$("#establecer-tasa-euro").addClass("noverScreen");
				$("#eliminar-tasa-euro").removeClass("noverScreen");
				tasaTemporalEuro = 1;
			}
			else
			{
				alert("La tasa temporal debe ser mayor a cero");		
			}
        });
		
        $('#eliminar-tasa-euro').click(function(e) 
        {
			e.preventDefault();
			if (totalBalance > 0)
			{    
				var r = confirm("Si elimina una tasa temporal, perderá los datos de la cobranza a la familia: " + nameFamily );
				if (r == false)
				{
					return false;
				}
			}

			$('#quota-adjustment').val("");
			cleanPager();
			$("#response-container").html("");
			disableButtons();  
			$('#tasa-temporal-euro').val('0,00');			
			$('#tasa-temporal-euro').css('background-color', 'white');
			$("#establecer-tasa-euro").removeClass("noverScreen");
			$("#eliminar-tasa-euro").addClass("noverScreen");
			tasaTemporalEuro = 0;
        });
		
        $('#adjust-fee').click(function(e) 
        {
            e.preventDefault();
			
			var adjInputCounter = 0;
			var adjIdAmountTransaction = ""; 
			var adjMontoModificadoDolar = 0;
			var adjOriginalMontoDolar = 0;
			var adjMontoPagadoDolar = 0;
			var adjMontoPendienteDolar = 0;
			var adjAPagarDolar = 0;
			var adjAPagarEuro = 0;
			var adjAPagarBolivar = 0;
			var montoDolarCadena;
			var adjError = 0;
			var indicadorChequeado = 0;
			let monto_pendiente_dolar = 0;
			let monto_abono_item = 0;
			let indicador_abono_item = 0;
			let id_a_pagar_dolar = "";
			let observacion = "";
						
            $("#monthly-payment input").each(function (index) 
            {
				if (adjInputCounter == 0)
				{
					monto_pendiente_dolar = parseFloat($(this).val());
					adjInputCounter++;
				}
				else if (adjInputCounter == 1)
				{
					adjMontoModificadoDolar = parseFloat($(this).val());
					adjIdAmountTransaction = $(this).attr('id');
					adjInputCounter++;
				}
				else if (adjInputCounter == 2)
				{
					adjMontoPagadoDolar = parseFloat($(this).val());
					adjInputCounter++;	
				}
				else if (adjInputCounter == 3)
				{
					id_a_pagar_dolar = $(this).attr('id');
					monto_abono_item = parseFloat($(this).val());

					if (monto_pendiente_dolar != monto_abono_item)
					{
						indicador_abono_item = 1;
					}
					adjInputCounter++;		
				}
				else if (adjInputCounter == 4)
				{
					adjOriginalMontoDolar = parseFloat($(this).val());

					if (adjMontoModificadoDolar != adjOriginalMontoDolar || indicador_abono_item == 1)
					{					
						if (adjMontoModificadoDolar > adjMontoPagadoDolar)
						{
							adjMontoPendienteDolar = dosDecimales(adjMontoModificadoDolar - adjMontoPagadoDolar);

							if (indicador_abono_item == 1)
							{
								if (monto_abono_item > adjMontoPendienteDolar)
								{
									alert('Error: El abono no puede ser mayor al monto pendiente');
									$('#' + id_a_pagar_dolar).css('background-color', '#ff5050');
									adjError = 1;
									return false;
								}
								else
								{
									adjAPagarDolar = monto_abono_item;
									observacion = "Abono";
									indicador_abono = 1;
								}
							}
							else
							{
								adjAPagarDolar = adjMontoPendienteDolar;
							}						
							adjAPagarEuro = dosDecimales(adjAPagarDolar / tasaDolarEuro);
							adjAPagarBolivar = dosDecimales(adjAPagarDolar * dollarExchangeRate);
							updateInstallment(adjIdAmountTransaction.substring(2), adjOriginalMontoDolar, adjMontoModificadoDolar, adjMontoPendienteDolar, adjAPagarDolar, adjAPagarEuro, adjAPagarBolivar, observacion);
							$('#' + adjIdAmountTransaction).css('background-color', '#ffffff');
							cambioMontoCuota = 1;
						}
						else if (adjMontoModificadoDolar == adjMontoPagadoDolar)
						{
							updateInstallment(adjIdAmountTransaction.substring(2), adjOriginalMontoDolar, adjMontoModificadoDolar, 0, 0, 0, 0, "(Exonerado)");
							$('#' + adjIdAmountTransaction).css('background-color', '#ffffff');
							cambioMontoCuota = 1;
						}
						else
						{
							alert('Error: El monto de la cuota ajustada debe ser mayor al monto abonado');
							$('#' + adjIdAmountTransaction).css('background-color', '#ff5050');
							adjError = 1;
							return false;
						}
					}
					
					adjInputCounter = 0;
					adjModifiableFee = 0;
					adjOriginalAmount = 0;
					adjAmountPaid = 0;
					adjAmountPayable = 0;
					adjIdAmountTransaction = '';
					monto_pendiente_dolar = 0;
					monto_abono_item = 0;
					indicador_abono_item = 0;
					id_a_pagar_dolar = "";
				}
				else
				{
					adjInputCounter++;
				}
            });
			if (adjError == 0)
			{
				showRecords();
			}
        });
		
        $('#compensar').click(function(e) 
        {
			e.preventDefault();
			$("#print-invoice").attr('disabled', false);
			$("#ajuste-automatico").attr('disabled', false);
			$(".record-payment").attr('disabled', false);		
			$("#nota-credito").addClass("noverScreen");
			$("#botones-notas").addClass("noverScreen");
			$("#botones-cuotas").removeClass("noverScreen");
			indicadorCompensacion = 1;
        });
		
		$('.check-dolar').click(function(e) 
        {
			monedaPago = "$";
			$('.check-dolar').attr('checked', true);
			$('.check-dolar').prop('checked', true);
			$('.check-euro').attr('checked', false);
			$('.check-euro').prop('checked', false);
			$('.check-bolivar').attr('checked', false);
			$('.check-bolivar').prop('checked', false);
			updateAmount();
		});
		
		$('.check-euro').click(function(e) 
        {
			monedaPago = "€";
			$('.check-dolar').attr('checked', false);
			$('.check-dolar').prop('checked', false);
			$('.check-euro').attr('checked', true);
			$('.check-euro').prop('checked', true);
			$('.check-bolivar').attr('checked', false);
			$('.check-bolivar').prop('checked', false);
			aCobrarEuros();
		});
		
		$('.check-bolivar').click(function(e) 
        {
			monedaPago = "Bs.";
			$('.check-dolar').attr('checked', false);
			$('.check-dolar').prop('checked', false);
			$('.check-euro').attr('checked', false);
			$('.check-euro').prop('checked', false);
			$('.check-bolivar').attr('checked', true);
			$('.check-bolivar').prop('checked', true);
			aCobrarBolivares();
		});
		
		$('#prueba-ajuste').click(function(e) 
        {
			diferenciaBolivares = 22.5;
			uploadTransactions();
		});

		$('#periodo-escolar').change(function(e) 
        {
			e.preventDefault();
			studentBalance = 0;
			totalBalance = 0;
			actualizarTotales();
			disableButtons();

			if ($('#periodo-escolar').val() != "")
			{
				resultado = validarDatosFiscales();
			
				if (resultado > 0)
				{
					alert("Estimado usuario uno o más datos fiscales presentan errores. Por favor revise");
					window.scrollTo(0, 0);
					return false;
				}
				else
				{
					anioConsejoEducativo = $('#periodo-escolar').val();
					proximoAnioConsejoEducativo = parseInt(anioConsejoEducativo) + 1;
					periodoEscolarRequerido = `${anioConsejoEducativo}-${proximoAnioConsejoEducativo}`;
		
					if (anioConsejoEducativo == anoEscolarAnterior)
					{
						if (indicadorConsejoAnterior == false)
						{
							alert(`A esta familia no le corresponde pagar el Consejo Educativo ${periodoEscolarRequerido}`);
						}
						else if (idFamiliaPagadoraConsejoAnterior > 0)
						{
							alert('Esta familia no paga Consejo Educativo porque está relacionada con otra familia del mismo representante');
							return false;
						}	
						else if (consejoExoneradoAnterior > 0)
						{
							alert(`Esta familia está exonerada del pago del Consejo Educativo ${periodoEscolarRequerido}`);
							return false;
						}
						else if (indicadorReciboConsejoAnterior == true)
						{
							alert(`A este representante ya se le cobró el Consejo Educativo ${periodoEscolarRequerido}`);
							return false
						}
						else
						{
							var indicadorTarifaEncontrada = 0;
							$.each(otrasTarifas, function(clave, valor)											
							{
								if (valor.conceptoAno == "Consejo Educativo "+anioConsejoEducativo)
								{
									amountMonthly = valor.tarifaBolivar;
									tarifaDolar = valor.tarifaDolar;
									indicadorTarifaEncontrada = 1;
									return false;
								}
							});
							if (indicadorTarifaEncontrada == 1)
							{
								totalBalance = dosDecimales(tarifaDolar);
								actualizarTotales();
							}
							else
							{
								alert(`No se encontró la tarifa para el Consejo Educativo del período: ${periodoEscolarRequerido}`);
								return false
							}
						}
					}
					else
					{
						if (indicadorConsejoActual == false)
						{
							alert(`A esta familia no le corresponde pagar el Consejo Educativo ${periodoEscolarRequerido}`);
						}
						else if (idFamiliaPagadoraConsejo > 0)
						{
							alert('Esta familia no paga Consejo Educativo porque está relacionada con otra familia del mismo representante');
							return false;
						}	
						else if (consejoExonerado > 0)
						{
							alert(`Esta familia está exonerada del pago del Consejo Educativo ${periodoEscolarRequerido}`);
							return false;
						}
						else if (indicadorReciboConsejoActual == true)
						{
							alert(`A este representante ya se le cobró el Consejo Educativo ${periodoEscolarRequerido}`);
							return false
						}
						else
						{
							var indicadorTarifaEncontrada = 0;
							$.each(otrasTarifas, function(clave, valor)											
							{
								if (valor.conceptoAno == "Consejo Educativo "+anioConsejoEducativo)
								{
									amountMonthly = valor.tarifaBolivar;
									tarifaDolar = valor.tarifaDolar;
									indicadorTarifaEncontrada = 1;
									return false;
								}
							});
							if (indicadorTarifaEncontrada == 1)
							{
								totalBalance = dosDecimales(tarifaDolar);
								actualizarTotales();
							}
							else
							{
								alert(`No se encontró la tarifa para el Consejo Educativo del período: ${periodoEscolarRequerido}`);;
								return false
							}
						}

					}
				}
			}
        });

		$('#acordion-retencion-impuesto').click(function(e) 
        {
			monedaPago = "Bs.";
			$('.check-dolar').attr('checked', false);
			$('.check-dolar').prop('checked', false);
			$('.check-euro').attr('checked', false);
			$('.check-euro').prop('checked', false);
			$('.check-bolivar').attr('checked', true);
			$('.check-bolivar').prop('checked', true);
			aCobrarBolivares();
		});
    }); 

</script>