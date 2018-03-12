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
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Ajustar mensualidades a alumnos morosos</h2>
    	</div>
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
                echo $this->Form->input('month_from', ['label' => 'A partir del mes: ', 'options' => 
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
               	echo $this->Form->input('year_from', ['label' => 'Del año: ', 'options' => 
                    [null => '',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019']]);
                echo $this->Form->input('month_until', ['label' => 'Hasta el mes: ', 'options' => 
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
               	echo $this->Form->input('year_until', ['label' => 'Del año: ', 'options' => 
                    [null => '',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019']]);
				echo $this->Form->input('previous_amount', ['required' => 'required',
                    'label' => 'Cuota anterior']);
                echo $this->Form->input('new_amount', ['required' => 'required',
                    'label' => 'Nueva cuota']);				
            ?>
        </fieldset>
		<br />
        <?= $this->Form->button(__('Aceptar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>