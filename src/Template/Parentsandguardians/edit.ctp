<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <?php if ($action == 'view'): ?>
                <p><?= $this->Html->link(__('Volver'), ['controller' => $controller, 'action' => $action, $parentsandguardian->id], ['class' => 'btn btn-sm btn-default']) ?></p>
            <?php endif; ?> 
            <h2>Actualizar datos del padre o representante</h2>
        </div>
        <?= $this->Form->create($parentsandguardian, ['type' => 'file']) ?>
        <fieldset>
            <b>Datos básicos del representante:</b>
            <div class="row panel panel-default">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <br />
                    <?php
                        if ((isset($current_user)) && ($current_user['role'] != 'Representante'))
                        {
                            echo $this->Form->input('guardian', ['label' => 'Eliminado (Si/No):']);
                        }
                        echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                        echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
                        echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                        echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
                        echo $this->Form->input('sex', ['options' => [null => " ", 'M' => 'Masculino', 'F' => 'Femenino'], 'label' => 'Sexo: *']);
                        echo $this->Form->input('type_of_identification', 
                            ['options' => 
                            [null => ' ',
                            'V' => 'Cédula venezolano',
                            'E' => 'Cédula extranjero',
                            'P' => 'Pasaporte'],
                            'label' => 'Tipo de documento de identificación: *']);
                        echo $this->Form->input('identidy_card', ['label' => 'Número de cédula o pasaporte: *', 'type' => 'number']);
                        if ((isset($current_user)) && ($current_user['role'] == 'Representante'))
                        {
                            echo $this->Form->input('email', ['label' => 'Correo electrónico: *']);
                            echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular: *']);
                        }
                        else
                        {
                            echo $this->Form->input('email', ['label' => 'Correo electrónico: *']);
                            echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular: *']);
                        }
                        echo $this->Form->input('landline', ['label' => 'Teléfono fijo residencial: *']);
                        echo $this->Form->input('address', ['label' => 'Dirección de habitación: *']);
                        echo $this->Form->input('profession', ['label' => 'Profesión u oficio: *']);
                    ?>
                    <div class="rubro">
                    <?php
                        echo $this->Form->input('item', ['label' => 'Rubro: *', 'options' => 
                            [null => " ",
                            'Administración' => 'Administración',
                            'Alimentación,' => 'Alimentación',
                            'Asesoría y seguridad' => 'Asesoría y seguridad',
                            'Bancos' => 'Bancos',
							'Bisutería' => 'Bisutería',
                            'Carnicería' => 'Carnicería',
                            'Derecho' => 'Derecho',
                            'Cirugía plástica' => 'Cirugía plástica',
                            'Computación' => 'Computación',
                            'Construcción' => 'Construcción',
                            'Contabilidad' => 'Contabilidad',
                            'Diseño gráfico' => 'Diseño gráfico',
							'Diseño y programación web' => 'Diseño y programación web', 
                            'Educación' => 'Educación',
                            'Electricidad' => 'Electricidad',
                            'Enfermería' => 'Enfermería',
                            'Farmacia' => 'Farmacia',
                            'Ferretaría' => 'Ferretería',
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
                            'Productos de limpieza' => 'Productos de limpieza',
                            'Psiquiatría' => 'Psiquiatría',
							'Publicidad y mercadeo' => 'Publicidad y mercadeo',
                            'Restaurant' => 'Restaurant',
                            'Sastrería' => 'Sastrería',
							'Seguros' => 'Seguros',
                            'Taxis' => 'Taxis',
                            'Teatro, tv o cine' => 'Teatro, tv o cine',
                            'Traductor' => 'Traductor',
                            'Ventas' => 'Ventas',
                            'Veterinaria' => 'Veterinaria',
                            'Viajes y turismos' => 'Viajes y turismos',
                            'Otro, no especificado en esta lista' => 'Otro, no especificado en esta lista']]);
                    ?>
                    </div>
                    <?php
                        echo $this->Form->input('item_not_specified', ['label' => 'Si el rubro a que usted se dedica no está en lista anterior, por favor especifique:', 'disabled' => 'disabled']);
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
                                echo $this->Form->input('identidy_card_father', ['label' => 'Nro. documento de identidad: *', 'type' => 'number']);
                                echo $this->Form->input('profession_father', ['label' => 'Profesión u oficio: *']);
                                echo $this->Form->input('email_father', ['label' => 'Email: *']);
                                echo $this->Form->input('cell_phone_father', ['label' => 'Nro. Celular: *']);
                                echo $this->Form->input('work_phone_father', ['label' => 'Teléfono trabajo: *']);
                                echo $this->Form->input('landline_father', ['label' => 'Teléfono habitación: *']);
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
                                echo $this->Form->input('identidy_card_mother', ['label' => 'Nro. documento de identidad: *', 'type' => 'number']);
                                echo $this->Form->input('profession_mother', ['label' => 'Profesión u oficio: *']);
                                echo $this->Form->input('email_mother', ['label' => 'Email: *']);
                                echo $this->Form->input('cell_phone_mother', ['label' => 'Nro. Celular: *']);
                                echo $this->Form->input('work_phone_mother', ['label' => 'Teléfono trabajo: *']);
                                echo $this->Form->input('landline_mother', ['label' => 'Teléfono habitación: *']);
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
                    <?= $this->Form->input('fiscal_address', ['label' => 'Dirección:', 'class' => 'campo-resaltado']) ?>
					<div id="mensaje-direccion-fiscal" class="mensajes-usuario"></div>
                    <?= $this->Form->input('tax_phone', ['label' => 'Teléfono:', 'class' => 'entero campo-resaltado']) ?>
					<div id="mensaje-telefono" class="mensajes-usuario"></div>
                </div>
            </div>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-parentsandguardians', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    function displayVals() 
    {
        if ($("#item").val() == "Otro, no especificado en esta lista")
        {
            $("#item-not-specified").attr('disabled', false);
            $("#item-not-specified").attr('required', true);

//          $('.rubro select').append("<option value='0'>Seleccionar</option>");
        }
        else
        {
            $("#item-not-specified").val(" ");
            $("#item-not-specified").attr('disabled', true);
            $("#item-not-specified").attr('required', false);
        }
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

                $("#work-phone-father").val($("#work-phone").val());
                $("#work-phone-father").css('background-color', '#ffff99');

                $("#profession-father").val($("#profession").val());
                $("#profession-father").css('background-color', '#ffff99');
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
                
                $("#work-phone-mother").val($("#work-phone").val());
                $("#work-phone-mother").css('background-color', '#ffff99');

                $("#profession-mother").val($("#profession").val());
                $("#profession-mother").css('background-color', '#ffff99');
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
		
		$('.entero').numeric();

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
			resultado = validarDatosFiscales();
			
			if (resultado > 0)
			{
				alert("Estimado representante uno o más datos fiscales presentan errores. Por favor revise");
				return false;
			}
			else
			{		
				$('#surname').val($.trim($('#surname').val().toUpperCase()));
				$('#second-surname').val($.trim($('#second-surname').val().toUpperCase()));
				$('#first-name').val($.trim($('#first-name').val().toUpperCase()));
				$('#second-name').val($.trim($('#second-name').val().toUpperCase()));
				$('#email').val($.trim($('#email').val().toLowerCase()));
				$('#address').val($.trim($('#address').val().toUpperCase()));
				$('#profession').val($.trim($('#profession').val().toUpperCase()));
				$('#workplace').val($.trim($('#workplace').val().toUpperCase()));
				$('#professional-position').val($.trim($('#professional-position').val().toUpperCase()));
				$('#work-phone').val($.trim($('#work-phone').val().toUpperCase()));
				$('#work-address').val($.trim($('#work-address').val().toUpperCase()));

				$('#family').val($.trim($('#family').val().toUpperCase()));

				$('#surname-father').val($.trim($('#surname-father').val().toUpperCase()));
				$('#second-surname-father').val($.trim($('#second-surname-father').val().toUpperCase()));
				$('#first-name-father').val($.trim($('#first-name-father').val().toUpperCase()));
				$('#second-name-father').val($.trim($('#second-name-father').val().toUpperCase()));
				$('#email-father').val($.trim($('#email-father').val().toLowerCase()));
				$('#address-father').val($.trim($('#address-father').val().toUpperCase()));
				$('#profession-father').val($.trim($('#profession-father').val().toUpperCase()));
				
				$('#surname-mother').val($.trim($('#surname-mother').val().toUpperCase()));
				$('#second-surname-mother').val($.trim($('#second-surname-mother').val().toUpperCase()));
				$('#first-name-mother').val($.trim($('#first-name-mother').val().toUpperCase()));
				$('#second-name-mother').val($.trim($('#second-name-mother').val().toUpperCase()));
				$('#email-mother').val($.trim($('#email-mother').val().toLowerCase()));
				$('#address-mother').val($.trim($('#address-mother').val().toUpperCase()));
				$('#profession-mother').val($.trim($('#profession-mother').val().toUpperCase()));
				
				$('#client').val($.trim($('#client').val().toUpperCase()));
				$('#fiscal-address').val($.trim($('#fiscal-address').val().toUpperCase()));
			}
        });
		
        $("#item").change(displayVals);
    });    
</script>