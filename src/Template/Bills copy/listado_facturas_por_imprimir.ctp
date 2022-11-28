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
	        <h3>Facturas pendientes por imprimir</h3>
		</div>
		<div>
			<h4>Familia: RUIZ AGUILAR</h4>
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
									<th scope="col">Fecha</th>
									<th scope="col">Referencia</th>
									<th scope="col">Monto ($)</th>
									<th scope="col">Monto (€)</th>
									<th scope="col">Monto (Bs.)</th>
									<th scope="col">Imprimir</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>14/09/2020</td>
									<td>34324241</td>
									<td>180,00</td>
									<td>156,20</td>
									<td>64.800.000,00</td>
									<td><?= $this->Form->button(__('Imprimir'), ['class' =>'btn btn-success', 'id' => 'imprimir']) ?></td>
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