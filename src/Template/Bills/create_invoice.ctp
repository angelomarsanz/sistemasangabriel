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
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<input type="hidden" id="type-invoice" value="<?= $menuOption ?>">
            <div class="row">
                <div class="col-md-12">
					<?php if ($menuOption == 'Factura inscripción regulares'): ?>
						<h3><b>Factura inscripción alumnos regulares</b></h3>
					<?php elseif ($menuOption == 'Factura inscripción nuevos'): ?>
						<h3><b>Factura inscripción alumnos nuevos</b></h3>
					<?php elseif ($menuOption == 'Recibo inscripción regulares'): ?>
						<h3><b>Recibo inscripción alumnos regulares</b></h3>
					<?php elseif ($menuOption == 'Recibo inscripción nuevos'): ?>
						<h3><b>Recibo inscripción alumnos nuevos</b></h3>
					<?php else: ?>
						<h3><b>Cobro de mensualidades</b></h3>
					<?php endif; ?>
                    <h5 id="Turno" value=<?= $idTurn ?>>Fecha: <?= $dateTurn->format('d-m-Y') ?>, Turno: <?= $turn ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h5>
                </div>
            </div>
            <div class="row panel panel-default">
                <div class="col-md-4">
					<br />
					<div class="row">
						<div class="col-md-6">
							<?= $this->Form->input('dollar_exchange_rate', ['label' => 'Tasa de cambio:', 'class' => 'alternative-decimal-separator', 'value' => number_format(($dollarExchangeRate), 2, ",", ".")]) ?>
							<button id="update-dollar" class="btn btn-success">Actualizar</button>
						</div>
						<div class="col-md-6">
							<br />
							<p id="dollar-messages"></p>
						</div>
					</div>
					<br>
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
            <div class="row panel panel-default">
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
                                        </tr>
                                    </thead>
                                    <tbody id="related-students"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <br />
                    <p><b>Cuotas pendientes:</b></p>
                    <div class="panel panel-default pre-scrollable" style="height:210px;">
                        <div class="panel-body">
                            <div class="table-responsive">          
                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
											<th scope="col"></th>
                                            <th scope="col">Concepto</th>
											<th scope="col">Cuota</th>
                                            <th scope="col">Abonado</th>
											<th scope="col">Pendiente</th>
											<th scope="col" class="noverScreen"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthly-payment"></tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    <div>
                        <button id="mark-quotas" class="btn btn-success" disabled>Cobrar</button>
                        <button id="uncheck-quotas" class="btn btn-success" disabled>Reversar</button>  
						<button id="adjust-fee" class="btn btn-success" disabled>Ajustar</button>						
                        <button id="save-payments" class="btn btn-success" disabled>Facturar</button>
                    </div>  
                </div>
                <div class="col-md-3">
                    <br />
                    <p><b>Totales:</b></p>
                    <div class="panel panel-default" style="height:290px; padding: 0% 3% 0% 3%;">
                        <br />
                        <p><b>Alumno: </b><spam id="student-name"></spam></p>
                        <p><b>Cuotas: </b><spam id="student-concept"></spam></p>
                        <p><b>Sub-total alumno: Bs.S </b><spam id="student-balance">0</spam></b></p>
                        <p><b>Sub-total familia: Bs.S </b><spam id="total-balance"></spam></p>   
                        <p><?= $this->Form->input('select_discount', ['label' => 'Descuento/Recargo:', 'class' => 'select-discount', 'options' => $discounts]); ?></p>
						<p><b>Total a pagar: Bs.S </b><spam id="total-general"></spam></p>
						<p><b>Total a pagar: $ </b><spam id="total-general-dolar"></spam></p>	
						<br />
                    </div>
					<p id="student-messages"></p>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 panel panel-default">
                    <br />
                    <p><b>Detalles de la factura:</b><spam id="invoice-messages"></spam></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="table-responsive">          
                                    <table class="table table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th scope="col">Alumno</th>
                                                <th scope="col">Cuota</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col">Monto&nbsp;a&nbsp;pagar</th>
                                                <th scope="col">Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice-lines"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-8">
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
                                                    <th scope="col">Monto</th>
                                                    <th scope="col">&nbsp;&nbsp;Banco&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                    <th scope="col">Cuenta&nbsp;o&nbsp;tarjeta</th>
                                                    <th scope="col">Serial</th>
                                                </tr>
                                            </thead>
                                            <tbody id="registered-payments"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><b>Sub-total Bs.S </b><spam id="invoice-subtotal"></spam></p>
							<p><b>Desc/Recar Bs.S </b><spam id="invoice-descuento"></spam></p>
                            <p><b>Iva 16% Bs. </b>0,00</p>
                            <p><b>Total Bs.S <spam id="total-bill"></spam></spam></p>
                            <p><b>Pagado Bs.S <spam id="paid-out"></spam></spam></p>
                            <p><b>Por pagar Bs.S <spam id="to-pay"></spam></p>
                            <p><b>Cambio Bs.S <spam id="change"></spam></p>
                            <br />
                            <button id="automatic-adjustment" class="btn btn-success" disabled>Ajuste automático</button>
                            <button id="adjust-invoice" class="btn btn-success" disabled>Ajuste manual</button>
                            <button id="print-invoice" class="btn btn-success" disabled>Guardar factura</button>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 panel panel-default">
                            <br />
                            <p><b>Registrar pago:</b></p>
                            <div id="accordion">
                                <h3>Efectivo</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-01']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'value' => 'N/A', 'disabled' => true, 'id' => 'bank-01']) ?>
                                    <?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-01']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-01']) ?>
                                    <button id="bt-01" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Tarjeta de débito</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-02']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'id' => 'bank-02', 'options' => 
                                        [null => '',
                                        '100% Banco' => '100% Banco',
                                        'Activo' => 'Activo',
                                        'Agrícola de Venezuela' => 'Agrícola de Venezuela',
                                        'Bancamiga' => 'Bancamiga',
                                        'Bancaribe' => 'Bancaribe',
                                        'Bancoex' => 'Bancoex',
                                        'Bancrecer' => 'Bancrecer',
                                        'Banesco' => 'Banesco',
                                        'Banfanb' => 'Banfanb',
                                        'Bangente' => 'Bangente',
                                        'Banplus' => 'Banplus',
                                        'Bicentenario del Pueblo' => 'Bicentenario del Pueblo',
                                        'BOD' => 'BOD',
                                        'Caroní' => 'Caroní',
                                        'Citibank' => 'Citibank',
                                        'Delsur' => 'Delsur',
                                        'Exportación y Comercio' => 'Exportación y Comercio', 
                                        'Exterior' => 'Exterior',
                                        'Fondo Común' => 'Fondo Común',
                                        'Instituto Municipal de Crédito Popular (IMCP)' => 'Instituto Municipal de Crédito Popular (IMCP)',
                                        'Internacional de Desarrollo' => 'Internacional de Desarrollo',
                                        'Mercantil' => 'Mercantil',
                                        'Mi Banco' => 'Mi Banco',
                                        'Nacional de Crédito' => 'Nacional de Crédito',
                                        'Novo Banco' => 'Novo Banco',
                                        'Plata' => 'Plata',
                                        'Plaza' => 'Plaza',
                                        'Provincial' => 'Provincial',
                                        'Sofitasa' => 'Sofitasa',
                                        'Tesoro' => 'Tesoro',
                                        'Venezolano de Crédito' => 'Venezolano de Crédito',
                                        'Venezuela' => 'Venezuela',
                                        'Otro banco no especificado en la lista']]) ?>
                                        
                                    <?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'id' => 'account_or_card-02']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-02']) ?>
                                    <button id="bt-02" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Tarjeta de crédito</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-03']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'id' => 'bank-03', 'options' =>
                                        [null => '',
                                        '100% Banco' => '100% Banco',
                                        'Activo' => 'Activo',
                                        'Agrícola de Venezuela' => 'Agrícola de Venezuela',
                                        'Bancamiga' => 'Bancamiga',
                                        'Bancaribe' => 'Bancaribe',
                                        'Bancoex' => 'Bancoex',
                                        'Bancrecer' => 'Bancrecer',
                                        'Banesco' => 'Banesco',
                                        'Banfanb' => 'Banfanb',
                                        'Bangente' => 'Bangente',
                                        'Banplus' => 'Banplus',
                                        'Bicentenario del Pueblo' => 'Bicentenario del Pueblo',
                                        'BOD' => 'BOD',
                                        'Caroní' => 'Caroní',
                                        'Citibank' => 'Citibank',
                                        'Delsur' => 'Delsur',
                                        'Exportación y Comercio' => 'Exportación y Comercio', 
                                        'Exterior' => 'Exterior',
                                        'Fondo Común' => 'Fondo Común',
                                        'Instituto Municipal de Crédito Popular (IMCP)' => 'Instituto Municipal de Crédito Popular (IMCP)',
                                        'Internacional de Desarrollo' => 'Internacional de Desarrollo',
                                        'Mercantil' => 'Mercantil',
                                        'Mi Banco' => 'Mi Banco',
                                        'Nacional de Crédito' => 'Nacional de Crédito',
                                        'Novo Banco' => 'Novo Banco',
                                        'Plata' => 'Plata',
                                        'Plaza' => 'Plaza',
                                        'Provincial' => 'Provincial',
                                        'Sofitasa' => 'Sofitasa',
                                        'Tesoro' => 'Tesoro',
                                        'Venezolano de Crédito' => 'Venezolano de Crédito',
                                        'Venezuela' => 'Venezuela',
                                        'Otro banco no especificado en la lista']]) ?>
                                        
                                    <?= $this->Form->input('account_or_card', ['label' => 'Tarjeta:', 'id' => 'account_or_card-03']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'value' => 'N/A', 'disabled' => true, 'id' => 'serial-03']) ?>
                                    <button id="bt-03" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Depósito</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-04']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'id' => 'bank-04', 'options' =>
                                        [null => '',
                                        '100% Banco' => '100% Banco',
                                        'Activo' => 'Activo',
                                        'Agrícola de Venezuela' => 'Agrícola de Venezuela',
                                        'Bancamiga' => 'Bancamiga',
                                        'Bancaribe' => 'Bancaribe',
                                        'Bancoex' => 'Bancoex',
                                        'Bancrecer' => 'Bancrecer',
                                        'Banesco' => 'Banesco',
                                        'Banfanb' => 'Banfanb',
                                        'Bangente' => 'Bangente',
                                        'Banplus' => 'Banplus',
                                        'Bicentenario del Pueblo' => 'Bicentenario del Pueblo',
                                        'BOD' => 'BOD',
                                        'Caroní' => 'Caroní',
                                        'Citibank' => 'Citibank',
                                        'Delsur' => 'Delsur',
                                        'Exportación y Comercio' => 'Exportación y Comercio', 
                                        'Exterior' => 'Exterior',
                                        'Fondo Común' => 'Fondo Común',
                                        'Instituto Municipal de Crédito Popular (IMCP)' => 'Instituto Municipal de Crédito Popular (IMCP)',
                                        'Internacional de Desarrollo' => 'Internacional de Desarrollo',
                                        'Mercantil' => 'Mercantil',
                                        'Mi Banco' => 'Mi Banco',
                                        'Nacional de Crédito' => 'Nacional de Crédito',
                                        'Novo Banco' => 'Novo Banco',
                                        'Plata' => 'Plata',
                                        'Plaza' => 'Plaza',
                                        'Provincial' => 'Provincial',
                                        'Sofitasa' => 'Sofitasa',
                                        'Tesoro' => 'Tesoro',
                                        'Venezolano de Crédito' => 'Venezolano de Crédito',
                                        'Venezuela' => 'Venezuela',
                                        'Otro banco no especificado en la lista']]) ?>
                                    <?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-04']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-04']) ?>
                                    <button id="bt-04" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Transferencia</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-05']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'id' => 'bank-05', 'options' =>
                                        [null => '',
                                        '100% Banco' => '100% Banco',
                                        'Activo' => 'Activo',
                                        'Agrícola de Venezuela' => 'Agrícola de Venezuela',
                                        'Bancamiga' => 'Bancamiga',
                                        'Bancaribe' => 'Bancaribe',
                                        'Bancoex' => 'Bancoex',
                                        'Bancrecer' => 'Bancrecer',
                                        'Banesco' => 'Banesco',
                                        'Banfanb' => 'Banfanb',
                                        'Bangente' => 'Bangente',
                                        'Banplus' => 'Banplus',
                                        'Bicentenario del Pueblo' => 'Bicentenario del Pueblo',
                                        'BOD' => 'BOD',
                                        'Caroní' => 'Caroní',
                                        'Citibank' => 'Citibank',
                                        'Delsur' => 'Delsur',
                                        'Exportación y Comercio' => 'Exportación y Comercio', 
                                        'Exterior' => 'Exterior',
                                        'Fondo Común' => 'Fondo Común',
                                        'Instituto Municipal de Crédito Popular (IMCP)' => 'Instituto Municipal de Crédito Popular (IMCP)',
                                        'Internacional de Desarrollo' => 'Internacional de Desarrollo',
                                        'Mercantil' => 'Mercantil',
                                        'Mi Banco' => 'Mi Banco',
                                        'Nacional de Crédito' => 'Nacional de Crédito',
                                        'Novo Banco' => 'Novo Banco',
                                        'Plata' => 'Plata',
                                        'Plaza' => 'Plaza',
                                        'Provincial' => 'Provincial',
                                        'Sofitasa' => 'Sofitasa',
                                        'Tesoro' => 'Tesoro',
                                        'Venezolano de Crédito' => 'Venezolano de Crédito',
                                        'Venezuela' => 'Venezuela',
                                        'Otro banco no especificado en la lista']]) ?>
                                    <?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-05']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-05']) ?>
                                    <button id="bt-05" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Cheque</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-06']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'id' => 'bank-06', 'options' => 
                                        [null => '',
                                        '100% Banco' => '100% Banco',
                                        'Activo' => 'Activo',
                                        'Agrícola de Venezuela' => 'Agrícola de Venezuela',
                                        'Bancamiga' => 'Bancamiga',
                                        'Bancaribe' => 'Bancaribe',
                                        'Bancoex' => 'Bancoex',
                                        'Bancrecer' => 'Bancrecer',
                                        'Banesco' => 'Banesco',
                                        'Banfanb' => 'Banfanb',
                                        'Bangente' => 'Bangente',
                                        'Banplus' => 'Banplus',
                                        'Bicentenario del Pueblo' => 'Bicentenario del Pueblo',
                                        'BOD' => 'BOD',
                                        'Caroní' => 'Caroní',
                                        'Citibank' => 'Citibank',
                                        'Delsur' => 'Delsur',
                                        'Exportación y Comercio' => 'Exportación y Comercio', 
                                        'Exterior' => 'Exterior',
                                        'Fondo Común' => 'Fondo Común',
                                        'Instituto Municipal de Crédito Popular (IMCP)' => 'Instituto Municipal de Crédito Popular (IMCP)',
                                        'Internacional de Desarrollo' => 'Internacional de Desarrollo',
                                        'Mercantil' => 'Mercantil',
                                        'Mi Banco' => 'Mi Banco',
                                        'Nacional de Crédito' => 'Nacional de Crédito',
                                        'Novo Banco' => 'Novo Banco',
                                        'Plata' => 'Plata',
                                        'Plaza' => 'Plaza',
                                        'Provincial' => 'Provincial',
                                        'Sofitasa' => 'Sofitasa',
                                        'Tesoro' => 'Tesoro',
                                        'Venezolano de Crédito' => 'Venezolano de Crédito',
                                        'Venezuela' => 'Venezuela',
                                        'Otro banco no especificado en la lista']]) ?>
                                    <?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'id' => 'account_or_card-06']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-06']) ?>
                                    <button id="bt-06" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                                <h3>Retención de impuesto</h3>
                                <div>
                                    <?= $this->Form->input('amount', ['label' => 'Monto:', 'id' => 'amount-07']) ?>
                                    <?= $this->Form->input('bank', ['label' => 'Banco:', 'value' => 'N/A', 'disabled' => true, 'id' => 'bank-07']) ?>
                                    <?= $this->Form->input('account_or_card', ['label' => 'Cuenta:', 'value' => 'N/A', 'disabled' => true, 'id' => 'account_or_card-07']) ?>
                                    <?= $this->Form->input('serial', ['label' => 'Serial:', 'id' => 'serial-07']) ?>
                                    <button id="bt-07" class="record-payment btn btn-success" disabled>Registrar pago</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="mostrar-registros" type=submit>Tabla studentTransactions</button>
