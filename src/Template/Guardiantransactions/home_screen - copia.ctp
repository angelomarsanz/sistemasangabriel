<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    	    <h1>Actualización de datos</h1>
    		<h3>Alumnos regulares</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, debe realizar una transferencia bancaria por un monto de Bs. 193.000,00 a la cuenta corriente Banesco 
    		    Nro. 0134-0220-51-2201022512, Rif: J-07573084-4, a nombre de Unidad Educativa Colegio "San Gabriel Arcángel", 
    		    correo electrónico u.esangabriel.admon@gmail.com</p>
    		    <p>El monto de la transferencia de Bs. 193.000,00 es por los siguientes conceptos:</p>
                <p>- Abono a matrícula Bs. 69.500,00</p>
                <p>- Abono a agosto 2018: Bs. 69.500,00.</p>
                <p>- Abono a seguro escolar: Bs. 10.000,00.</p>
                <p>- Diferencia agosto 2017: Bs. 44.000,00.</p>
                <p><b>Nota importante: se debe realizar una transferencia de 193.000 Bs. por cada alumno</b></p>
                <?= $this->Html->link('Actualizar datos alumnos regulares', ['action' => 'add'], ['class' => 'btn btn-success']); ?>
    		<h3>Alumnos nuevos</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, por favor comunicarse con el Departamento de administración al teléfono: 0241-8254752
    		    en horario de 8:00 am - 12:00 m, para que le informen sobre los pagos y procedimientos que deben realizarse previamente.</p> 
    		    <?= $this->Html->link('Actualizar datos alumnos nuevos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
        </div>
    </div>
</div>