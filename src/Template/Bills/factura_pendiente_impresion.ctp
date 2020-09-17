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
	        <h3>Facturas pendientes de impresión</h3>
		</div>
		<div>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="col-md-12">
						<div class="form-group">
							<label for="BuscarPorFamilia">Buscar por familia:</label>
							<input type="text" name="buscarPorFamilia">
						</div>
						<br />
						<div class="form-group">
								<label for="BuscarPorRepresentante">Buscar por Representante:</label>
								<input type="text" name="buscarPorRepresentante">
						</div>
						<br />
						<div>
							<p><b>Buscar por fecha: </b></p>
							<label for="fechaDesde">Desde: </label>
							<input type="text" name="fechaDesde">
							<label for="fechaHasta">Hasta: </label>
							<input type="text" name="fechaHasta">
							<?= $this->Form->button(__('Buscar'), ['class' =>'btn btn-success', 'id' => 'buscar']) ?>
						<div>
					</div>
				</fieldset>
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