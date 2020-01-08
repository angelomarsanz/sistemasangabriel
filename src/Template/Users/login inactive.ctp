<?= $this->Html->css('login') ?>

<div class="container">
	<div class="jumbotron">
    	<h1>Bienvenidos al Sistema San Gabriel Arcángel...</h1>
    	<p>Por favor escriba en el campo usuario, el número de cédula de la madre del(los) estudiante(s), en contraseña sga40 y pulse el botón Acceder</p>
	</div>
	<h2 id="message" style="color: red; font-style: italic;"></h2>
	<div class="row" style="margin-top:20px">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
	        <?= $this->Flash->render('auth') ?>
			<?= $this->Form->create() ?>
				<fieldset>
					<hr class="colorgraph">
					<div class="form-group">
	                    <?= $this->Form->input('username', ['class' => 'form-control input-lg', 'placeholder' => 'Usuario', 'label' => false, 'required']) ?>
					</div>
					<div class="form-group">
	                    <?= $this->Form->input('password', ['class' => 'form-control input-lg', 'placeholder' => 'Contraseña', 'label' => false, 'required']) ?>
					</div>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
	                        <?= $this->Form->button('Acceder', ['id' => 'to-access', 'class' => 'btn btn-lg btn-success btn-block']) ?>
						</div>
<!--
						<div class="col-xs-6 col-sm-6 col-md-6">
							<?= $this->Html->link('Registrarse', ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-lg btn-primary btn-block']) ?>
						</div>
-->
					</div>
				</fieldset>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#to-access').click(function(e) 
        {
        	usernameUser = $("#username").val();

        	if (usernameUser.toLowerCase() == "angel2703" || usernameUser.toLowerCase() == "titularsistema" || usernameUser.toLowerCase() == "adminsg" || usernameUser.toLowerCase() == "emiguerrero")
//         	if (usernameUser.toLowerCase() == "angel2703")
        	{
        		$('#message').css('color', '#00ace6');
	            $('#message').text("Acceso concedido");
        	}
        	else
        	{
	        	e.preventDefault();
	            $('#message').text("Estimado usuario, le rogamos nos disculpe, en estos momentos estamos haciendo unos ajustes al sistema, por favor intente más tarde...");
        	}
        });
    });
</script>