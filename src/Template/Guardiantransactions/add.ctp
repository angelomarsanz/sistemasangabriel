<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Registrar transacción bancaria</h2>
    		    <p style="text-align: justify;">Por favor registre los datos de la transferencia bancaria correspondiente al pago de inscripción
    		    y otros conceptos del año escolar 2017-2018</p>
    		    <p style="text-align: justify;">Cuenta corriente Banesco Nro. 0134-0220-51-2201022512, Rif: J-07573084-4, 
    		    a nombre de Unidad Educativa Colegio "San Gabriel Arcángel", correo electrónico u.esangabriel.admon@gmail.com</p>
    	</div>
        <?= $this->Form->create($guardiantransaction) ?>
        <fieldset>
            <?php
                echo $this->Form->input('parentsandguardian_id', ['type' => 'hidden', 'value' => $idParentsAndGuardian]); 
                echo $this->Form->input('bank', ['label' => 'Banco desde el cual hizo la transferencia: *', 'options' => 
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
                                        'Otro banco no especificado en la lista']]);

                setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                date_default_timezone_set('America/Caracas');

                echo $this->Form->input('date_transaction', ['label' => 'Fecha de la transacción: *']);
                echo $this->Form->input('time_transaction', ['label' => 'Hora de la transacción: *']);
                echo $this->Form->input('serial', ['label' => 'serial: *']);
                echo $this->Form->input('amount', ['label' => 'monto: *']);
                echo $this->Form->input('concept', ['label' => 'Concepto: *', 'options' => ['Renovación inscripción 2018-2019' => 'Renovación inscripción 2018-2019']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>