<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Rubro Oficios Padres y Representantes</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	                echo $this->Form->input('item', ['label' => 'Rubro', 'options' => 
                            [null => " ",
                            'Administración' => 'Administración',
                            'Alimentación,' => 'Alimentación',
                            'Asesoría y seguridad' => 'Asesoría y seguridad',
                            'Bancos' => 'Bancos',
							'Bisutería' => 'Bisutería',
                            'Carnicería' => 'Carnicería',
                            'Derecho' => 'Derecho',
                            'Cirugía plástica' => 'Cirugía plástica',
                            'Computación' => 'Computación',
                            'Construcción' => 'Construcción',
                            'Contabilidad' => 'Contabilidad',
                            'Diseño gráfico' => 'Diseño gráfico',
							'Diseño y programación web' => 'Diseño y programación web', 
                            'Educación' => 'Educación',
                            'Electricidad' => 'Electricidad',
                            'Enfermería' => 'Enfermería',
                            'Farmacia' => 'Farmacia',
                            'Ferretaría' => 'Ferretería',
                            'Floristería' => 'Floristería',
                            'Fotografía' => 'Fotografía',
                            'Ganadería' => 'Ganadería',
                            'Hotel' => 'Hotel',
                            'Limpieza' => 'Limpieza',
                            'Literatura' => 'Literatura',
                            'Mecánica' => 'Mecánica',
                            'Medicina general' => 'Medicina general',
                            'Militar' => 'Militar',
                            'Obrero' => 'Obrero',
                            'Odontología' => 'Odontología',
                            'Oftalmología' => 'Oftalmología',
                            'Panadería' => 'Panadería',
                            'Peluquería' => 'Peluquería',
                            'Periodismo' => 'Periodismo',
                            'Pescadería' => 'Pescadería',
                            'Pintura artística' => 'Pintura artística',
                            'Plomería' => 'Plomería',
                            'Policía' => 'Policía',
                            'Política' => 'Política',
                            'Productos de limpieza' => 'Productos de limpieza',
                            'Psiquiatría' => 'Psiquiatría',
							'Publicidad y mercadeo' => 'Publicidad y mercadeo',
                            'Restaurant' => 'Restaurant',
                            'Sastrería' => 'Sastrería',
							'Seguros' => 'Seguros',
                            'Taxis' => 'Taxis',
                            'Teatro, tv o cine' => 'Teatro, tv o cine',
                            'Traductor' => 'Traductor',
                            'Ventas' => 'Ventas',
                            'Veterinaria' => 'Veterinaria',
                            'Viajes y turismos' => 'Viajes y turismos']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Buscar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'home'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>