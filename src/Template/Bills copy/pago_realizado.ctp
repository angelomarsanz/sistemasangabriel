<?php
    use Cake\Routing\Router;
?>
<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="row">
    <div class="col-md-8">
    	<div class="page-header">
	        <h3>Datos del pago realizado</h3>
			<br />
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="col-md-8">
						<div class="form-group">
							<label for="fecha">Fecha:</label>
							<input type="text" name="fecha" value="14/09/2020" style="text-align: center">
						</div>
						<div class="form-group">
							<label for="formaDePago">Forma de pago:</label>
							<select class="form-control" id="formaDePago">
								<option>Euros</option>
								<option>Transferencia bancos nacionales</option>
								<option>Zelle</option>
							</select>
						</div>
						<div class="form-group">
							<label for="bancos">Banco:</label>
							<select class="form-control" id="bancos">
								<option>Banesco</option>
								<option>Euros</option>
								<option>Zelle</option>
							</select>
						</div>
						<div class="form-group">
							<label for="moneda">Moneda:</label>
							<select class="form-control" id="moneda">
								<option>Bs.</option>
								<option>Dólar</option>
								<option>Euro</option>
							</select>
						</div>
						<div class="form-group">
							<label for="referencia">Referencia:</label>
							<input type="text" name="referencia" value="14343423" style="text-align: center">
						</div>
						<div class="form-group">
							<label for="monto">Monto:</label>
							<input type="text" name="monto" value="0,00" style="text-align: center">
						</div>
						<form class="md-form">
						  <div class="file-field">
							<div class="btn btn-primary btn-sm float-left">
							  <span>Subir capture</span>
							  <input type="file">
							</div>
							<div class="file-path-wrapper">
							  <input class="file-path validate" type="text" placeholder="Subir capture">
							</div>
						  </div>
						</form>
					</div>
				</fieldset>
			<br />
			<br />
			<?= $this->Form->button(__('Enviar'), ['class' =>'btn btn-success', 'id' => 'pagar']) ?>
			<br />
			<br />
		<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function()
	{
    });
</script>