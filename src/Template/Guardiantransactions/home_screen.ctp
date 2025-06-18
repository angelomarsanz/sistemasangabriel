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
			<p><b>Estimado representante, para realizar la inscripción del año escolar 2025-2026, debe:</b></p>
			<p>1) Tener el año escolar que finaliza solvente hasta el mes de Julio 2025.</p>
			<p>2) Tener al día la cuota del Consejo Educativo 2024-2025, <b>es un pago único por familia de 50$ en efectivo (no se debe realizar por transferencia sin excepción).</b></p>
			<p>3) <b>Diferencia de matrícula y diferencia agosto:</b> si existe un aumento de mensualidad dentro del año escolar se aplica la diferencia en la inscripción.</p>
			<p>4) <b>Es obligatorio la actualización de datos, la firma digital del contrato de prestación de servicios y la descarga de la planilla.</b></p>
			<p>5) Para realizar la inscripción de los alumnos regulares en el período escolar 2025-2026 el pago a realizar es:</p>
			<?php
			if ($indicadorDeudaInscripcion == 1)
			{ ?>
				<p>- Diferencia de Matrícula 2024 - 2025 = 30 $</p> 
				<p>- Diferencia de Agosto 2024 - 2025 = 20 $</p> 
			<?php
			} ?>
			<p>- Anticipo de Matrícula 2025 - 2026 = 220 $</p>
			<p>- Abono a Agosto 2025 - 2026 = 220 $</p>
			<p>- Seguro escolar 2025 - 2026 = 25$ <b>(Pago único en dólares en efectivo)</b></p>
			<?php
			if ($indicadorDeudaInscripcion == 1)
			{ ?>
				<p><b>- Total a cancelar 515 $</b></p>
			<?php
			}
			else
			{ ?>
				<p><b>- Total a cancelar $ 465</b></p>
			<?php
			} 
			?>
			<?= $this->Html->link('Continuar', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>