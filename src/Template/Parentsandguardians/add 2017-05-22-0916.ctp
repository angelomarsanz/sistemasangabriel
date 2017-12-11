<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <?php if( (isset($current_user)) && ($current_user['role'] == 'Representante') ): ?>
                <h2>Datos adicionales del padre o representante</h2>
            <?php else: ?>
                <h2>Registrar datos del padre y/o representante</h2>
            <?php endif; ?>
        </div>
        <?= $this->Form->create($parentsandguardian) ?>
        <fieldset>
            <b>Datos básicos del representante:</b>
            <div class="row panel panel-default">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <br />
                    <?php
                        if ((isset($current_user)) && ($current_user['role'] == 'Representante'))
                        {
                            echo $this->Form->input('surname', ['label' => 'Primer apellido: *', 'value' => $current_user['surname'], 'style' => 'background-color: #ffff99;']);
                            echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:', 'value' => $current_user['second_surname'], 'style' => 'background-color: #ffff99;']);
                            echo $this->Form->input('first_name', ['label' => 'Primer nombre: *', 'value' => $current_user['first_name'], 'style' => 'background-color: #ffff99;']);
                            echo $this->Form->input('second_name', ['label' => 'Segundo nombre:', 'value' => $current_user['second_name'], 'style' => 'background-color: #ffff99;']);
                            echo $this->Form->input('sex', ['options' => ['M' => 'Masculino', 'F' => 'Femenino'], 'label' => 'Sexo:', 'value' => $current_user['sex'], 'style' => 'background-color: #ffff99;']);
                        }
                        else
                        {
                            echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                            echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
                            echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                            echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
                            echo $this->Form->input('sex', ['options' => [null => " ", 'M' => 'Masculino', 'F' => 'Femenino'], 'label' => 'Sexo: *']);
                        }
                        echo $this->Form->input('type_of_identification', 
                            ['options' => 
                            [null => ' ',
                            'V' => 'Cédula venezolano',
                            'E' => 'Cédula extranjero',
                            'P' => 'Pasaporte'],
                            'label' => 'Tipo de documento de identificación: *']);
                        echo $this->Form->input('identidy_card', ['label' => 'Número de cédula o pasaporte: *']);
                        if ((isset($current_user)) && ($current_user['role'] == 'Representante'))
                        {
                            echo $this->Form->input('email', ['label' => 'Correo electrónico: *', 'value' => $current_user['email'], 'style' => 'background-color: #ffff99;']);
                            echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular: *', 'value' => $current_user['cell_phone'], 'style' => 'background-color: #ffff99;']);
                        }
                        else
                        {
                            echo $this->Form->input('email', ['label' => 'Correo electrónico: *']);
                            echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular: *']);
                        }
                        echo $this->Form->input('landline', ['label' => 'Teléfono fijo residencial: *']);
                        echo $this->Form->input('address', ['label' => 'Dirección de habitación: *']);
                        echo $this->Form->input('profession', ['label' => 'Profesión: *']);
                        echo $this->Form->input('item', ['label' => 'Rubro: *', 'options' => 
                            [null => " ",
                            'Cirugía plástica' => 'Cirugía plástica',
                            'Computación' => 'Computación',
                            'Construcción' => 'Construcción',
                            'Contabilidad' => 'Contabilidad',
                            'Diseño gráfico' => 'Diseño gráfico',
                            'Educación' => 'Educación',
                            'Electricidad' => 'Electricidad',
                            'Enfermería' => 'Enfermería',
                            'Farmacia' => 'Farmacia',
                            'Floristería' => 'Floristería',
                            'Fotografía' => 'Fotografía',
                            'Ganadería' => 'Ganadería',
                            'Hotel' => 'Hotel',
                            'Limpieza' => 'Limpieza',
                            'Literatura' => 'Literatura',
                            'Mecánica' => 'Mecánica',
                            'Medicina general' => 'Medicina general',
                            'Militar' => 'Militar',
                            'Obrero' => 'Obrero',
                            'Odontología' => 'Odontología',
                            'Oftalmología' => 'Oftalmología',
                            'Panadería' => 'Panadería',
                            'Peluquería' => 'Peluquería',
                            'Periodismo' => 'Periodismo',
                            'Pescadería' => 'Pescadería',
                            'Pintura artística' => 'Pintura artística',
                            'Plomería' => 'Plomería',
                            'Policía' => 'Policía',
                            'Política' => 'Política',
                            'Psiquiatría' => 'Psiquiatría',
                            'Restaurant' => 'Restaurant',
                            'Sastrería' => 'Sastrería',
                            'Taxis' => 'Taxis',
                            'Teatro, tv o cine' => 'Teatro, tv o cine',
                            'Traductor' => 'Traductor',
                            'Ventas' => 'Ventas',
                            'Veterinaria' => 'Veterinaria',
                            'Viajes y turismos' => 'Viajes y turismos',
                            'Otro, no especificado']]);
                        echo $this->Form->input('workplace', ['label' => 'Empresa o institución donde trabaja: *']);
                        echo $this->Form->input('professional_position', ['label' => 'Puesto que ocupa: *']);
                        echo $this->Form->input('work_phone', ['label' => 'Teléfono de trabajo: *']);
                        echo $this->Form->input('work_address', ['label' => 'Dirección del trabajo: *']);
                    ?>
                </div>
            </div>
            <b>Datos de la familia:</b>
            <div class="row panel panel-default">
                <div class="col-md-12">
                    <br />
                    <?php
                        echo $this->Form->input('family', ['label' => 'Por favor introduzca los dos apellidos que identifican su familia: *']);
                    ?>
                    <br />
                    <p><b>Datos del Padre (modifique si no son los correctos):</b></p>
                    <br />
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-11">
                            <?php
                                echo $this->Form->input('surname_father', ['label' => 'Primer apellido: *']);
                                echo $this->Form->input('second_surname_father', ['label' => 'Segundo apellido:']);
                                echo $this->Form->input('first_name_father', ['label' => 'Primer nombre: *']);
                                echo $this->Form->input('second_name_father', ['label' => 'Segundo nombre:']);
                                echo $this->Form->input('type_of_identification_father', 
                                    ['options' => 
                                    [null => " ",
                                    'V' => 'Cédula venezolano',
                                    'E' => 'Cédula extranjero',
                                    'P' => 'Pasaporte'],
                                    'label' => 'Tipo de documento de identificación: *']);
                                echo $this->Form->input('identidy_card_father', ['label' => 'Nro. documento de identidad: *']);
                                echo $this->Form->input('email_father', ['label' => 'Email: *']);
                                echo $this->Form->input('cell_phone_father', ['label' => 'Nro. Celular: *']);
                                echo $this->Form->input('landline_father', ['label' => 'Teléfono fijo: *']);
                                echo $this->Form->input('address_father', ['label' => 'Dirección: *']);
                            ?>
                        </div>
                    </div>
                    <br />
                    <p><b>Datos de la Madre (modifique si no son los correctos):</b></p>
                    <br />
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-11">
                            <?php
                                echo $this->Form->input('surname_mother', ['label' => 'Primer apellido: *']);
                                echo $this->Form->input('second_surname_mother', ['label' => 'Segundo apellido:']);
                                echo $this->Form->input('first_name_mother', ['label' => 'Primer nombre: *']);
                                echo $this->Form->input('second_name_mother', ['label' => 'Segundo nombre:']);
                                echo $this->Form->input('type_of_identification_mother', 
                                    [null => " ",
                                    'options' => 
                                    [null => " ",
                                    'V' => 'Cédula venezolana',
                                    'E' => 'Cédula extranjera',
                                    'P' => 'Pasaporte'],
                                    'label' => 'Tipo de documento de identificación: *']);
                                echo $this->Form->input('identidy_card_mother', ['label' => 'Nro. documento de identidad: *']);
                                echo $this->Form->input('email_mother', ['label' => 'Email: *']);
                                echo $this->Form->input('cell_phone_mother', ['label' => 'Nro. Celular: *']);
                                echo $this->Form->input('landline_mother', ['label' => 'Teléfono fijo: *']);
                                echo $this->Form->input('address_mother', ['label' => 'Dirección: *']);
                            ?>
                        </div>
                    </div>
                </div>        
            </div>
            <b>Datos para la factura (escoge una opción o escribe los datos de la factura):</b>
            <div class="row panel panel-default">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <br />
                    <button id="guardian-data" class="btn btn-success">Datos del representante</button>
                    <button id="father-data" class="btn btn-success">Datos del padre</button>            
                    <button id="mother-data" class="btn btn-success">Datos de la madre</button>
                    <br />
                    <br />
                    <?php
                        echo $this->Form->input('client', ['label' => 'Nombre o razón social: *']);
                        echo $this->Form->input('type_of_identification_client', 
                                    ['options' => 
                                    [null => " ",
                                    'V' => 'Cédula venezolano',
                                    'E' => 'Cédula extranjero',
                                    'P' => 'Pasaporte',
                                    'J' => 'Rif Jurídico',
                                    'G' => 'Rif Gubernamental'],
                                    'label' => 'Tipo de documento de identificación: *']);
                        echo $this->Form->input('identification_number_client', ['label' => 'Nro. documento de identidad: *']);
                        echo $this->Form->input('fiscal_address', ['label' => 'Dirección fiscal: *']);
                        echo $this->Form->input('tax_phone', ['label' => 'Teléfono: *']);
                    ?>
                </div>
            </div>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-parentsandguardians', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        var copyFatherData = function()
        {
            if ($("#sex").val() == "M")
            {
                $("#first-name-father").val($("#first-name").val());
                $("#first-name-father").css('background-color', '#ffff99'); 
                
                $("#second-name-father").val($("#second-name").val());
                $("#second-name-father").css('background-color', '#ffff99');
                
                $("#surname-father").val($("#surname").val());
                $("#surname-father").css('background-color', '#ffff99');
                
                $("#second-surname-father").val($("#second-surname").val());
                $("#second-surname-father").css('background-color', '#ffff99');
                
                $("#type-of-identification-father").val($("#type-of-identification").val());
                $("#type-of-identification-father").css('background-color', '#ffff99');
                
                $("#identidy-card-father").val($("#identidy-card").val());
                $("#identidy-card-father").css('background-color', '#ffff99');
                
                $("#email-father").val($("#email").val());
                $("#email-father").css('background-color', '#ffff99');
                
                $("#cell-phone-father").val($("#cell-phone").val());
                $("#cell-phone-father").css('background-color', '#ffff99');
            }
            $("#landline-father").val($("#landline").val());
            $("#landline-father").css('background-color', '#ffff99');
                
            $("#address-father").val($("#address").val());
            $("#address-father").css('background-color', '#ffff99');
        };
        
        var copyMotherData = function()
        {
            if ($("#sex").val() == "F")
            {
                $("#first-name-mother").val($("#first-name").val());
                $("#first-name-mother").css('background-color', '#ffff99'); 
                
                $("#second-name-mother").val($("#second-name").val());
                $("#second-name-mother").css('background-color', '#ffff99');
                
                $("#surname-mother").val($("#surname").val());
                $("#surname-mother").css('background-color', '#ffff99');
                
                $("#second-surname-mother").val($("#second-surname").val());
                $("#second-surname-mother").css('background-color', '#ffff99');
                
                $("#type-of-identification-mother").val($("#type-of-identification").val());
                $("#type-of-identification-mother").css('background-color', '#ffff99');
                
                $("#identidy-card-mother").val($("#identidy-card").val());
                $("#identidy-card-mother").css('background-color', '#ffff99');
                
                $("#email-mother").val($("#email").val());
                $("#email-mother").css('background-color', '#ffff99');
                
                $("#cell-phone-mother").val($("#cell-phone").val());
                $("#cell-phone-mother").css('background-color', '#ffff99');
            }
            $("#landline-mother").val($("#landline").val());
            $("#landline-mother").css('background-color', '#ffff99');
                
            $("#address-mother").val($("#address").val());
            $("#address-mother").css('background-color', '#ffff99');
        };
        
        var copyGuardianClient = function()
        {
            $("#client").val($("#first-name").val() + " " + $("#second-name").val() + " " + $("#surname").val() + " " + $("#second-surname").val());
            $("#client").css('background-color', '#ffff99'); 
                
            $("#type-of-identification-client").val($("#type-of-identification").val());
            $("#type-of-identification-client").css('background-color', '#ffff99');
                
            $("#identification-number-client").val($("#identidy-card").val());
            $("#identification-number-client").css('background-color', '#ffff99');

            $("#fiscal-address").val($("#address").val());
            $("#fiscal-address").css('background-color', '#ffff99');

            if ($("#landline").val() != " ")
            {
                $("#tax-phone").val($("#landline").val());
            }
            else
            {
                $("#tax-phone").val($("#cell-phone").val());
            }
            $("#tax-phone").css('background-color', '#ffff99');
        };
        
        var copyFatherClient = function()
        {
            $("#client").val($("#first-name-father").val() + " " + $("#second-name-father").val() + " " + $("#surname-father").val() + " " + $("#second-surname-father").val());
            $("#client").css('background-color', '#ffff99'); 
                
            $("#type-of-identification-client").val($("#type-of-identification-father").val());
            $("#type-of-identification-client").css('background-color', '#ffff99');
                
            $("#identification-number-client").val($("#identidy-card-father").val());
            $("#identification-number-client").css('background-color', '#ffff99');

            $("#fiscal-address").val($("#address-father").val());
            $("#fiscal-address").css('background-color', '#ffff99');

            if ($("#landline-father").val() != " ")
            {
                $("#tax-phone").val($("#landline-father").val());
            }
            else
            {
                $("#tax-phone").val($("#cell-phone-father").val());
            }
            $("#tax-phone").css('background-color', '#ffff99');
        };

        var copyMotherClient = function()
        {
            $("#client").val($("#first-name-mother").val() + " " + $("#second-name-mother").val() + " " + $("#surname-mother").val() + " " + $("#second-surname-mother").val());
            $("#client").css('background-color', '#ffff99'); 
                
            $("#type-of-identification-client").val($("#type-of-identification-mother").val());
            $("#type-of-identification-client").css('background-color', '#ffff99');
                
            $("#identification-number-client").val($("#identidy-card-mother").val());
            $("#identification-number-client").css('background-color', '#ffff99');

            $("#fiscal-address").val($("#address-mother").val());
            $("#fiscal-address").css('background-color', '#ffff99');

            if ($("#landline-mother").val() != " ")
            {
                $("#tax-phone").val($("#landline-mother").val());
            }
            else
            {
                $("#tax-phone").val($("#cell-phone-mother").val());
            }
            $("#tax-phone").css('background-color', '#ffff99');
        };

        $('#surname-father').click(function(e) 
        {
            e.preventDefault();
                
            copyFatherData();
        });

        $('#surname-father').focus(function(e) 
        {
            e.preventDefault();
                
            copyFatherData();
        });

        $('#surname-mother').click(function(e) 
        {
            e.preventDefault();
                
            copyMotherData();
        });

        $('#surname-mother').focus(function(e) 
        {
            e.preventDefault();
                
            copyMotherData();
        });

        $('#guardian-data').click(function(e) 
        {
            e.preventDefault();
                
            copyGuardianClient();
        });

        $('#father-data').click(function(e) 
        {
            e.preventDefault();
                
            copyFatherClient();
        });

        $('#mother-data').click(function(e) 
        {
            e.preventDefault();
                
            copyMotherClient();
        });

        $('#save-parentsandguardians').click(function(e) 
        {
            $('#surname').val($('#surname').val().toUpperCase());
            $('#second-surname').val($('#second-surname').val().toUpperCase());
            $('#first-name').val($('#first-name').val().toUpperCase());
            $('#second-name').val($('#second-name').val().toUpperCase());
            $('#email').val($('#email').val().toLowerCase());
            $('#address').val($('#address').val().toUpperCase());
            $('#profession').val($('#profession').val().toUpperCase());
            $('#workplace').val($('#workplace').val().toUpperCase());
            $('#professional-position').val($('#professional-position').val().toUpperCase());
            $('#work-phone').val($('#work-phone').val().toUpperCase());
            $('#work-address').val($('#work-address').val().toUpperCase());

            $('#family').val($('#family').val().toUpperCase());

            $('#surname-father').val($('#surname-father').val().toUpperCase());
            $('#second-surname-father').val($('#second-surname-father').val().toUpperCase());
            $('#first-name-father').val($('#first-name-father').val().toUpperCase());
            $('#second-name-father').val($('#second-name-father').val().toUpperCase());
            $('#email-father').val($('#email-father').val().toLowerCase());
            $('#address-father').val($('#address-father').val().toUpperCase());
            
            $('#surname-mother').val($('#surname-mother').val().toUpperCase());
            $('#second-surname-mother').val($('#second-surname-mother').val().toUpperCase());
            $('#first-name-mother').val($('#first-name-mother').val().toUpperCase());
            $('#second-name-mother').val($('#second-name-mother').val().toUpperCase());
            $('#email-mother').val($('#email-mother').val().toLowerCase());
            $('#address-mother').val($('#address-mother').val().toUpperCase());

            $('#client').val($('#client').val().toUpperCase());
            $('#fiscal-address').val($('#fiscal-address').val().toUpperCase());
        });
    });    
</script>