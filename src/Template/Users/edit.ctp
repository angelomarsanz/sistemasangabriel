<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php if($user->role == 'Representante'): ?>
        	<div class="page-header">
        		<h2>Editar los datos del Representante</h2>
        	</div>
        <?php elseif($user->role == 'Alumno'): ?>
            <div class="page-header">
                <h2>Editar los datos del Alumno</h2>
            </div>
        <?php else: ?>
            <div class="page-header">
                <h2>Editar Usuario</h2>
            </div>
        <?php endif; ?>
        <?= $this->Form->create($user, ['type' => 'file']) ?>
        <fieldset>
            <?php
                echo $this->Form->input('username', ['label' => 'Usuario']);
                echo $this->Form->input('password', ['label' => 'Clave']);
                echo $this->Form->input('role', ['options' => ['Administrador' => 'Administrador', 'Propietario' => 'Propietario', 'Empleado' => 'Empleado', 'Alumno' => 'Alumno', 'Representante' => 'Padre o representante'], 'label' => 'Rol']);
                echo $this->Form->input('first_name', ['label' => 'Primer nombre']);
                echo $this->Form->input('second_name', ['label' => 'Segundo nombre']);
                echo $this->Form->input('surname', ['label' => 'Primer apellido']);
                echo $this->Form->input('second_surname', ['label' => 'Segundo apellido']);
                echo $this->Form->input('sex', ['options' => ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'], 'label' => 'Sexo']);
                echo $this->Form->input('email', ['label' => 'Correo electrónico']);
                echo $this->Form->input('cell_phone', ['label' => 'Número de teléfono celular']);
                echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil'));
            ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar cambios'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>