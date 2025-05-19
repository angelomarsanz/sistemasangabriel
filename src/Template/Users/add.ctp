<div id='addUsers'></div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Registrarse</h2>
        	</div>
            <?= $this->Form->create($user, ['type' => 'file']) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('username', ['label' => 'Usuario: *']);
                    echo $this->Form->input('password', ['label' => 'Clave: *']);
                    // Inicio cambios Seniat
                    echo $this->Form->input('role', ['label' => 'Rol: *', 'options' => 
                        [
                            'Administrador' => 'Administrador',
                            'Alumno' => 'Alumno',
                            'Contabilidad fiscal' => 'Contabilidad fiscal',                
                            'Contabilidad general' => 'Contabilidad general',
                            'Control de estudios' => 'Control de estudios',
                            'Propietario' => 'Propietario',
                            'Representante' => 'Padre o representante',
                            'Seniat' => 'Seniat',
                            'Ventas fiscales' => 'Ventas fiscales',
                            'Ventas generales' => 'Ventas generales'
                            ]]);
                    // Fin cambios Seniat
                    echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                    echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
                    echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                    echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
                    echo $this->Form->input('sex', ['options' => [null => ' ', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino'], 'label' => 'Sexo: *']);
                    echo $this->Form->input('email', ['label' => 'Correo electrónico: *']);
                    echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular:']);
                    echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil:'));
                ?>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-user', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>