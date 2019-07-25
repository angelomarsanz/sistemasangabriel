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
<br />
<br />
<div>
	<?php $contador = 0 ?>
	<?php foreach ($pagosRecibidos as $pagosRecibido): ?>
		<?php if ($contador == 0): ?>
			<?php $contador++; ?>
			<table id="reporte-pagos" name="reporte_pagos" class="table noverScreen">
				<thead>
					<tr>
						<th></th>
						<th><b><?= 'Fecha: ' . $fechaHoy->format('d-m-Y') ?></b></th>
					</tr>
					<tr>
						<th></th>
						<th><b>Colegio San Gabriel Arcángel</b></th>
					</tr>
					<tr>
						<th></th>
						<th><b><?= "Pagos recibidos por concepto de: " . $conceptoReporte ?></b></th>
					</tr>
					<tr>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<th><b><?= "Total recibido : " . number_format($totalConcepto, 2, ",", ".") ?></b></th>
					</tr>
					<tr>
						<th></th>
						<th></th>
					</tr>
					
					<tr>
						<th></th>
						<th><b>Detalle pagos de familias - alumnos</b></th>
					</tr>	
					
					<tr>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th scope="col"><b>Nro.</b></th>				
						<th scope="col"><b>Familia</b></th>
						<th scope="col"><b>Alumno</b></th>				
						<th scope="col"><b><?= $conceptoReporte ?></b></th>
						<th scope="col" class="noExl"><b>id</b></th>
					</tr>
				</thead>
				<tbody>
		<?php else: ?>
			<tr>
				<td><?= $contador ?></td>								
				<td><?= $pagosRecibido->student->parentsandguardian->family ?></td>                        
				<td><?= $pagosRecibido->student->full_name ?></td>
				<td><?= number_format($pagosRecibido->amount, 2, ",", ".") ?></td>
				<td class="noExl"><?= $pagosRecibido->id ?></td>				
			</tr>
			<?php $contador++; ?>
		<?php endif; ?>
	<?php endforeach ?>
	</tbody>
	</table>
	<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
</div>
<div id="menu-menos" class="menumenos nover">
	<p>
	<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
	</p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
	<p>
		<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
		<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
		
		<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
	</p>
</div>
<script>
$(document).ready(function(){ 
    $('#mas').on('click',function()
    {
        $('#menu-menos').hide();
        $('#menu-mas').show();
    });
    
    $('#menos').on('click',function()
    {
        $('#menu-mas').hide();
        $('#menu-menos').show();
    });
    
    $("#excel").click(function(){
        
        $("#reporte-pagos").table2excel({
    
            exclude: ".noExl",
        
            name: "reporte_pagos",
        
            filename: $('#reporte-pagos').attr('name') 
    
        });
    });
});
</script>