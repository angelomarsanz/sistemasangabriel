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
<div>
    <br />
    <?php setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); ?> 
    <?php date_default_timezone_set('America/Caracas'); ?>
    <? $currentDate = Time::now(); ?>
    <?php $accountStudent = 1; ?>
    <?php $accountLine = 1; ?>
    <?php $accountPage = 1; ?>

    <?php foreach ($studentsFor as $studentsFors): ?> 
        <?php if ($accountStudent == 1): ?>
            <p style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
            <?php $accountPage++; ?>
            <div>
                <div style="float: left; width:10%;">
                    <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                </div>
                <div style="float: left; width: 90%;">
                    <h5><b><?= $school->name ?></b></h5>
                    <p>RIF: <?= $school->rif ?></p>
                    <h3 style="text-align: center;">Reporte de Alumnos Inscritos al: <?= $currentDate->format('d-m-Y') ?></h3>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%;">Nro.</th>
                        <th scope="col" style="display: none;">Id</th>
                        <th scope="col" style="width: 20%;">Alumno</th>
                        <th scope="col" style="width: 10%;">Cédula alumno</th>
                        <th scope="col" style="width: 2%;">Sexo</th>
                        <th scope="col" style="width: 10%;">Fecha nac.</th>
                        <th scope="col" style="width: 20%;">Grado</th>
                        <th scope="col" style="width: 20%;">Representante</th>
                        <th scope="col" style="width: 10%;">Cédula representante</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 2%;"><?= $accountStudent ?></td>
                        <td style="display: none;"><?= $studentsFors->student->id ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->full_name ?></td>
                        <?php if ($studentsFors->student->type_of_identification != 'PN' && $studentsFors->student->identity_card > '9999'): ?>
                            <td style="width: 10%;"><?= $studentsFors->student->type_of_identification . '-' . $studentsFors->student->identity_card ?></td>
                        <?php else: ?>
                            <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                        <?php endif; ?>
                        <td style="width: 2%;"><?= $studentsFors->student->sex ?></td>
                        <td style="width: 10%;"><?= $studentsFors->student->birthdate->format('d-m-Y') ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->level_of_study ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->parentsandguardian->full_name ?></td>
                        <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                    </tr>
        <?php else: ?> 
                <?php if ($accountLine > 20): ?>
                    </tbody>
                    </table>
                    <p class="saltopagina" style="text-align: right;"><?= 'Página ' . $accountPage . ' de ' . $totalPages ?></p>
                    <?php $accountPage++; ?>
                    <div>
                        <div style="float: left; width:10%;">
                            <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                        </div>
                        <div style="float: left; width: 90%;">
                            <h5><b><?= $school->name ?></b></h5>
                            <p>RIF: <?= $school->rif ?></p>
                            <h3 style="text-align: center;">Reporte de Alumnos Inscritos al: <?= $currentDate->format('d-m-Y') ?></h3>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 2%;">Nro.</th>
                                <th scope="col" style="display: none;">Id</th>
                                <th scope="col" style="width: 20%;">Alumno</th>
                                <th scope="col" style="width: 10%;">Cédula alumno</th>
                                <th scope="col" style="width: 2%;">Sexo</th>
                                <th scope="col" style="width: 10%;">Fecha nac.</th>
                                <th scope="col" style="width: 20%;">Grado</th>
                                <th scope="col" style="width: 20%;">Representante</th>
                                <th scope="col" style="width: 10%;">Cédula representante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 2%;"><?= $accountStudent ?></td>
                                <td style="display: none;"><?= $studentsFors->student->id ?></td>
                                <td style="width: 20%;"><?= $studentsFors->student->full_name ?></td>
                                <?php if ($studentsFors->student->type_of_identification != 'PN' && $studentsFors->student->identity_card > '9999'): ?>
                                    <td style="width: 10%;"><?= $studentsFors->student->type_of_identification . '-' . $studentsFors->student->identity_card ?></td>
                                <?php else: ?>
                                    <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                                <?php endif; ?>
                                <td style="width: 2%;"><?= $studentsFors->student->sex ?></td>
                                <td style="width: 10%;"><?= $studentsFors->student->birthdate->format('d-m-Y') ?></td>
                                <td style="width: 20%;"><?= $studentsFors->student->level_of_study ?></td>
                                <td style="width: 20%;"><?= $studentsFors->student->parentsandguardian->full_name ?></td>
                                <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                            </tr>
                    <?php $accountLine = 1; ?>
                <?php else: ?>
                    <tr>
                        <td style="width: 2%;"><?= $accountStudent ?></td>
                        <td style="display: none;"><?= $studentsFors->student->id ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->full_name ?></td>
                        <?php if ($studentsFors->student->type_of_identification != 'PN' && $studentsFors->student->identity_card > '9999'): ?>
                            <td style="width: 10%;"><?= $studentsFors->student->type_of_identification . '-' . $studentsFors->student->identity_card ?></td>
                        <?php else: ?>
                            <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                        <?php endif; ?>
                        <td style="width: 2%;"><?= $studentsFors->student->sex ?></td>
                        <td style="width: 10%;"><?= $studentsFors->student->birthdate->format('d-m-Y') ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->level_of_study ?></td>
                        <td style="width: 20%;"><?= $studentsFors->student->parentsandguardian->full_name ?></td>
                        <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                    </tr>
                <?php endif; ?>
        <?php endif; ?>
        <?php $accountStudent++; ?>
        <?php $accountLine++; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
