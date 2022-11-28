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
	        <h3>Comprobante de información de pago recibida</h3>
			<?= $this->Form->create() ?>
				<fieldset>
				</fieldset>
			<br />
			<br />
			<?= $this->Form->button(__('Descargar'), ['class' =>'btn btn-success', 'id' => 'descargar']) ?>
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