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
	        <h3>Detalle del pago realizado</h3>
		</div>
		<div>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="col-md-3">
						<div class="form-group">
							<label for="fecha">Fecha:</label>
							<input type="text" name="fecha" value="14/09/2020" style="text-align: center">
						</div>
					<div class="form-group">
							<label for="referencia">Referencia:</label>
							<input type="text" name="referencia">
						</div>						
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="formaDePago">Forma de pago:</label>
							<input type="text" name="formaDePago">
						</div>
						<div class="form-group">
							<label for="moneda">Moneda:</label>
							<input type="text" name="moneda" style="text-align: center">
						</div>									
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="banco">Banco:</label>
							<input type="text" name="banco">
						</div>

						<div class="form-group">
							<label for="monto">Monto:</label>
							<input type="text" name="monto" style="text-align: center">
						</div>
						<div>
							<?= $this->Form->button(__('Ver capture'), ['class' =>'btn btn-success', 'id' => 'verCapture']) ?>
						</div>
					</div>
				</fieldset>
				<br />
			<?= $this->Form->end() ?>
		</div>
		<div>
			<h4>Alumno: RUIZ AGUILAR ÁNGEL SAMUEL </h4>
			<?php  
			$cuotas = 
				['Sep 2020',
				'Oct 2020',
				'Nov 2020',
				'Dic 2020'];
			?>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">Nro.</th>
									<th scope="col">cuota</th>
									<th scope="col">$</th>
									<th scope="col">€</th>
									<th scope="col">Bs.</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cuotas as $cuota): ?>
									<tr>
										<td>1</td>
										<td><?= $cuota ?></td>
										<td>45,00</td>
										<td>51,75</td>
										<td>16200000,00</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</fieldset>   
				<p>Total: 180 $</p>
			<?= $this->Form->end() ?>
		</div>
		<div>
			<div class="form-group">
				<label for="aceptar">Aceptar:</label>
				<input type="checkbox" id="aceptar">
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<label for="rechazar">Rechazar:</label>
				<input type="checkbox" id="rechazar">
			</div>
			<div>
				<?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'guardar']) ?>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function()
	{
    });
</script>