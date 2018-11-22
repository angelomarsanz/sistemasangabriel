<?php
    use Cake\I18n\Time;
?>

<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
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
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Agregar tarifa</h2>
    	</div>
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
                echo $this->Form->input('concept', ['required' => 'required', 'label' => 'Tarifa', 'options' => 
                    [null => '',
					'Agosto' => 'Agosto',
					'Diferencia de matrícula' => 'Diferencia de matrícula',
                    'Matrícula' => 'Matrícula',
                    'Mensualidad' => 'Mensualidad',
                    'Seguro escolar' => 'Seguro escolar',
                    'Servicio educativo' => 'Servicio educativo']]); 
                echo $this->Form->input('rate_month', ['label' => 'A partir del mes: ', 'options' => 
                    [null => '',
                    '01' => 'Enero',
                    '02' => 'Febrero',
                    '03' => 'Marzo',
                    '04' => 'Abril',
                    '05' => 'Mayo',
                    '06' => 'Junio',
                    '07' => 'Julio',
                    '08' => 'Agosto',
                    '09' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre']]);
               	echo $this->Form->input('rate_year', ['label' => 'Del año: ', 'options' => 
                    [null => '',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019',
					'2020' => '2020',
					'2021' => '2021']]);
                echo $this->Form->input('amount', ['label' => 'Monto']);
					
				echo $this->Form->input('defaulters', ['type' => 'checkbox', 'id' => 'defaulters',
                    'label' => 'Ajustar la mensualidad a alumnos morosos', 'disabled' => 'disabled']);
										
                echo $this->Form->input('exception', ['type' => 'checkbox', 'id' => 'exception',
                    'label' => 'Exceptuar alumnos que han pagado el año escolar completo', 'disabled' => 'disabled']);
					
				setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                date_default_timezone_set('America/Caracas');

				print ("<div id='date-top' class='noverScreen'>");
				print ('<br />');
				
                echo $this->Form->input('date_exception', ['id' => 'date-exception', 'type' => 'date', 
                    'label' => 'Por favor indique la fecha tope del pago del año escolar completo']);
					
				print ('<div>');
				
            ?>
        </fieldset>
		<br />
        <?= $this->Form->button(__('Guardar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    function enableInputs() 
    {
		alert('Estimado usuario antes de agregar una nueva tarifa por favor comunicarse con el personal de sistema para que haga un respaldo de la base de datos');

        if ($("#concept").val().substring(0, 11) == "Mensualidad")
        {
            $("#rate-month").attr('disabled', false);
			$("#rate-month").attr('required', true);
            
			$("#rate-year").attr('disabled', false);
			$("#rate-year").attr('required', true);
			
			$("#amount").attr('disabled', false);
			$("#amount").attr('required', true);
			
			$("#exception").attr('disabled', false);
			$("#defaulters").attr('disabled', false);
        }
        else
        {
            $("#rate-month").attr('disabled', true);
			
			$("#rate-year").attr('disabled', false);
			$("#rate-year").attr('required', true);
			
			$("#amount").attr('disabled', false);
			$("#amount").attr('required', true);
			
			$("#exception").attr('disabled', true);
			$("#defaulters").attr('disabled', true);
		}
    }
	
	function verifyConcept()
	{	
		if ($("#concept").val() == "Diferencia de agosto")
		{
			$.post('/sistemasangabriel/rates/consultFee', {"yearAugust" : $("#rate-year").val() }, null, "json")
            
			.done(function(response) 
			{
				if (response.success) 
				{
					alert('El monto que abonaron los representantes al mes de agosto ' + $("#rate-year").val() + ' fue de: ' + response.data + ', por favor introduzca el monto de la diferencia de agosto'); 
				} 
				else 
				{
					alert('No se encontró el monto abonado al mes de agosto ' + $("#rate-year").val());
				}
            })
			.fail(function(jqXHR, textStatus, errorThrown) 
			{    
				alert('Algo falló al intentar acceder el registro en la base de datos');
            });
		} 
	}
	   
    $(document).ready(function() 
    {
        $('#concept').change(enableInputs);
		
		$('#rate-year').change(verifyConcept);
		
		$('#exception').on('click',function(){
			$('#date-top').toggle('slow');
		});
		
		$("#guardar").click(function(e)
		{
			if ($("#concept").val() == "Mensualidad")
			{
				if ($('#rate-month').length) 
				{
					dateFrom = $('#rate-month').val() + '/' +  $('#rate-year').val();
				}
				else
				{
					dateFrom = $('#rate-year').val();		
				}
				
				if( $('#exception').prop('checked')) 
				{
					topDate = ' exceptuando a aquellos alumnos que pagaron el año escolar completo antes del ' + $("select[name='date_exception[day]']").val() + '/' + $("select[name='date_exception[month]']").val() + '/' + $("select[name='date_exception[year]']").val();
				}
				else
				{
					topDate = '';
				}
				
				var rateUpdate = confirm('Por favor confirme que desea ajustar la ' + $('#concept').val() + ' a ' + $('#amount').val() + ' a partir del ' + dateFrom + topDate);

				if (rateUpdate == true)
				{
					alert('Estimado usuario la ejecución de este programa durará unos minutos, por favor pulse el botón aceptar y espere a que se le envíe un correo electrónico informándole sobre los resultados del proceso');
				}
				else
				{
					e.preventDefault();
					$.redirect('/sistemasangabriel/rates/index');
				}
			}
			else if ($("#concept").val() == "Diferencia de agosto")
			{
				var rateAugust = confirm('Por favor confirme que desea ajustar el monto de la diferencia de agosto ' + $('#rate-year').val() + ' a ' + $('#amount').val());

				if (rateAugust == true)
				{
					alert('Estimado usuario la ejecución de este programa durará unos minutos, por favor pulse el botón aceptar y espere a que se le envíe un correo electrónico informándole sobre los resultados del proceso');
				}
				else
				{
					e.preventDefault();
					$.redirect('/sistemasangabriel/rates/index');
				}
			}
			else
			{
				var rateOther = confirm('Por favor confirme que desea ajustar la tarifa de ' + $('#concept').val() + ' ' + $('#rate-year').val() + ' a ' + $('#amount').val());

				if (rateOther == false)
				{
					e.preventDefault();
					$.redirect('/sistemasangabriel/rates/index');
				}			
			}
		}); 
    });
</script>