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
                    echo $this->Form->input('role', ['options' => ['Representante' => 'Padre o representante'], 'label' => 'Rol: *']);
                    echo $this->Form->input('surname', ['label' => 'Primer apellido: *']);
                    echo $this->Form->input('second_surname', ['label' => 'Segundo apellido:']);
                    echo $this->Form->input('first_name', ['label' => 'Primer nombre: *']);
                    echo $this->Form->input('second_name', ['label' => 'Segundo nombre:']);
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
<script>
    $(document).ready(function() 
    {
        $('#save-user').click(function(e) 
        {
            $('#first-name').val($('#first-name').val().toUpperCase());
            $('#second-name').val($('#second-name').val().toUpperCase());
            $('#surname').val($('#surname').val().toUpperCase());
            $('#second-surname').val($('#second-surname').val().toUpperCase());
            $('#email').val($('#email').val().toLowerCase());
            alert("En este momento vamos a registrar tus datos. Por favor ingresa nuevamente al sistema con tu número de cédula, la contraseña sga40 y pulsas el botón ACCEDER");
        });
    });
</script>