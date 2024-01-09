<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header" style="text-align: justify;">
			<div class="alert alert-info">
			  <strong>Libros "Pasito a Pasito" y "Computación" (primaria). Información de precios en el Departamento de Administración.</strong>
			</div>
    	    <h1>Actualización de datos</h1>
    		<h3>Alumnos regulares</h3>
			<p><b>Estimado representante, para realizar la inscripción del año escolar 2023-2024, debe:</b></p>
			<p>1) Tener el año escolar que finaliza al día hasta el mes de Julio 2023.</p>
			<p>2) Tener al día la cuota del Consejo educativo 2022-2023, es un pago único por familia de 50$ en efectivo (no se debe realizar por transferencia sin excepción).</p>
			<br />
			<p>El presente año para realizar la inscripción de los alumnos regulares en el período escolar 2023-2024 el pago a realizar es:</p>
			<p>- Diferencia de Matrícula 2022 - 2023 = 30 $</p>
			<p>- Diferencia de Agosto 2022 - 2023 = 30 $</p>
			<p>- Anticipo de Matrícula 2023 – 2024 = 120 $</p>
			<p>- Abono a Agosto 2023 - 2024 = 120 $</p>
			<p>- Seguro escolar 2023 - 2024 = 20 $ <b>(Pago único en dólares en efectivo)</b></p>
			<p><b>- Total a cancelar 320 $</b></p>
			<p><b>Es obligatorio la actualización de datos, la firma digital del contrato de prestación de servicios y la descarga de la planilla.</b></p>  
			<?= $this->Html->link('Continuar', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>