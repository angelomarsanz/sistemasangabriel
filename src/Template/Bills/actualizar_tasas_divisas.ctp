<?= $this->Html->css('login') ?>

<div class="container">
	<div class="jumbotron">
    	<h2 style="text-align: center">Sistema San Gabriel Arcángel</h2>
    	<p>Por favor escriba en el campo usuario, el número de cédula y las tasas de cambio del dólar y euro</p>
	</div>
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
					<div class="form-group">
	                    <?= $this->Form->input('dolar', ['class' => 'form-control input-lg', 'placeholder' => 'Tasa de cambio dólar', 'label' => false, 'required']) ?>
					</div>
					<div class="form-group">
	                    <?= $this->Form->input('euro', ['class' => 'form-control input-lg', 'placeholder' => 'Tasa de cambio euro', 'label' => false, 'required']) ?>
					</div>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
	                        <?= $this->Form->button('Guardar', ['id' => 'to-access', 'class' => 'btn btn-lg btn-success btn-block']) ?>
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
        	passwordUser = $("#password").val();
        	if (passwordUser.toLowerCase() == "sga40")
        	{
	            $('#password').val($('#password').val().toLowerCase());
        	}
        });
    });
</script>