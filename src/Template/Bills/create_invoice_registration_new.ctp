<?php
    use Cake\Routing\Router; 
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h3><b>Cobro de matrícula alumnos nuevos</b></h3>
                    <h5 id="Turno" value=<?= $idTurn ?>>Fecha: <?= $dateTurn->format('d-m-Y') ?>, Turno: <?= $turn ?>, Cajero: <?= $current_user['first_name'] . ' ' . $current_user['surname'] ?></h5>
                </div>
            </div>
            <div class="row panel panel-default">
                <div class="col-md-4">
                    <br />
                    <label for="family">Por favor escriba los apellidos de la familia:</label>
                    <br />
                    <input type="text" class="form-control" id="family-search">
                    <br />
                    <button id="newfamily" class="btn btn-success">Listar familias nuevas</button>
                    <br />
                    <br />
                    <button id="everyfamily" class="btn btn-success">Listar familias del año escolar actual</button>
                    <br />
                    <br />
                    <div class="panel panel-default pre-scrollable" style="height:220px;">
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
                    <?= $this->Form->input('client', ['label' => 'Cliente:']) ?>
                    <?= $this->Form->input('type_of_identification_client', 
                        ['options' => 
                        [null => " ",
                        'V' => 'Cédula venezolano',
                        'E' => 'Cédula extranjero',
                        'P' => 'Pasaporte',
                        'J' => 'Rif Jurídico',
                        'G' => 'Rif Gubernamental'],
                        'label' => 'Tipo de documento de identificación:']) ?>
                    <?= $this->Form->input('identification_number_client', ['label' => 'Número de cédula o RIF:']) ?>
                </div>
                <div class="col-md-4">
                    <br />
                    <?= $this->Form->input('fiscal_address', ['label' => 'Dirección:']) ?>
                    <?= $this->Form->input('tax_phone', ['label' => 'Teléfono:']) ?>
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
                <div class="col-md-4">
                    <br />
                    <p><b>Alumnos relacionados:</b></p>
                    <div class="panel panel-default pre-scrollable" style="height:250px;">
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
                <div class="col-md-4">
                    <br />
                    <p><b>Cuotas del alumno:</b></p>
                    <div class="panel panel-default pre-scrollable" style="height:200px;">
                        <div class="panel-body">
                            <div class="table-responsive">          
                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th scope="col">Concepto</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Estado</th>
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
                        <button id="save-payments" class="btn btn-success" disabled>Facturar</button>
                    </div>  
                </div>
                <div class="col-md-4">
                    <br />
                    <p><b>Totales:</b></p>
                    <div class="panel panel-default" style="height:160px; padding: 0% 3% 0% 3%;">
                        <br />
                        <p><b>Alumno: <spam id="student-name"></spam></b></p>
                        <p><b>Cuotas: <spam id="student-concept"></spam></b></p>
                        <p><b>Saldo: Bs. <spam id="student-balance">0</spam></b></p>
                        <p><b>Total a pagar por la familia: Bs. <spam id="total-balance"></spam></b></p>   
                        <br />
                        <br />
                        <p id="student-messages"></p>       
                    </div>
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
                            <p><b>Sub-total Bs. <spam id="invoice-subtotal"></spam></b></p>
                            <p><b>Iva 12% Bs. 0 </b></p>
                            <p><b>Total Bs. <spam id="total-bill"></spam></spam></b></p>
                            <p><b>Pagado Bs. <spam id="paid-out"></spam></spam></b></p>
                            <p><b>Por pagar Bs. <spam id="to-pay"></spam></b></p>
                            <p><b>Cambio Bs. <spam id="change"></spam></b></p>
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
                                        'Otro banco no especificado en la lista']]) ?>;
                                        
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
                                        'Otro banco no especificado en la lista']]) ?>;
                                        
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
                                        'Otro banco no especificado en la lista']]) ?>;
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
                                        'Otro banco no especificado en la lista']]) ?>;
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
                                        'Otro banco no especificado en la lista']]) ?>;
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
    var customerEmail = " ";
    var totalBalance = 0;
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
    var studentBalance = 0;
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

    var selectedStudent = -1;
    var idStudent = 0;
    var studentName = " ";
    var scholarship = 0;
    var studentTransactions = "";
    var transactionIdentifier = 0;
    var monthlyPayment = " ";
    var transactionAmount = 0;
    var originalAmount = 0;
    var invoiced = 0;
    var partialPayment = 0;
    var paidOut = 0;
    var firstName = " ";
    var secondName = " ";
    var surname = " ";
    var secondSurname = " ";
    var concept = " ";
    var idStudentTransactions = " ";
    var amountPayable = 0;
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
    payments.fiscal = 1; 

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
        $('#identification').val(" ");
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
        $("#invoice-subtotal").html(" ");
        $("#total-bill").html(" ");
        $('#paid-out').text(" ");
        $('#to-pay').text(" ");
        $('#change').text(" ");
        
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
        totalBill = 0;
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
        $('#paid-out').text(accumulatedPayment);
            
        if (balance > 0)
        {
            $('#to-pay').text(balance);
            $('#change').text(0);
            $('#amount-01').val(balance);
            $('#amount-02').val(balance);
            $('#amount-03').val(balance);
            $('#amount-04').val(balance);
            $('#amount-05').val(balance);
            $('#amount-06').val(balance);
            $('#amount-07').val(balance);
        }
        else
        {
            $('#to-pay').text(0);
            $('#change').text(-(balance));
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
        dbTransactionAmount FLOAT, \
        dbOriginalAmount FLOAT, \
        dbAmountPayable FLOAT, \
        dbInvoiced INTEGER, \
        dbPartialPayment INTEGER, \
        dbPaidOut INTEGER, \
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
        var insertStatement = "INSERT INTO studentTransactions \
        (dbId, \
        dbIdStudent, \
        dbStudentName, \
        dbMonthlyPayment, \
        dbScholarship, \
        dbTransactionAmount, \
        dbOriginalAmount, \
        dbAmountPayable, \
        dbInvoiced, \
        dbPartialPayment, \
        dbPaidOut, \
        dbObservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        var tpId = transactionIdentifier;
        var tpIdStudent = idStudent;
        var tpStudentName = studentName + " - " + grade;
        var tpMonthlyPayment = monthlyPayment;
        var tpScholarship = scholarship;
        var tpTransactionAmount = transactionAmount;
        var tpOriginalAmount = originalAmount;
        var tpAmountPayable = amountPayable;
        var tpInvoiced = invoiced;
        var tpPartialPayment = partialPayment;
        var tpPaidOut = paidOut;
        var tpObservation = " ";

        db.transaction(function (tx) 
        {
            tx.executeSql(insertStatement, 
            [tpId,
            tpIdStudent,
            tpStudentName,
            tpMonthlyPayment,
            tpScholarship,
            tpTransactionAmount,
            tpOriginalAmount,
            tpAmountPayable,
            tpInvoiced,
            tpPartialPayment,
            tpPaidOut,
            tpObservation], null, onError); 
        });
    }
    
    function insertRecordPayments() // Get value from Input and insert record . Function Call when Save/Submit Button Click..
    {
        var insertPayments = "INSERT INTO payments \
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
                        studentName = item['dbStudentName'];
                    }
                    
                    monthlyPayment = item['dbMonthlyPayment'];

                    if (item['dbPaidOut'] == 'false')
                    {
                        if (item['dbInvoiced'] == "true")
                        {
                            studentBalance = studentBalance + item['dbTransactionAmount'];
                            detailLine += "<tr id=tra" + item['dbId'] + ">  \
                                <td style='background-color:#c2c2d6;'>" + item['dbMonthlyPayment'] + "</td> \
                                <td style='background-color:#c2c2d6;'>" + item['dbTransactionAmount'] + "</td> \
                                <td style='background-color:#c2c2d6;'><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbTransactionAmount'] + " checked='checked' disabled></td></tr>";
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
                            detailLine += "<tr id=tra" + item['dbId'] + ">  \
                                <td>" + item['dbMonthlyPayment'] + "</td> \
                                <td>" + item['dbTransactionAmount'] + "</td> \
                                <td><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value=" + item['dbTransactionAmount'] + " disabled></td></tr>";
                        }
                    }
                    else 
                    {
                            detailLine += "<tr id=tra" + item['dbId'] + ">  \
                                <td>" + item['dbMonthlyPayment'] + "</td> \
                                <td>" + item['dbTransactionAmount'] + "</td> \
                                <td><input type='checkbox' id=tr" + item['dbId'] + " name='" + item['dbMonthlyPayment'] + "' value='Pagada' checked='checked' disabled> (Pagada)</td></tr>";
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
                    $("#student-balance").html(studentBalance);
                    $("#mark-quotas").html(nextPayment);  
                    $("#mark-quotas").attr('disabled', false);
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
                    + item['dbTransactionAmount']
                    + " "
                    + item['dbOriginalAmount']
                    + " "
                    + item['dbAmountPayable']
                    + " "
                    + item['dbInvoiced']
                    + " "
                    + item['dbPartialPayment']
                    + " "
                    + item['dbPaidOut']
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
            <td>" + amountPaid + "</td> \
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
                    tbStudentTransactions[transactionCounter].monthlyPayment = item['dbMonthlyPayment'];
                    tbStudentTransactions[transactionCounter].amountPayable = item['dbAmountPayable'];
                    tbStudentTransactions[transactionCounter].observation = item['dbObservation']; 
                    transactionCounter++;
                }
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
            
                $.redirect('/sistemasangabriel/bills/recordInvoiceData', {headboard : payments, studentTransactions : stringStudentTransactions, paymentsMade : stringPaymentsMade }); 
            });
        });
    }
    
    function listFamilies(newFamily)
    {
        $.post('/sistemasangabriel/students/everyfamily', {"newFamily" : newFamily}, null, "json")
            
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
                $("#response-container").html(" ");
                $("#response-container").html(output);
            } 
            else 
            {
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
            }
                
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
                
            $("#response-container").html("Algo ha fallado: " + textStatus);
                
        });
    }

