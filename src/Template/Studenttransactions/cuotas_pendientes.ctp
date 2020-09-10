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
	        <h3>Pagos pendientes</h3>
        </div>
		<div>
			<h4>Alumno: VIVAS ANDRÉS </h4>
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
								<tr>
									<td>1</td>
									<td>Sep 2020</td>
									<td>45,00</td>
									<td>51,75</td>
									<td>16200000,00</td>
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