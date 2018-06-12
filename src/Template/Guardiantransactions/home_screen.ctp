<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    	    <h1>Actualización de datos</h1>
    		<h3>Alumnos regulares</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, debe realizar una transferencia bancaria por un monto de 41.366.000,00 Bs.F a la cuenta corriente Banesco 
    		    Nro. 0134-0220-51-2201022512, Rif: J-07573084-4, a nombre de Unidad Educativa Colegio "San Gabriel Arcángel", 
    		    correo electrónico u.esangabriel.admon@gmail.com</p>
    		    <p>El monto de la transferencia de 41.366.000,00 Bs.F es por los siguientes conceptos:</p>
                <p>- Abono a matrícula 12.500.000,00 Bs.F</p>
                <p>- Abono a agosto 2019: 12.500.000,00 Bs.F</p>
                <p>- Abono a seguro escolar: 4.000.000,00 Bs.F</p>
                <p>- Diferencia agosto 2018: 12.366.000,00 Bs.F</p>
                <p>Nota importante: se debe realizar una transferencia de 41.366.000 Bs.F por cada alumno y traer al colegio cada una de las transferencias impresas junto con la(s) ficha(s) de renovación de inscripción</p>
				<p><b>Los representantes que realicen el proceso de inscripción entre el 11/06/2018 y el 15/06/2018 tienen el beneficio del 10% de descuento<b></p>  
                <?= $this->Html->link('Actualizar datos alumnos regulares', ['action' => 'add'], ['class' => 'btn btn-success']); ?>
    		<h3>Alumnos nuevos</h3>
    		    <p style="text-align: justify;">Antes de actualizar los datos, por favor comunicarse con el Departamento de administración al teléfono: 0241-8254752
    		    en horario de 8:00 am - 12:00 m, para que le informen sobre los pagos y procedimientos que deben realizarse previamente.</p> 
    		    <?= $this->Html->link('Actualizar datos alumnos nuevos', ['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto'], ['class' => 'btn btn-success']); ?>
        </div>
    </div>
</div>