</div>
<!-- Archivo EXCEL -->
<div class='noverScreen'>
    <?php $accountStudent = 1; ?>
    <table id='inscritos' class="table">
        <thead>
            <tr>
                <th scope="col" style="width: 2%;">Nro.</th>
                <th scope="col" style="display: none;" class='noExl'>Id</th>
                <th scope="col" style="width: 20%;">Alumno</th>
                <th scope="col" style="width: 10%;">Cédula alumno</th>
                <th scope="col" style="width: 2%;">Sexo</th>
                <th scope="col" style="width: 10%;">Fecha nac.</th>
                <th scope="col" style="width: 20%;">Grado</th>
                <th scope="col" style="width: 20%;">Representante</th>
                <th scope="col" style="width: 10%;">Cédula representante</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studentsFor as $studentsFors): ?>
                <tr>
                    <td style="width: 2%;"><?= $accountStudent ?></td>
                    <td style="display: none;" class='noExl'><?= $studentsFors->student->id ?></td>
                    <td style="width: 20%;"><?= $studentsFors->student->full_name ?></td>
                    <?php if ($studentsFors->student->type_of_identification != 'PN' && $studentsFors->student->identity_card > '9999'): ?>
                        <td style="width: 10%;"><?= $studentsFors->student->type_of_identification . '-' . $studentsFors->student->identity_card ?></td>
                    <?php else: ?>
                        <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                    <?php endif; ?>
                    <td style="width: 2%;"><?= $studentsFors->student->sex ?></td>
                    <td style="width: 10%;"><?= $studentsFors->student->birthdate->format('d-m-Y') ?></td>
                    <td style="width: 20%;"><?= $studentsFors->student->level_of_study ?></td>
                    <td style="width: 20%;"><?= $studentsFors->student->parentsandguardian->full_name ?></td>
                    <td style="width: 10%;"><?= $studentsFors->student->parentsandguardian->type_of_identification . '-' . $studentsFors->student->parentsandguardian->identidy_card ?></td>
                </tr>
                <?php $accountStudent++; ?>
            <?php endforeach; ?>
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
        <a href="../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
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
        
        $("#inscritos").table2excel({
    
            exclude: ".noExl",
        
            name: "Alumnos inscritos",
        
            filename: "alumnos inscritos" 
    
        });
    });
});
</script>