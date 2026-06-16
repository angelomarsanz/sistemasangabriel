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
			<p><b>Estimado representante, para realizar la inscripción del año escolar 2026-2027, debe:</b></p>
			<p>1) Tener el año escolar que finaliza solvente hasta el mes de Julio 2026.</p>
			<p>2) Tener al día la cuota del Consejo educativo 2025-2026, es un pago único por familia de 70$ en efectivo o transferencia bancaria al BANCO PROVINCIAL 0108 0557 17 0100025794 CORRIENTE J-40490885-4 C.E.U.E. COLEGIO SAN GABRIEL ARCANGEL al BCV del día imprimir el soporte y traerlo con los recaudos.</p>
			<p>3) Pago del seguro escolar para el año escolar 2026-2027 = 30$ por alumno pago en efectivo en $ o pago móvil Banco de Venezuela Teléfono: 0424-4080340 C.I: 30.823.866 al BCV del día imprimir el soporte y traerlo con los recaudos.</p>
			<p>4) <b>Es obligatorio la actualización de datos, la firma digital del contrato de prestación de servicios y la descarga de la planilla.</b></p>
			<p>5) Para realizar la inscripción de los alumnos regulares en el período escolar 2026-2027 el pago a realizar es:</p>
			<?php
			if ($indicadorDeudaInscripcion == 1)
			{ ?>
				<p>- Diferencia de Matrícula 2025 - 2026 = 43 $</p> 
				<p>- Diferencia de Agosto 2025 - 2026 = 43 $</p> 
			<?php
			} ?>
			<p>- Anticipo de Matrícula 2026 - 2027 = 263$</p>
			<p>- Abono a agosto 2026 - 2027 = 263$</p>
			<?php
			if ($indicadorDeudaInscripcion == 1)
			{ ?>
				<p><b>- Total a pagar por concepto de abono de inscripción 612$ métodos de pago: efectivo en $, punto de venta o transferencia bancaria  </b></p>
			<?php
			}
			else
			{ ?>
				<p><b>- Total a pagar por concepto de abono de inscripción 526$ métodos de pago: efectivo en $, punto de venta o transferencia bancaria.</b></p>
			<?php
			} 
			?>
			<p><b>Nota: Le recordamos que, una vez establecida la mensualidad para el nuevo período escolar deberá cancelar la diferencia correspondiente tanto a la matrícula como al mes de agosto antes de diciembre 2026.</b></p>
			<?= $this->Html->link('Continuar', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>