// Funciones Jquery

    $(document).ready(function() 
    {
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
                       
            $.post('/sistemasangabriel/students/relatedstudents', {"id" : idFamily, "new" : 1}, null, "json")        
                     
            .done(function(response) 
            {
                if (response.success) 
                {
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
                        
                    $('#family').val(nameFamily + " (" + nameRepresentative + ")");
                    $('#client').val(client);
                    $('#type-of-identification-client').val(typeOfIdentificationClient);
                    $('#identification-number-client').val(identificationNumberClient);
                    $('#fiscal-address').val(fiscalAddress);
                    $('#tax-phone').val(taxPhone);
                    $('#email').val(customerEmail);
                        
                    $.each(response.data.students, function(key, value) 
                    {
                        $.each(value, function(userkey, uservalue) 
                        {
                            if (userkey == 'studentTransactions')
                            {
                                $.each(uservalue, function(userkey2, uservalue2) 
                                {
                                    $.each(uservalue2, function(userkey3, uservalue3)
                                    {
                                        if (userkey3 == 'id')
                                        {
                                            transactionIdentifier = uservalue3;
                                        }
                                        else if (userkey3 == 'transaction_description')
                                        {
                                            monthlyPayment = uservalue3;
                                        }
                                        else if (userkey3 == 'amount')
                                        {
                                            transactionAmount = uservalue3;
                                        }
                                        else if (userkey3 == 'original_amount')
                                        {
                                            originalAmount = uservalue3;
                                        }
                                        else if (userkey3 == 'invoiced')
                                        {
                                            invoiced = uservalue3;
                                        }
                                        else if (userkey3 == 'partial_payment')
                                        {
                                            partialPayment = uservalue3;
                                        }
                                        else if (userkey3 == 'paid_out')
                                        {
                                            paidOut = uservalue3;
                                            studentName = surname + ' ' + secondSurname + ' ' + firstName + ' ' + secondName;
                                            amountPayable = transactionAmount;
                                            if (substr(monthlyPayment, 0, 3) == "Ago" || 
											substr(monthlyPayment, 0, 9) == "Matrícula")
                                            {
                                                insertRecord();
                                            }
                                        }
                                    });
                                });
                            }
                            else if (userkey == 'id')
                            {
                                students += "<tr id=st" + uservalue + " class='students'>";
                                idStudent = uservalue;
                            }
                            else if (userkey == 'scholarship')
                            {
                                if (uservalue == 0)
                                {
                                    students += "<td>Regular</td></tr>";
                                    scholarship = 0;
                                }
                                else
                                {
                                    students += "<td>Becado</td></tr>";
                                    scholarship = 1;
                                }
                            }
                            else if (userkey == 'surname')
                            {
                                students += "<td>" + uservalue + " ";
                                surname = uservalue;
                            }
                            else if (userkey == 'second_surname')
                            {
                                students += uservalue + "</td>";
                                secondSurname = uservalue;
                            }
                            else if (userkey == 'first_name')
                            {
                                students += "<td>" + uservalue + " ";
                                firstName = uservalue;
                            }
                            else if (userkey == 'second_name')
                            {
                                students += uservalue + "</td>";
                                secondName = uservalue;
                            }
                            else if (userkey == 'level_of_study')
                            {
                                students += "<td>" + uservalue + "</td>";
                                grade = uservalue;
                            }
                            else if (userkey == 'section')
                            {
                                students += "<td>No asignada</td>";
                                section = uservalue;
                            }
                            else if (userkey == 'schoolYearFrom')
                            {
                                schoolYearFrom = uservalue;
								schoolYearUntil = uservalue + 1;
                            }
                        });
                    });
                    $("#header-messages").html(" ");
                    $("#related-students").html(students);
                } 
                else 
                {
                    $("#header-messages").html('No ha habido suerte: ' + response.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#header-messages").html("Algo ha fallado: " + textStatus);
            });  
        });

        $('#update-data').click(function(e) 
        {
            e.preventDefault();

            $("#header-messages").html("Por favor espere...");


            $.post('/sistemasangabriel/parentsandguardians/updateClientData', 
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
        });

        $("#related-students").on("click", ".students", function()
        {
            if (totalBill == 0)
            {
                $("#student-messages").html("<p>Por favor espere...</p>");
    
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
            }            
        });
        
        $("#mark-quotas").click(function () 
        {
            var firstInstallment = " ";
            var lastInstallment = " ";
            var flaggedFlag = 0;
            
            $("#monthly-payment input").each(function (index) 
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
                            $("#student-balance").html(studentBalance);
                            totalBalance = totalBalance + parseFloat($(this).attr('value'));
                            $("#total-balance").html(totalBalance);
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
            transactionDescription = " ";

            $("#monthly-payment input").each(function (index) 
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
                            $("#student-balance").html(studentBalance);
                            totalBalance = totalBalance - transactionAmount;
                            $("#total-balance").html(totalBalance);
                            return false;
                        }
                    }
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
                    $("#student-balance").html(studentBalance);
                    totalBalance = totalBalance - transactionAmount;
                    $("#total-balance").html(totalBalance);
                }
            }
        }); 

        $("#save-payments").click(function(e)
        {
            e.preventDefault();
            
            $("#mark-quotas").attr('disabled', true);
            $("#uncheck-quotas").attr('disabled', true);
            $("#save-payments").attr('disabled', true);

            showInvoiceLines();
            
            totalBill = totalBalance;
            $("#invoice-subtotal").html(totalBill);
            $("#total-bill").html(totalBill);
            balance = totalBalance - accumulatedPayment;
            indicatorUpdateAmount = 1;
            updateAmount();
            indicatorUpdateAmount = 0;
            activateInvoiceButtons();
        });        

        $("#automatic-adjustment").click(function(e) 
        {
            e.preventDefault();
        
            var remainingBalance = accumulatedPayment;
    
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
            totalBill = accumulatedPayment;
            $("#invoice-subtotal").html(totalBill);
            $("#total-bill").html(totalBill);
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
            $("#invoice-subtotal").html(totalBill);
            $("#total-bill").html(totalBill);
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
                balance = totalBalance;
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

                alert('Pago registrado con éxito: Bs. ' + amountPaid);

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
            if (totalBill > accumulatedPayment)
            {
                alert('Los pagos registrados no son suficientes para cancelar la factura');
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
            payments.schoolYear = "Año escolar " + schoolYearFrom + "-" + schoolYearUntil;
            payments.client = $('#client').val();
            payments.typeOfIdentificationClient = $('#type-of-identification-client').val();
            payments.identificationNumberClient = $('#identification-number-client').val();;
            payments.fiscalAddress = $('#fiscal-address').val();
            payments.taxPhone = $('#tax-phone').val();
            payments.invoiceAmount = totalBill;
            uploadTransactions();
            loadPayments();
        });

// fin funciones Jquery

    }); 

</script>