<button id="mostrar-pagos" type=submit>Tabla payments</button>
<div id="mensajes"></div>
<div id="results"></div>
<div id="pagos"></div>
<script>
//  Declaración de variables
    var idFamily = 0;
    var nameFamily = " ";
    var selectFamily = -1;
	var typeStudent = 0;
    var customerEmail = " ";
    var totalBalance = 0;
	var discountMode = '';
	var discountAmount = 0;
	var discount = 0;
	var totalGeneral = 0;
	var invoiceDescuento = 0;
    var totalBill = 0;
    var paymentType = " ";
    var amountPaid = 0;
    var bank = " ";
    var accountOrCard = " ";
    var serial = " ";
    var balance = 0;
    var balanceIndicator = 0;
    var accumulatedPayment = 0;
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
    var studentTransactions = "";
    var transactionIdentifier = 0;
    var monthlyPayment = " ";
	var tarifaDolar = 0;
	var montoDolar = 0;
    var transactionAmount = 0;
	var tempAmount = 0;
    var originalAmount = 0;
    var invoiced = 0;
    var partialPayment = 0;
    var paidOut = 0;
	var dollarExchangeRate = 0;
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
	var amountPaid = 0;
    var selectedPayment = -1;
    var grade = " ";
    var section = " ";

    var db = openDatabase("sanGabrielSqlite", "1.0", "San Gabriel Sqlite", 200000000);  // Open SQLite Database
    var dataSet;

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

    var tbStudentTransactions = new Array();
    var tbConcepts = new Array();
    var tbPaymentsMade = new Array();
	
