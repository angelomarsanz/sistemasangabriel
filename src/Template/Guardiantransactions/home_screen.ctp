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
    		    <p>Estimado representante, para formalizar la inscripción de alumnos regulares, debe cancelar por cada estudiante los siguientes conceptos:</p>
                <p>- Abono a matrícula 2019.</p>
                <p>- Abono a agosto 2020.</p>
                <p>- Seguro escolar.</p>
				<p>- Diferencia de agosto 2019.</p>
                <p>- Convenio Thales.</p>
<b>Es obligatorio la actualización de datos tanto del representante como de los estudiantes, así también la impresión y consignación de la ficha de inscripción en Administración, que se estará recibiendo a partir del lunes 10 de junio 2019.</b></p>  
                <?= $this->Html->link('Actualizar datos alumnos regulares', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
    		<h3>Alumnos nuevos</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, comunicarse al Departamento de Administración en horario de 8:00&nbsp;am - 12:00&nbsp;m, para asignarle la clave e indicarle el procedimiento a realizar.</p> 
    		    <?= $this->Html->link('Actualizar datos alumnos nuevos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
		</div>
    </div>
</div>
