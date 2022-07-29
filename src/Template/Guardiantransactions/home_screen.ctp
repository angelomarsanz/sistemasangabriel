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
			<p><b>Estimado representante, para realizar la inscripción del año escolar 2022-2023, debe:</b></p>
			<p>1) Tener el año escolar que finaliza al día hasta el mes de Julio 2022.</p>
			<p>2) Tener al día la cuota del Consejo educativo 2021-2022, es un pago único por familia de 20$ en efectivo (no se debe realizar por transferencia sin excepción).</p>
			<br />
			<p>El presente año para realizar la inscripción de los alumnos regulares para el año escolar 2022-2023 el pago a realizar es:</p>
			<p>- Diferencia de Matrícula 2021 - 2022 = 25 $</p>
			<p>- Diferencia de Agosto 2021 - 2022 = 25 $</p>
			<p>- Anticipo de Matrícula 2022 – 2023 = 90 $</p>
			<p>- Abono a Agosto 2022 - 2023 = 90 $</p>
			<p>- Seguro escolar 2022 - 2023 = 20 $ <b>(Pago único en dólares en efectivo o Zelle)</b></p>
			<p><b>- Total a cancelar 250 $</b></p>
			<p>Si usted cancela del 15-06-22 al 30-06-22 gozará del beneficio de pronto pago de 10$ menos en la Inscripción cancelando un total de 240$ por alumno.</p>
			<p>Formas de pago: (Transferencias en Bs Banco Banesco según Tasa BCV, Zelle, Facebank) o pagar en efectivo $ o punto de venta en la administración del Colegio en Bs, según la tasa del cambio del Banco Central de Venezuela al momento de inscribir.</p>
			<p><b>Es obligatorio la actualización de datos tanto del representante como de los estudiantes y la descarga de la planilla.</b></p>  
			<?= $this->Html->link('Actualizar datos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>
