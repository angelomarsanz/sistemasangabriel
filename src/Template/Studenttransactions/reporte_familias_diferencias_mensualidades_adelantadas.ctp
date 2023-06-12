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
<br />
<div class="row">
	<div class="col-md-12">
		<div>
			<div style="float: left; width:10%;">
				<p><img src="<?php echo Router::url(["controller" => "webroot/files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/logo1.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
			</div>
			<div style="float: left; width: 90%;">
				<h5><b><?= $school->name ?></b></h5>
				<p>RIF: <?= $school->rif ?></p>
				<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
				<h3 style="text-align: center;"><?= 'Reporte de Familias con diferencias de Mensualidades Adelantadas al '.$mes_anio_hasta ?></h3>
			</div>
		</div>
		<div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style="text-align:center;">Nro.</th>
						<th style="text-align:left;">Familia</th>
						<th style="text-align:center;">Teléfono</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$contador_transacciones = 1;
					foreach ($detalle_morosos as $moroso): ?>
						<tr>
							<td style="text-align:center;"><?= $contador_transacciones ?></td>
							<td style="text-align:left;"><?= $moroso["Familia"] ?></td>
							<td style="text-align:center;"><?= $moroso["Teléfono"] ?></td>
						</tr>  
						<?php $contador_transacciones++; ?>
					<?php 
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<br />			
	</div>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
         <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
function myFunction() 
{
    window.print();
}
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
});
</script>