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
		<?php if ($tipoReporte == "Por grado"): ?>
			<div>
				<div style="float: left; width:10%;">
					<p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 1</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;"></th>
							<th colspan="5" style="text-align:center;">Alumnos</th>
						</tr>
						<tr>
							<th style="text-align:center;">Grado</th>
							<th style="text-align:center;">Morosos</th>
							<th style="text-align:center;">Solventes</th>
							<th style="text-align:center;">Becados</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td style='text-align:left;'><b>Totales</b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['defaulters']) ?></b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['solvents']) ?></b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['scholarship']) ?></b></td>
						</tr>
					</tfoot>
					<tbody>
						<?php foreach ($defaulters as $defaulter): ?>
							<tr>
								<td style='text-align:left;'><?= h($defaulter['section']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['defaulters']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['solvents']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['scholarship']) ?></td>
							</tr>  
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="saltopagina">
				<div style="float: left; width:10%;">
					<p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 2</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div style="clear: both;">
				<br />
				<br />
				<p><b><?= 'Total morosidad a la fecha Bs.S ' . number_format($totalDebt, 2, ",", ".") ?><b></p>
				<p><b><?= 'Total alumnos morosos: ' . $tDefaulters[0]['defaulters'] . " (" . number_format((($tDefaulters[0]['defaulters']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos solventes: ' . $tDefaulters[0]['solvents'] . " (" . number_format((($tDefaulters[0]['solvents']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos becados: ' . $tDefaulters[0]['scholarship'] . " (" . number_format((($tDefaulters[0]['scholarship']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<br />
				<br />
			</div>
		<?php else: ?>
			<div>
				<div style="float: left; width:10%;">
					<p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 2</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div style="clear: both;">
				<br />
				<br />
				<p><b><?= 'Total morosidad a la fecha Bs.S ' . number_format($totalDebt, 2, ",", ".") ?><b></p>
				<p><b><?= 'Total alumnos morosos: ' . $tDefaulters[0]['defaulters'] . " (" . number_format((($tDefaulters[0]['defaulters']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos solventes: ' . $tDefaulters[0]['solvents'] . " (" . number_format((($tDefaulters[0]['solvents']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos becados: ' . $tDefaulters[0]['scholarship'] . " (" . number_format((($tDefaulters[0]['scholarship']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<br />
				<br />
			</div>
		<?php endif; ?>
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