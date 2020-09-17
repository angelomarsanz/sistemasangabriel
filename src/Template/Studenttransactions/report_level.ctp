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
<div>
    <br />
    <?php $accountStudent = 1; ?>
    <?php $accountLine = 1; ?>
    <?php $accountPage = 1; ?>
    <?php $currentSection = ""; ?>

    <?php foreach ($studentsFor as $studentsFors): ?> 
        <?php if ($accountStudent == 1): ?>
            <p style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
			<p style="text-align: right;"><?= 'Fecha y hora: ' . $fechaActual->format('d-m-Y H:i:s') ?></p>
            <?php $currentSection = $studentsFors->student->section->section; ?>
            <?php $accountPage++; ?>
            <div>
                <div style="float: left; width:10%;">
                    <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                </div>
                <div style="float: left; width: 90%;">
                    <h5><b><?= $school->name ?></b></h5>
                    <p>RIF: <?= $school->rif ?></p>
                    <h3 style="text-align: center;"><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?> </h3>
                </div>
            </div>
        	<table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col" style="display: none;">Id</th>
                        <th scope="col">Alumno</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $accountStudent ?></td>
                        <td style="display: none;"><?= $studentsFors->student->id ?></td>
                        <td><?= $studentsFors->student->full_name ?></td>
                    </tr>
        <?php else: ?> 
            <?php if ($currentSection == $studentsFors->student->section->section): ?>
                <?php if ($accountLine > 30): ?>
                    </tbody>
                    </table>
                    <p class="saltopagina" style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
					<p style="text-align: right;"><?= 'Fecha y hora: ' . $fechaActual->format('d-m-Y H:i:s') ?></p>
                    <?php $accountPage++; ?>
                    <div>
                        <div style="float: left; width:10%;">
                            <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                        </div>
                        <div style="float: left; width: 90%;">
                            <h5><b><?= $school->name ?></b></h5>
                            <p>RIF: <?= $school->rif ?></p>
                            <h3 style="text-align: center;"><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?> </h3>
                        </div>
                    </div>
                	<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nro.</th>
                                <th scope="col" style="display: none;">Id</th>
                                <th scope="col">Alumno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $accountStudent ?></td>
                                <td style="display: none;"><?= $studentsFors->id ?></td>
                                <td><?= $studentsFors->student->full_name ?></td>
                            </tr>
                        <?php $accountLine = 1; ?>
                <?php else: ?>
                    <tr>
                        <td><?= $accountStudent ?></td>
                        <td style="display: none;"><?= $studentsFors->id ?></td>
                        <td><?= $studentsFors->student->full_name ?></td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                </tbody>
                </table>
                <p class="saltopagina" style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
				<p style="text-align: right;"><?= 'Fecha y hora: ' . $fechaActual->format('d-m-Y H:i:s') ?></p>
                <?php $accountPage++; ?>
                <?php $accountStudent = 1 ?>
                <?php $currentSection = $studentsFors->student->section->section; ?>
                <div>
                    <div style="float: left; width:10%;">
                        <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                    </div>
                    <div style="float: left; width: 90%;">
                        <h5><b><?= $school->name ?></b></h5>
                        <p>RIF: <?= $school->rif ?></p>
                        <h3 style="text-align: center;"><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?> </h3>
                    </div>
                </div>
            	<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col" style="display: none;">Id</th>
                            <th scope="col">Alumno</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $accountStudent ?></td>
                            <td style="display: none;"><?= $studentsFors->id ?></td>
                            <td><?= $studentsFors->student->full_name ?></td>
                        </tr>
                <?php $accountLine = 1; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php $accountStudent++; ?>
        <?php $accountLine++; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
</div>
<!-- Archivo EXCEL -->
<div class='noverScreen nover'>
    <?php $accountRecords = 1; ?>
    <?php $accountStudent = 1; ?>
    <?php foreach ($studentsFor as $studentsFors): ?>
        <?php if ($accountRecords == 1): ?>
            <?php $currentSection = $studentsFors->student->section->section; ?>
        	<table id=<?= 'seccion' . $studentsFors->student->section->section ?> name=<?= $levelChatScript . '_' . $studentsFors->student->section->section ?> class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Grado y sección</th>
                        <th scope="col">Alumno</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $accountStudent ?></td>
                        <?php if ($accountStudent == 1): ?>
                            <td><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?></td>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>                            
                        <td><?= $studentsFors->student->full_name ?></td>
                    </tr>
            <?php $accountRecords++; ?>
            <?php $accountStudent++; ?>
        <?php else: ?>
            <?php if ($currentSection != $studentsFors->student->section->section): ?>
                </tbody>
                </table>
                <?php $currentSection = $studentsFors->student->section->section; ?>
                <?php $accountStudent = 1; ?>
            	<table id=<?= 'seccion' . $studentsFors->student->section->section ?> name=<?= $levelChatScript . '_' . $studentsFors->student->section->section ?> class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Grado y sección</th>
                            <th scope="col">Alumno</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $accountStudent ?></td>
                            <?php if ($accountStudent == 1): ?>
                                <td><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?></td>
                            <?php else: ?>
                                <td></td>
                            <?php endif; ?>                            
                            <td><?= $studentsFors->student->full_name ?></td>
                        </tr>
                <?php $accountRecords++; ?>
                <?php $accountStudent++; ?>
            <?php else: ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <?php if ($accountStudent == 1): ?>
                        <td><?=  $level . ", sección '" . $studentsFors->student->section->section . "'" ?></td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>                            
                    <td><?= $studentsFors->student->full_name ?></td>
                </tr>
                <?php $accountRecords++; ?>
                <?php $accountStudent++; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach ?>
    </tbody>
    </table>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="../../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
        <a href='#' id="excel" title="EXCEL" class='glyphicon glyphicon-list-alt btn btn-danger'></a>
        <a href='#' onclick='myFunction()' id="imprimir" title="Imprimir" class='glyphicon glyphicon-print btn btn-danger'></a>
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
    
    $("#excel").click(function(){
        
        $("#seccionA").table2excel({
    
            exclude: ".noExl",
        
            name: "seccionA",
        
            filename: $('#seccionA').attr('name') 
    
        });
        $("#seccionB").table2excel({
    
            exclude: ".noExl",
        
            name: "seccionB",
        
            filename: $('#seccionB').attr('name')
    
        });
        $("#seccionC").table2excel({
    
            exclude: ".noExl",
        
            name: "seccionC",
        
            filename: $('#seccionC').attr('name')
    
        });
    });
});
</script>