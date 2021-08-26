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
			<p>Estimado representante, para formalizar la inscripción de los alumnos regulares, debe cancelar por cada estudiante los siguientes conceptos:</p>
			<p>- Diferencia de Matrícula 2020 - 2021 = 20 $</p>
			<p>- Diferencia de Agosto 2020 - 2021 = 20 $</p>
			<p>- Anticipo de Matrícula 2021 – 2022 = 65 $</p>
			<p>- Abono a Agosto 2021 - 2022 = 65 $</p>
			<p><b>Es obligatorio la actualización de datos tanto del representante como de los estudiantes y la descarga de la planilla.</b></p>  
			<?= $this->Html->link('Actualizar datos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>
