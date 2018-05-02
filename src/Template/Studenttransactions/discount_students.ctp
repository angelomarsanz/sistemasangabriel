<?php
    use Cake\I18n\Time;
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
	<div class="page-header">
		<h2>Alumnos con descuento en las mensualidades</h2>
	</div>
    <div class="col-md-2">
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
                echo $this->Form->input('month_from', ['label' => 'Mes referencia: ', 'options' => 
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
               	echo $this->Form->input('year_from', ['label' => 'Año referencia: ', 'options' => 
                    [null => '',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019']]);
				echo $this->Form->input('monthly_payment', ['required' => 'required',
                    'label' => 'Cuota referencia']);				
            ?>
        </fieldset>
		<br />
        <?= $this->Form->button(__('Aceptar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>