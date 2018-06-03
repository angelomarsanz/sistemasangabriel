<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    	    <h1>Actualización de datos</h1>
    		<h3>Alumnos nuevos</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, por favor comunicarse con el Departamento de administración al teléfono: 0241-8254752
    		    en horario de 8:00 am - 12:00 m, para que le informen sobre los pagos y procedimientos que deben realizarse previamente.</p> 
    		    <?= $this->Html->link('Actualizar datos alumnos nuevos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
        </div>
    </div>
</div>