// Funciones

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
        $("#save-payments").attr('disabled', true);
        $("#automatic-adjustment").attr('disabled', true);
        $("#adjust-invoice").attr('disabled', true);
        $("#print-invoice").attr('disabled', true);
        $("#bt-01").attr('disabled', true);
        $("#bt-02").attr('disabled', true);
        $("#bt-03").attr('disabled', true);
        $("#bt-04").attr('disabled', true);
        $("#bt-05").attr('disabled', true);
        $("#bt-06").attr('disabled', true);
        $("#bt-07").attr('disabled', true);
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
        dropTable();
        dropPayments();

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
		$("#total-general-dolar").html("");
		$("#invoice-descuento").html("");
        $("#invoice-subtotal").html(" ");
        $("#total-bill").html(" ");
        $('#paid-out').text(" ");
        $('#to-pay').text(" ");
        $('#change').text(" ");
		$('.mensajes-usuario').html("");
		$('.campo-resaltado').css('background-color', "white");
		$(".select-discount").attr('disabled', false);
		$('.select-discount').css('background-color', 'white');
		$('.select-discount').val(1);
		
        for (var i = 0, item = 0; i < 7; i++)
        {
            item = i + 1;
            paymentNumber = "0" + item;

            $("#amount-" + paymentNumber).css('background-color', '#ffffff');
            $("#amount-" + paymentNumber).val(0);
            
            if (item > 1 && item < 4)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
                $("#account_or_card-" + paymentNumber).css('background-color', '#ffffff');
                $('#account_or_card-' + paymentNumber).val(null);
            }
            else if (item > 3 && item < 6)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
                $("#serial-" + paymentNumber).css('background-color', '#ffffff');
                $('#serial-' + paymentNumber).val(null);
            }
            else if (item == 6)
            {
                $("#bank-" + paymentNumber).css('background-color', '#ffffff');
                $('#bank-' + paymentNumber).val(null);
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
            alert("El nombre del banco es obligatorio");
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

    function updateAmount()
    {
        $('#paid-out').text(accumulatedPayment.toFixed(2));
            
        if (balance > 0)
        {
            $('#to-pay').text(balance.toFixed(2));
            $('#change').text(0);
            $('#amount-01').val(balance.toFixed(2));
            $('#amount-02').val(balance.toFixed(2));
            $('#amount-03').val(balance.toFixed(2));
            $('#amount-04').val(balance.toFixed(2));
            $('#amount-05').val(balance.toFixed(2));
            $('#amount-06').val(balance.toFixed(2));
            $('#amount-07').val(balance.toFixed(2));
        }
        else
        {
            $('#to-pay').text(0);
            $('#change').text(change.toFixed(2));
            $('#amount-01').val(0);
            $('#amount-02').val(0);
            $('#amount-03').val(0);
            $('#amount-04').val(0);
            $('#amount-05').val(0);
            $('#amount-06').val(0);
            $('#amount-07').val(0);
        }     
        if (indicatorUpdateAmount == 0)
        {
            $("#amount-" + paymentIdentifier).css('background-color', '#ffffff');
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
                    $("#account_or_card-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#account_or_card-' + paymentIdentifier).val(null);
                }
                else if (paymentType == 'Transferencia' || paymentType == 'Depósito')
                {
                    $("#bank-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#bank-' + paymentIdentifier).val(null);
                    $("#serial-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#serial-' + paymentIdentifier).val(null);
                }
                else
                {
                    $("#bank-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#bank-' + paymentIdentifier).val(null);
                    $("#account_or_card-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#account_or_card-' + paymentIdentifier).val(null);
                    $("#serial-" + paymentIdentifier).css('background-color', '#ffffff');
                    $('#serial-' + paymentIdentifier).val(null);
                }
            }
        }
    }

    function initDataBase()  // Function Call When Page is ready.
    {
        try 
        {
            if (!window.openDatabase)  // Check browser is supported SQLite or not.
            {
                alert('Databases are not supported in this browser.');
            }
            else 
            {
                createTable();  // If supported then call Function for create table in SQLite
                createTablePayments();
            }
        }
     
        catch(e) 
        {
            if (e == 2) 
            {
                console.log("Invalid database version.");
            } 
            else 
            {
                console.log("Unknown error " + e + ".");
            }
            return;
        }
    }
     
    function createTable()  // Function for Create Table in SQLite.
    {
        var createStatement = "CREATE TABLE IF NOT EXISTS studentTransactions \
        (dbId INTEGER PRIMARY KEY, \
        dbIdStudent INTEGER, \
        dbStudentName VARCHAR(500), \
        dbMonthlyPayment VARCHAR(100), \
        dbScholarship INTEGER, \
		dbTarifaDolar FLOAT, \
        dbTransactionAmount FLOAT, \
        dbOriginalAmount FLOAT, \
        dbAmountPayable FLOAT, \
		dbAmountPaid FLOAT, \
        dbInvoiced INTEGER, \
        dbPartialPayment INTEGER, \
        dbPaidOut INTEGER, \
		dbSchoolYearFrom INTEGER, \
        dbObservation VARCHAR(100))";

        db.transaction(function (tx) { tx.executeSql(createStatement, [], null, onError); });
    }

    function createTablePayments()  
    {
        var createPayments = "CREATE TABLE IF NOT EXISTS payments \
        (payId INTEGER PRIMARY KEY, \
        payPaymentType VARCHAR(100), \
        payAmountPaid FLOAT, \
        payBank VARCHAR(200), \
        payAccountOrCard VARCHAR(50), \
        paySerial VARCHAR (50))";

        db.transaction(function (tx) { tx.executeSql(createPayments, [], null, onError); });
    }

    function insertRecord() // Get value from Input and insert record . Function Call when Save/Submit Button Click..
    {
        var insertStatement = "INSERT OR REPLACE INTO studentTransactions \
        (dbId, \
        dbIdStudent, \
        dbStudentName, \
        dbMonthlyPayment, \
        dbScholarship, \
		dbTarifaDolar, \
        dbTransactionAmount, \
        dbOriginalAmount, \
        dbAmountPayable, \
		dbAmountPaid, \
        dbInvoiced, \
        dbPartialPayment, \
        dbPaidOut, \
		dbSchoolYearFrom, \
        dbObservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        var tpId = transactionIdentifier;
        var tpIdStudent = idStudent;
        var tpStudentName = studentName + " - " + grade;
        var tpMonthlyPayment = monthlyPayment;
        var tpScholarship = scholarship;
		var tpTarifaDolar = tarifaDolar;
        var tpTransactionAmount = transactionAmount;
        var tpOriginalAmount = originalAmount;
        var tpAmountPayable = amountPayable;
		var tpAmountPaid = amountPaid;
        var tpInvoiced = invoiced;
        var tpPartialPayment = partialPayment;
        var tpPaidOut = paidOut;
		var tpSchoolYearFrom = schoolYearFrom;
        var tpObservation = " ";

        db.transaction(function (tx) 
        {
            tx.executeSql(insertStatement, 
            [tpId,
            tpIdStudent,
            tpStudentName,
            tpMonthlyPayment,
            tpScholarship,
			tpTarifaDolar,
            tpTransactionAmount,
            tpOriginalAmount,
            tpAmountPayable,
			tpAmountPaid,
            tpInvoiced,
            tpPartialPayment,
            tpPaidOut,
			tpSchoolYearFrom,
            tpObservation], null, onError); 
        });
    }
    
    function insertRecordPayments() // Get value from Input and insert record . Function Call when Save/Submit Button Click..
    {
        var insertPayments = "INSERT OR REPLACE INTO payments \
        (payId, \
        payPaymentType, \
        payAmountPaid, \
        payBank, \
        payAccountOrCard, \
        paySerial) VALUES (?, ?, ?, ?, ?, ?)";

        var tpId = accountant;
        var tpPaymentType = paymentType;
        var tpAmountPaid = amountPaid;
        var tpBank = bank;
        var tpAccountOrCard = accountOrCard;
        var tpSerial = serial; 

        db.transaction(function (tx) 
        {
            tx.executeSql(insertPayments, 
            [tpId, 
            tpPaymentType, 
            tpAmountPaid, 
            tpBank, 
            tpAccountOrCard,
            tpSerial], null, onError);
        });
    }
    
    function deletePayment(locIdPayment) 
    {
        var deletePayment = "DELETE FROM payments WHERE payId=?";
        db.transaction(function (tx) 
        { 
            tx.executeSql(deletePayment, [locIdPayment], null, onError);
        });
    }
 
    function updateRecord(id, invoiced, amountPayable, observation ) 
    {
        var updateStatement = "UPDATE studentTransactions SET dbInvoiced = ?, dbAmountPayable = ?, dbObservation = ? WHERE dbId=?";
        
        db.transaction(function (tx) { tx.executeSql(updateStatement, [invoiced, Number(amountPayable), observation, Number(id)], null, onError); });
    }
    
    function updateInstallment(id, transactionAmount, originalAmount, amountPayable) 
    {
        var updateStatement = "UPDATE studentTransactions SET dbTransactionAmount = ?, dbOriginalAmount = ?, dbAmountPayable = ? WHERE dbId=?";
        
        db.transaction(function (tx) { tx.executeSql(updateStatement, [Number(transactionAmount), Number(originalAmount), Number(amountPayable), Number(id)], null, onError); });
    }
	
    function showRecords() // Function For Retrive data from Database Display records as list
    {
        var selectWithCondition = "SELECT * FROM studentTransactions WHERE dbIdStudent = ?";
        var detailLine = " ";
        var nextPayment = " ";
        var indicatorPaid = 0;
        var firstInstallment = " ";
        var lastInstallment = " ";
        studentBalance = 0;
        
        db.transaction(function (tx) 
        {
            tx.executeSql(selectWithCondition, [idStudent], function (tx, result) 
            {
                dataSet = result.rows;
                
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    
                    if (i == 0)
                    {
                        if (item['dbScholarship'] == 1)
                        {
							if ($('#type-invoice').val() == 'Mensualidades')
							{
								alert("Este alumno es becado, no se le deben cobrar cuotas");
								return false;
							}
                        }
                        studentName = item['dbStudentName'];
                    }
                    
                    monthlyPayment = item['dbMonthlyPayment'];

                    if (item['dbPaidOut'] == 'false')
                    {
                        if (item['dbInvoiced'] == "true")
                        {
                            studentBalance = studentBalance + item['dbTransactionAmount'];
                            detailLine += "<tr id=tra" + item['dbId'] + ">  \
								<td style='background-color:#c2c2d6;'><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbTransactionAmount'] + " checked='checked' disabled></td> \
                                <td style='background-color:#c2c2d6;'>" + item['dbMonthlyPayment'] + "</td> \
								<td style='background-color:#c2c2d6;'><input type='number' id=am" + item['dbId'] + " class='form-control modifiable-fee' value=" + item['dbOriginalAmount'] + " disabled></td> \
								<td style='background-color:#c2c2d6;'><input type='number' class='form-control amount-paid' value=" + item['dbAmountPaid'] + " disabled></td> \
                                <td style='background-color:#c2c2d6;'>" + item['dbTransactionAmount'] + "</td> \
								<td style='background-color:#c2c2d6;'><input type='number' class='form-control original-amount noverScreen' value=" + item['dbOriginalAmount'] + "></td></tr>";

                                $('#uncheck-quotas').attr('disabled', false);
                                $('#save-payments').attr('disabled', false);
                                if (firstInstallment == " ")
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
								<td><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbTransactionAmount'] + " disabled></td> \
                                <td>" + item['dbMonthlyPayment'] + "</td> \
								<td><input type='number' id=am" + item['dbId'] + " class='form-control modifiable-fee' value=" + item['dbOriginalAmount'] + "></td> \
								<td><input type='number' class='form-control amount-paid' value=" + item['dbAmountPaid'] + " disabled></td> \
                                <td>" + item['dbTransactionAmount'] + "</td> \
								<td><input type='number' class='form-control original-amount noverScreen' value=" + item['dbOriginalAmount'] + "></td></tr>";								
                        }
                    }
                    else 
                    {
                            detailLine += "<tr id=tra" + item['dbId'] + "> \
								<td><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value='Pagada' checked='checked' disabled> (Pagada)</td> \
                                <td>" + item['dbMonthlyPayment'] + "</td> \
								<td><input type='number' id=am" + item['dbId'] + " class='form-control modifiable-fee' value=" + item['dbOriginalAmount'] + "></td> \
								<td><input type='number' class='form-control amount-paid' value=" + item['dbAmountPaid'] + " disabled></td> \
                                <td>" + item['dbTransactionAmount'] + "</td> \
								<td><input type='number' class='form-control original-amount' value=" + item['dbOriginalAmount'] + "></td></tr>";                 
                    }
                }
                $("#monthly-payment").html(detailLine);
                if (nextPayment == "")
                {
                    disableButtons();
                    alert('No existen cuotas a pagar de este alumno');
                }
                else
                {
                    $("#student-name").html(studentName);
                    $("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + ')');
                    concept = firstInstallment + ' - ' + lastInstallment;
                    $("#student-balance").html(studentBalance.toFixed(2));
                    $("#mark-quotas").html(nextPayment);  
                    $("#mark-quotas").attr('disabled', false);
					$("#adjust-fee").attr('disabled', false);
                }
            });
        });
    }

    function showDatabase() // Function For Retrive data from Database Display records as list
    {
        var selectAllStatement = "SELECT * FROM studentTransactions";
        var detailLine = " ";
        
        db.transaction(function (tx) 
        {
            tx.executeSql(selectAllStatement, [], function (tx, result) 
            {
                dataSet = result.rows;
                
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    detailLine += "<li>" + item['dbId'] 
                    + " "
                    + item['dbIdStudent']
                    + " " 
                    + item['dbStudentName']
                    + " "
                    + item['dbMonthlyPayment'] 
                    + " "
                    + item['dbScholarship'] 
                    + " "
                    + item['dbTarifaDolar'] 
                    + " "
                    + item['dbTransactionAmount']
                    + " "
                    + item['dbOriginalAmount']
                    + " "
                    + item['dbAmountPayable']
                    + " "
                    + item['dbAmountPaid']
                    + " "
                    + item['dbInvoiced']
                    + " "
                    + item['dbPartialPayment']
                    + " "
                    + item['dbPaidOut']
                    + " "
                    + item['dbSchoolYearFrom']
                    + " "
                    + item['dbObservation']
                    + "</li>";
                }
                $("#results").html(detailLine);
            });
        });
    }
    
    function showPayments() 
    {
        var selectAllPayments = "SELECT * FROM payments";
        var detailLine = " ";
        
        db.transaction(function (tx) 
        {
            tx.executeSql(selectAllPayments, [], function (tx, result) 
            {
                dataSet = result.rows;
                
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    detailLine += "<li>" 
                    + item['payId'] 
                    + " "
                    + item['payPaymentType']
                    + " " 
                    + item['payAmountPaid']
                    + " "
                    + item['payBank'] 
                    + " "
                    + item['payAccountOrCard']
                    + " "
                    + item['paySerial']
                    + "</li>";
                }
                $("#pagos").html(detailLine);
            });
        });
    }

    function dropTable() // Function Call when Drop Button Click.. Talbe will be dropped from database.
    {
        var dropStatement = "DROP TABLE IF EXISTS studentTransactions";

        db.transaction(function (tx) { tx.executeSql(dropStatement, [], null, onError); });
        initDataBase();
    }
    
    function dropPayments() // Function Call when Drop Button Click.. Talbe will be dropped from database.
    {
        var dropPayments = "DROP TABLE IF EXISTS payments";

        db.transaction(function (tx) { tx.executeSql(dropPayments, [], null, onError); });
        initDataBase();
    }

    function onError(tx, error) // Function for Hendeling Error...
    {
        alert(error.message);
    }

    function printPayments()
    {
        linePayments = " ";
        
        linePayments += "<tr id=pa" + accountant + "> \
            <td><button id=p" + accountant + " name='" + paymentType + "' value=" + amountPaid + " class='registeredPayments glyphicon glyphicon-trash'></button></td> \
            <td>" + paymentType + "</td> \
            <td>" + amountPaid.toFixed(2) + "</td> \
            <td>" + bank + "</td> \
            <td>" + accountOrCard + "</td> \
            <td>" + serial + "</td></tr>";
        $("#registered-payments").append(linePayments);
        
        insertRecordPayments();
        
        accountant++;
    }
    
    function activateInvoiceButtons()
    {
        $("#automatic-adjustment").attr('disabled', false);
        $("#adjust-invoice").attr('disabled', false);
        $("#print-invoice").attr('disabled', false);
        $("#bt-01").attr('disabled', false);
        $("#bt-02").attr('disabled', false);
        $("#bt-03").attr('disabled', false);
        $("#bt-04").attr('disabled', false);
        $("#bt-05").attr('disabled', false);
        $("#bt-06").attr('disabled', false);
        $("#bt-07").attr('disabled', false);
    }
    
    function showInvoiceLines()
    {
        var selectForInvoice = "SELECT * FROM studentTransactions WHERE dbInvoiced = 'true' ORDER BY dbStudentName";
        var detailLine = " ";
        var previousStudentName = " ";
        var currentStudentName = " ";

        db.transaction(function (tx) 
        {
            tx.executeSql(selectForInvoice, [], function (tx, result) 
            {
                dataSet = result.rows;
                    
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    
                    if (previousStudentName != item['dbStudentName'])
                    {
                        previousStudentName = item['dbStudentName'];
                        currentStudentName = item['dbStudentName'];
                    }
                    else 
                    {
                        currentStudentName = " ";
                    }
                    decAmount = parseFloat(item['dbAmountPayable']).toFixed(2);
                    detailLine += "<tr id=fact" + item['dbId'] + ">  \
                        <td>" + currentStudentName + "</td> \
                        <td>" + item['dbMonthlyPayment'] + "</td> \
                        <td id=fac" + item['dbId'] + " value=" + item['dbTransactionAmount'] + ">" + item['dbTransactionAmount'] + "</td> \
                        <td><input type='number' id=fa" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + decAmount + "></td> \
                        <td>" + item['dbObservation'] + "</td></tr>";
                }
                $("#invoice-lines").html(detailLine);
            });
        });
    }

    function uploadTransactions()
    {
		biggestYearFrom = schoolYearFrom;
		
        var selectForInvoice = "SELECT * FROM studentTransactions WHERE dbInvoiced = 'true'";

        db.transaction(function (tx) 
        {
            tx.executeSql(selectForInvoice, [], function (tx, result) 
            {
                dataSet = result.rows;
                    
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    tbStudentTransactions[transactionCounter] = new Object();
                    tbStudentTransactions[transactionCounter].studentName = item['dbStudentName'];
                    tbStudentTransactions[transactionCounter].transactionIdentifier = item['dbId'];
					tbStudentTransactions[transactionCounter].tarifaDolar = item['dbTarifaDolar'];
                    tbStudentTransactions[transactionCounter].monthlyPayment = item['dbMonthlyPayment'];
					tbStudentTransactions[transactionCounter].originalAmount = item['dbOriginalAmount'];
                    tbStudentTransactions[transactionCounter].amountPayable = item['dbAmountPayable'];
                    tbStudentTransactions[transactionCounter].observation = item['dbObservation']; 
                    transactionCounter++;
					if (item['dbMonthlyPayment'].substring(0, 9) == "Matrícula")
					{
						biggestYearFrom = parseInt(item['dbMonthlyPayment'].substring(10, 14));
					}
                }
				biggestYearUntil = biggestYearFrom + 1;
				payments.schoolYear = "Año escolar " + biggestYearFrom + "-" + biggestYearUntil;
            });
        });
    }
    
    function loadPayments()
    {
        var locSelectAllPayments = "SELECT * FROM payments";

        db.transaction(function (tx) 
        {
            tx.executeSql(locSelectAllPayments, [], function (tx, result) 
            {
                dataSet = result.rows;
                
                for (var i = 0, item = null; i < dataSet.length; i++) 
                {
                    item = dataSet.item(i);
                    
                    if (item['payPaymentType'] != "Cambio")
                    {
                        tbPaymentsMade[accountPaid] = new Object();
                        tbPaymentsMade[accountPaid].id = item['payId'];
                        tbPaymentsMade[accountPaid].paymentType = item['payPaymentType'];
                        tbPaymentsMade[accountPaid].amountPaid = item['payAmountPaid'];
                        tbPaymentsMade[accountPaid].bank = item['payBank'];
                        tbPaymentsMade[accountPaid].accountOrCard = item['payAccountOrCard'];
                        tbPaymentsMade[accountPaid].serial = item['paySerial'];
                        tbPaymentsMade[accountPaid].idTurn = $("#Turno").attr('value');
                        tbPaymentsMade[accountPaid].family = nameFamily;
                        accountPaid++;
                    }
                }
                var stringStudentTransactions = JSON.stringify(tbStudentTransactions);
                                
                var stringPaymentsMade = JSON.stringify(tbPaymentsMade);

                cleanPager();
				
                $.redirect('<?php echo Router::url(["controller" => "Bills", "action" => "recordInvoiceData"]); ?>', {headboard : payments, studentTransactions : stringStudentTransactions, paymentsMade : stringPaymentsMade }); 
            });
        });
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
                            output += "<tr id=fa" + uservalue + " class='family'><td>";
                        else if (userkey == 'family')
                            output += uservalue + " (";
                        else if (userkey == 'surname')
                            output += uservalue + " ";
                        else
                            output += uservalue + ")</td></tr>";
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

// Funciones Jquery

    $(document).ready(function() 
    {
		$('.entero').numeric();
		
		$(".alternative-decimal-separator").numeric({ altDecimal: "," });
		
        $("#mostrar-registros").click(showDatabase);
        
        $("#mostrar-pagos").click(showPayments);

        $('#family-search').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + "</td></tr>");
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
			else if ($('#type-invoice').val() == 'Factura inscripción nuevos' || $('#type-invoice').val() == 'Recibo inscripción nuevos')
			{
				typeStudent = 1;
			}
			else
			{
				typeStudent = 2;
			}
						
			$.post('<?php echo Router::url(["controller" => "Students", "action" => "relatedStudents"]); ?>', {"id" : idFamily, "new" : typeStudent}, null, "json")				
                     
            .done(function(response) 
            {
                if (response.success) 
                {			
					$("#header-messages").html("");
					
					nameFamily = response.data.family;

                    nameRepresentative = response.data.first_name + ' ' + response.data.surname;

                    students = " ";

                    idParentsandguardians = response.data.parentsandguardian_id;
                    
                    $("#date-and-time").val(response.data.today);
                    
                    reversedDate = response.data.reversedDate;

                    client = response.data.client; 

                    typeOfIdentificationClient = response.data.type_of_identification_client;

                    identificationNumberClient = response.data.identification_number_client;
    
                    fiscalAddress = response.data.fiscal_address;
                        
                    taxPhone = response.data.tax_phone;
                        
                    customerEmail = response.data.email;
					
					dollarExchangeRate = response.data.dollar_exchange_rate;
					
					mesesTarifas = response.data.meses_tarifas;
					otrasTarifas = response.data.otras_tarifas;
													                        
                    $('#family').val(nameFamily + " (" + nameRepresentative + ")");
                    $('#client').val(client);
                    $('#type-of-identification-client').val(typeOfIdentificationClient);
                    $('#identification-number-client').val(identificationNumberClient);
                    $('#fiscal-address').val(fiscalAddress);
                    $('#tax-phone').val(taxPhone);
                    $('#email').val(customerEmail);
                        						
                    $.each(response.data.students, function(key, value) 
                    {
                        students += "<tr id=st" + value.id + " class='students'>";
                        idStudent = value.id;
						
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
						
						if (value.scholarship == 0)
						{
							students += "<td>Regular</td></tr>";
							scholarship = 0;
						}
						else
						{
							students += "<td>Becado</td></tr>";
							scholarship = 1;
						}
						
						schoolYearFrom = value.schoolYearFrom;
						
						if (value.discount_family === null)
						{
							discountFamily = 1;
						}
						else
						{	
							discountFamily = (100 - value.discount_family) / 100;
						}
						
                        $.each(value.studentTransactions, function(key2, value2) 
                        {
							indicadorImpresion = 0;
							
							transactionIdentifier = value2.id;
							
							paymentDate = value2.payment_date;
							
							anoMes = paymentDate.substring(0, 4) + paymentDate.substring(5, 7);

							transactionType = value2.transaction_type;
							
							monthlyPayment = value2.transaction_description;
							
							amountMonthly = 0;
							tarifaDolar = 0;
							
							if (transactionType == "Mensualidad" && monthlyPayment.substring(0, 3) != "Ago")
							{
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

							transactionAmount = value2.amount;
							
							amountPaid = value2.amount;
						
							originalAmount = value2.original_amount;
							
							invoiced = value2.invoiced;

							partialPayment = value.partial_payment;

							paidOut = value2.paid_out;
							
							studentName = surname + ' ' + secondSurname + ' ' + firstName + ' ' + secondName;

							montoDolar = value2.amount_dollar;
							
							if (paidOut == true)
							{
								if (montoDolar === null)
								{
									transactionAmount = 0;
									amountPayable = 0;
									indicadorImpresion = 1;
								}
								else
								{						
									if (transactionType == "Mensualidad" && monthlyPayment.substring(0, 3) != "Ago")
									{
										if (tarifaDolar > montoDolar)
										{												
											diferenciaMensualidad = (tarifaDolar - montoDolar) * dollarExchangeRate;
											
											originalAmount = Math.round((diferenciaMensualidad + amountPaid) * discountFamily);
											transactionAmount = originalAmount - amountPaid;
											amountPayable = transactionAmount;	
											paidOut = false;
										}
										else
										{
											transactionAmount = 0;
											amountPayable = 0;
											indicadorImpresion = 1;
										}
									}
									else
									{
										if (tarifaDolar > montoDolar)
										{												
											diferenciaMensualidad = (tarifaDolar - montoDolar) * dollarExchangeRate;
											
											originalAmount = Math.round(diferenciaMensualidad + amountPaid);
											transactionAmount = originalAmount - amountPaid;
											amountPayable = transactionAmount;	
											paidOut = false;
										}
										else
										{
											transactionAmount = 0;
											amountPayable = 0;
											indicadorImpresion = 1;
										}									
									}
								}
							}
							else if (transactionType != 'Mensualidad')
							{
								originalAmount = amountMonthly;
								transactionAmount = originalAmount - amountPaid;
								amountPayable = transactionAmount;		
							}
							else if (monthlyPayment == "Ago 2019")
							{
								originalAmount = amountMonthly + amountPaid;
								transactionAmount = originalAmount - amountPaid;
								amountPayable = transactionAmount												
							}
							else if (monthlyPayment.substring(0, 3) == "Ago")
							{
								originalAmount = amountMonthly;
								transactionAmount = originalAmount - amountPaid;
								amountPayable = transactionAmount												
							}
							else
							{
								originalAmount = Math.round(amountMonthly * discountFamily);
								transactionAmount = originalAmount - amountPaid;
								amountPayable = transactionAmount;												
							}
							
							if ($('#type-invoice').val() == 'Factura inscripción regulares')
							{
								if (monthlyPayment.substring(0, 8) == "Ago 2019")
								{
									if (indicadorImpresion == 0)
									{
										insertRecord();
									}
								}
							}
							else if ($('#type-invoice').val() == 'Factura inscripción nuevos')
							{
								if (monthlyPayment.substring(0, 8) == "Ago 2019")
								{
									if (indicadorImpresion == 0)
									{
										insertRecord();
									}
								}												
							}
							else if ($('#type-invoice').val() == 'Recibo inscripción regulares')
							{
								if (monthlyPayment.substring(0, 9) == "Matrícula" ||
									monthlyPayment.substring(0, 14) == "Seguro escolar" ||
									monthlyPayment.substring(0, 8) == "Ago 2020")
									{
										if (indicadorImpresion == 0)
										{
											insertRecord();
										}
									}
							}
							else if ($('#type-invoice').val() == 'Recibo inscripción nuevos')
							{
								if (monthlyPayment.substring(0, 18) == 'Servicio educativo' || 
									monthlyPayment.substring(0, 9) == "Matrícula" ||
									monthlyPayment.substring(0, 8) == "Ago 2020")
									{
										if (indicadorImpresion == 0)
										{
											insertRecord();
										}
									}
							}
							else
							{
								if (indicadorImpresion == 0)
								{
									insertRecord();
								}
							}
						});				
					});	
                    $("#header-messages").html(" ");
                    $("#related-students").html(students);
                } 
                else 
                {
                    $("#header-messages").html('No se pudieron obtener los datos de los alumnos: ' + response.message);
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

        $("#related-students").on("click", ".students", function()
        {
            if (totalBill == 0)
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
			discount = 0;
			discountMode = '';
			discountAmount = 0;
			inputCounter = 0;
			$('.select-discount').val(1);
			$('#total-general').html('');
			$('#total-general-dolar').html('');
			            
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
								updateRecord(idStudentTransactions.substring(2), 'true', parseFloat($(this).attr('value')), " "); 
								$('#uncheck-quotas').attr('disabled', false);
								$('#save-payments').attr('disabled', false);
								$('#charge').attr('disabled', false);
								if (firstInstallment == " ")
								{
									firstInstallment = $(this).attr('name');
								}
								lastInstallment = $(this).attr('name');
								$("#student-concept").text('(' + firstInstallment + ' - ' + lastInstallment + ')');
								concept = firstInstallment + ' - ' + lastInstallment;
								studentBalance = studentBalance + parseFloat($(this).attr('value'));
								$("#student-balance").html(studentBalance.toFixed(2));
								totalBalance = totalBalance + parseFloat($(this).attr('value'));
								$("#total-balance").html(totalBalance.toFixed(2));
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
						inputCounter++;
					}
					else
					{
						inputCounter++;
					}
				}
				else if (inputCounter == 3)
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
			discount = 0;
			discountMode = '';
			discountAmount = 0;
			inputCounter = 0;
			$('.select-discount').val(1);
			$('#total-general').html('');
			$('#total-general-dolar').html('');

            $("#monthly-payment input").each(function (index) 
            {
				if (inputCounter == 0)
				{				
					if($(this).attr('value') != "Pagada")
					{
						if($(this).is(':checked'))
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
								uncheckTransaction(idStudentTransactions.substring(2));
								updateRecord(idStudentTransactions.substring(2), 'false', transactionAmount, " "); 
								
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
								studentBalance = studentBalance - transactionAmount;
								$("#student-balance").html(studentBalance.toFixed(2));
								totalBalance = totalBalance - transactionAmount;
								$("#total-balance").html(totalBalance.toFixed(2));
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
				else if (inputCounter == 3)
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
                    updateRecord(idStudentTransactions.substring(2), 'false'); 
                            
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
                    studentBalance = studentBalance - transactionAmount;
                    $("#student-balance").html(studentBalance.toFixed(2));
                    totalBalance = totalBalance - transactionAmount;
                    $("#total-balance").html(totalBalance.toFixed(2));
                }
            }
        }); 

        $("#save-payments").click(function(e)
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
				if ($('.select-discount').val() == 1)
				{
					alert("Por favor indique si se aplicará algún descuento o recargo");
					$('.select-discount').css('background-color', "#ffffe6");
				}
				else
				{         
					$("#mark-quotas").attr('disabled', true);
					$("#uncheck-quotas").attr('disabled', true);
					$("#save-payments").attr('disabled', true);
					$(".select-discount").attr('disabled', true);

					showInvoiceLines();
					
					totalBill = totalBalance;
					$("#invoice-subtotal").html(totalBill.toFixed(2));
					$("#invoice-descuento").html(discount.toFixed(2));
					totalBill = totalBill + discount;
					$("#total-bill").html(totalBill.toFixed(2));
					balance = totalBalance + discount - accumulatedPayment;
					indicatorUpdateAmount = 1;
					updateAmount();
					indicatorUpdateAmount = 0;
					activateInvoiceButtons();
				}
			}
        });     
        
        $("#automatic-adjustment").click(function(e) 
        {
            e.preventDefault();
        
            var remainingBalance = 0;
			
			if (discountMode == 'Porcentaje')
			{
				if (discountAmount > 0)
				{
					discountBase = accumulatedPayment / (1 + discountAmount);
					discountDecimal = discountBase * discountAmount;
					discount = Math.round(discountDecimal);
					remainingBalance = accumulatedPayment - discount;
				}
				else
				{
					positiveDiscount = discountAmount * -1;
					discountBase = accumulatedPayment / (1 - positiveDiscount);
					discountDecimal = discountBase * positiveDiscount;
					discount = (Math.round(discountDecimal)) * -1;
					remainingBalance = accumulatedPayment - discount;
				}
			}
			else
			{
				discount = discountAmount;
				remainingBalance = accumulatedPayment - discount;
			}
			    
            $("#invoice-lines input").each(function (index) 
            {
                transactionIdentifier = $(this).attr('id').substring(2);
                transactionAmount = parseFloat($("#fac" + transactionIdentifier).attr('value'));

                if (remainingBalance == 0)
                {
                    updateRecord(transactionIdentifier, false, transactionAmount, " " );
                }
                else if (remainingBalance < transactionAmount)
                {
                    updateRecord(transactionIdentifier, true, remainingBalance, "Abono" );
                    remainingBalance = 0;
                }
                else if (remainingBalance == transactionAmount)
                {
                    remainingBalance = 0;
                }
                else if (remainingBalance > transactionAmount)
                {
                    remainingBalance = remainingBalance - transactionAmount;
                }

            });
            showInvoiceLines();
            totalBill = accumulatedPayment - discount;
            $("#invoice-subtotal").html(totalBill.toFixed(2));
			$("#invoice-descuento").html(discount.toFixed(2));
			totalBill = totalBill + discount;
            $("#total-bill").html(totalBill.toFixed(2));
            balance = totalBill - accumulatedPayment;
            indicatorUpdateAmount = 1;
            updateAmount();
            indicatorUpdateAmount = 0;			
        });

        $("#adjust-invoice").click(function(e) 
        {
            e.preventDefault();
            
            totalBill = 0;
    
            $("#invoice-lines input").each(function (index) 
            {
                transactionIdentifier = $(this).attr('id').substring(2);
                monthlyPayment = $(this).attr('name');
                transactionAmount = parseFloat($("#fac" + transactionIdentifier).attr('value'));
                amountPayable = parseFloat($(this).val()); 

                if (amountPayable == 0)
                {
                    updateRecord(transactionIdentifier, false, transactionAmount, " " );
                }
                else if (amountPayable < 0)
                {
                    totalBill = totalBill + transactionAmount;
                }
                else if (amountPayable == transactionAmount)
                {
                    totalBill = totalBill + transactionAmount;
                }
                else if (amountPayable < transactionAmount)
                {
                    updateRecord(transactionIdentifier, true, amountPayable, "Abono" );
                    totalBill = totalBill + amountPayable;
                }
                else if (amountPayable > transactionAmount)
                {
                    totalBill = totalBill + transactionAmount;
                }
                
            });

            showInvoiceLines();
            $("#invoice-subtotal").html(totalBill.toFixed(2));
			
			if (discountMode == 'Porcentaje')
			{
				if (discountAmount > 0)
				{
					discountDecimal = totalBill * discountAmount;
					discount = Math.round(discountDecimal);
				}
				else
				{
					positiveDiscount = discountAmount * -1;
					discountDecimal = totalBill * positiveDiscount;
					discount = (Math.round(discountDecimal)) * -1;
				}
			}
			else
			{
				discount = discountAmount;
			}
			
			$("#invoice-descuento").html(discount.toFixed(2));
			totalBill = totalBill + discount;			
            $("#total-bill").html(totalBill.toFixed(2));
            balance = totalBill - accumulatedPayment;
            indicatorUpdateAmount = 1;
            updateAmount();
            indicatorUpdateAmount = 0;
        });

        $("#accordion").accordion();

        $('.record-payment').click(function(e) 
        {
            // Detenemos el comportamiento normal del evento click sobre el elemento clicado
            e.preventDefault();
            
            if (balanceIndicator == 0)
            {
                balance = parseFloat((totalBalance + discount).toFixed(2));
                balanceIndicator = 1;
			}
            
            if (balance > 0)
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

                amountPaid = parseFloat($('#amount-' + paymentIdentifier).val());
                bank = $('#bank-' + paymentIdentifier).val();
                accountOrCard = $('#account_or_card-' + paymentIdentifier).val();
                serial = $('#serial-' + paymentIdentifier).val();
				
                balance = balance - amountPaid;
    
                accumulatedPayment = accumulatedPayment + amountPaid;
        
                if (balance < 0)
                {
                    amountPaid = amountPaid + balance;
                    change = -(balance);
                }

                updateAmount();

                printPayments();

                alert('Pago registrado con éxito: Bs. ' + amountPaid.toFixed(2));

                if (change > 0)
                {
                    paymentType = "Cambio";
                    amountPaid = change;
                    printPayments(); 
                    change = 0;
                }
            }
            else
            {
                alert('No se pueden registrar más pagos, porque la factura ya fue pagada totalmente');
            }
        });

        $("#registered-payments").on("click", ".registeredPayments", function()
        {
            selectedPayment = ($(this).attr('id').substring(1));
            paymentType = $(this).attr('name');
            amountPaid = parseFloat($(this).attr('value'));
            var r = confirm("Desea eliminar este pago en " + paymentType + " de Bs. " + amountPaid);
            if (r == false)
            {
                return false;
            }
            $("#pa" + selectedPayment).remove();
            
            deletePayment(parseFloat(selectedPayment));
            
            balance = balance + amountPaid;
        
            accumulatedPayment = accumulatedPayment - amountPaid;
            
            if (balance < 0)
            {
                amountPaid = amountPaid + balance;
            }
    
            indicatorUpdateAmount = 1;
            updateAmount();
            indicatorUpdateAmount = 0;
        });

        $("#print-invoice").click(function () 
        {			
            if (totalBill.toFixed(2) != accumulatedPayment.toFixed(2))
            {
                alert('El monto total de los pagos registrados (Bs.S ' + accumulatedPayment.toFixed(2) + ') es diferente al monto total de la factura Bs.S (' + totalBill.toFixed(2) + '). Por favor corrija...');
                return false;
            }   	
            var r= confirm('¿Está seguro de que desea guardar la facturar? Después no podrá hacer cambios');
            if (r == false)
            {
                return false;
            }
            $("#invoice-messages").html("Por favor espere...");
            payments.idTurn = $("#Turno").attr('value');
            payments.idParentsandguardians = idParentsandguardians;
            payments.invoiceDate = reversedDate;
            payments.client = $('#client').val();
            payments.typeOfIdentificationClient = $('#type-of-identification-client').val();
            payments.identificationNumberClient = $('#identification-number-client').val();;
            payments.fiscalAddress = $('#fiscal-address').val();
            payments.taxPhone = $('#tax-phone').val();
            payments.invoiceAmount = totalBill;
			payments.discount = discount;
			{
				payments.fiscal = 0;
			}
			else
			{
				payments.fiscal = 1;
			}
            uploadTransactions();
            loadPayments();
        });
		
        $('.select-discount').change(function(e) 
        {
            e.preventDefault();
			
			discount = 0;
			discountMode = '';
			discountAmount = 0;
					
			if ($('.select-discount').val() == 2)
			{
				totalGeneral = totalBalance;
				$('#total-general').html(totalGeneral.toFixed(2));
				totalGeneralDolar = Math.round(totalGeneral / dollarExchangeRate);
				$('#total-general-dolar').html(totalGeneralDolar.toFixed(2));	
			}
			else if ($('.select-discount').val() > 2)
			{
				$.post('<?php echo Router::url(["controller" => "Discounts", "action" => "searchDiscount"]); ?>', 
					{"id" : $('.select-discount').val() }, null, "json")          

				.done(function(response) 
				{
					if (response.success) 
					{
						discountMode = response.data.mode;
						discountAmount = response.data.amount;						
						if (response.data.mode == 'Porcentaje')
						{
							if (response.data.amount > 0)
							{
								discountDecimal = totalBalance * response.data.amount;
								discount = Math.round(discountDecimal);
							}
							else
							{
								positiveDiscount = response.data.amount * -1;
								discountDecimal = totalBalance * positiveDiscount;
								discount = (Math.round(discountDecimal)) * -1;
							}
						}
						else
						{
							discount = response.data.amount		
						}
						totalGeneral = totalBalance + discount; 
						$('#total-general').html(totalGeneral.toFixed(2));
						totalGeneralDolar = Math.round(totalGeneral / dollarExchangeRate);
						$('#total-general-dolar').html(totalGeneralDolar.toFixed(2));
					} 
					else 
					{
						alert('No se encontró el descuento');
					}
				})
				.fail(function(jqXHR, textStatus, errorThrown) 
				{
					alert('Algo falló en la búsqueda. Código de error: ' + textStatus);
				});
			}
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
		
            $.post('<?php echo Router::url(["controller" => "Rates", "action" => "updateDollar"]); ?>', 
                {"amount" : $('#dollar-exchange-rate').val() }, null, "json")          

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
		
        $('#adjust-fee').click(function(e) 
        {
            e.preventDefault();

			var adjInputCounter = 0;
			var adjModifiableFee = 0;
			var adjOriginalAmount = 0;
			var adjAmountPaid = 0;
			var adjIdAmountTransaction = '';
			var adjAmountPayable = 0;
			var stringAmount = '';
			var adjError = 0;
			
            $("#monthly-payment input").each(function (index) 
            {
				if (adjInputCounter == 1)
				{
					adjModifiableFee = parseFloat($(this).val());
					adjIdAmountTransaction = $(this).attr('id');
					adjInputCounter++;
				}
				else if (adjInputCounter == 2)
				{
					adjAmountPaid = parseFloat($(this).val());
					adjInputCounter++;					
				}
				else if (adjInputCounter == 3)
				{
					adjOriginalAmount = parseFloat($(this).val());					
					if (adjModifiableFee != adjOriginalAmount)
					{					
						if (adjModifiableFee > adjAmountPaid)
						{
							stringAmount = (adjModifiableFee - adjAmountPaid).toFixed(2);
							adjAmountPayable = parseFloat(stringAmount);
							updateInstallment(adjIdAmountTransaction.substring(2), adjAmountPayable, adjModifiableFee, adjAmountPayable);
							$('#' + adjIdAmountTransaction).css('background-color', '#ffffff');
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

// fin funciones Jquery

    }); 

</script>
