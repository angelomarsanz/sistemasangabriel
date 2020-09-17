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
    <div class="col-md-12">
    	<div class="page-header">
	        <h3>Pagos pendientes por conciliar</h3>
        </div>
		<div>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">Nro.</th>
									<th scope="col">Familia</th>
									<th scope="col">Forma de pago</th>
									<th scope="col">Banco</th>
									<th scope="col">Referencia</th>
									<th scope="col">Moneda</th>
									<th scope="col">Monto</th>
									<th scope="col">Detalles</th>
								</tr>
							</thead>
							<tbody>
									<tr>
										<td>1</td>
										<td>RUÍZ AGUILAR</td>
										<td>Zelle</td>
										<td>Zelle</td>
										<td>442423</td>
										<td>$</td>
										<td>180,00</td>
										<td><?= $this->Form->button(__('Detalles'), ['class' =>'btn btn-success', 'id' => 'detalles']) ?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>SÁNCHEZ OLIVO</td>
										<td>Transferencia bancaria nacional</td>
										<td>Banesco</td>
										<td>1313131</td>
										<td>Bs.</td>
										<td>25.000.000,00</td>
										<td><?= $this->Form->button(__('Detalles'), ['class' =>'btn btn-success', 'id' => 'detalles']) ?></td>
									</tr>
									<tr>
										<td>3</td>
										<td>TORRES FIGUEROA</td>
										<td>Euros</td>
										<td>Euros</td>
										<td>442423</td>
										<td>€</td>
										<td>105,00</td>
										<td><?= $this->Form->button(__('Detalles'), ['class' =>'btn btn-success', 'id' => 'detalles']) ?></td>
									</tr>
							</tbody>
						</table>
					</div>
				</fieldset>   
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function()
	{
    });
</script>