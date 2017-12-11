<style>
@media screen
{
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
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Crear Nómina</h3>
	    </div>
	    <?= $this->Form->create() ?>
	        <fieldset>
		    	<?php
	               	echo $this->Form->input('year_paysheet', ['label' => 'Año: ', 'options' => 
	                    [null => '',
	                    '2017' => '2017',
	                    '2018' => '2018',
	                    '2019' => '2019']]);
	                echo $this->Form->input('month_paysheet', ['label' => 'Mes: ', 'options' => 
	                    [null => '',
	                    '01' => 'Enero',
	                    '02' => 'Febrero',
	                    '03' => 'Marzo',
	                    '04' => 'Abril',
	                    '05' => 'Mayo',
	                    '06' => 'Junio',
	                    '07' => 'Julio',
	                    '08' => 'Agosto',
	                    '09' => 'Septiembre',
	                    '10' => 'Octubre',
	                    '11' => 'Noviembre',
	                    '12' => 'Diciembre']]);
	               	echo $this->Form->input('fortnight', ['label' => 'Quincena: ', 'options' => 
	                    [null => '',
	                    '1ra. Quincena' => '1ra. Quincena',
	                    '2da. Quincena' => '2da. Quincena']]);
		    	?>
		    </fieldset>
        	<?= $this->Form->button(__('Crear nómina'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        <br />
        <?= $this->Html->link('Volver al inicio', ['controller' => 'users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
</div>
<div class="menumenos nover menu-menos">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
    <p>
        <a href="../paysheets/edit" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
    $('#mas').on('click',function()
    {
        $('.menu-menos').hide();
        $('.menu-mas').show();
    });
    
    $('#menos').on('click',function()
    {
        $('.menu-mas').hide();
        $('.menu-menos').show();
    });
</script>