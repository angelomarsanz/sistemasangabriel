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
        <?php if ($complement[$studentsFors->id]['swGraduate'] == 1): ?>
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
                        <h3 style="text-align: center;">Reporte de Alumnos Egresados al: <?= $currentDate->format('d-m-Y') ?></h3>
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
                            <td style="display: none;"><?= $studentsFors->id ?></td>
                            <td style="width: 20%;"><?= $studentsFors->full_name ?></td>
                            <?php if ($studentsFors->type_of_identification != 'PN' && $studentsFors->identity_card > '9999'): ?>
                                <td style="width: 10%;"><?= $studentsFors->type_of_identification . '-' . $studentsFors->identity_card ?></td>
                            <?php else: ?>
                                <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                            <?php endif; ?>
                            <td style="width: 2%;"><?= $studentsFors->sex ?></td>
                            <?php if (isset($studentsFors->birthdate)): ?>
                                <td style="width: 10%;"><?= $studentsFors->birthdate->format('d-m-Y') ?></td>
                            <?php endif; ?>
                            <td style="width: 20%;"><?= $studentsFors->section->sublevel ?></td>
                            <td style="width: 20%;"><?= $studentsFors->parentsandguardian->full_name ?></td>
                            <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
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
                                <h3 style="text-align: center;">Reporte de Alumnos Egresados al: <?= $currentDate->format('d-m-Y') ?></h3>
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
                                    <td style="display: none;"><?= $studentsFors->id ?></td>
                                    <td style="width: 20%;"><?= $studentsFors->full_name ?></td>
                                    <?php if ($studentsFors->type_of_identification != 'PN' && $studentsFors->identity_card > '9999'): ?>
                                        <td style="width: 10%;"><?= $studentsFors->type_of_identification . '-' . $studentsFors->identity_card ?></td>
                                    <?php else: ?>
                                        <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                                    <?php endif; ?>
                                    <td style="width: 2%;"><?= $studentsFors->sex ?></td>
                                    <?php if (isset($studentsFors->birthdate)): ?>
                                        <td style="width: 10%;"><?= $studentsFors->birthdate->format('d-m-Y') ?></td>
                                    <?php endif; ?>
                                    <td style="width: 20%;"><?= $studentsFors->section->sublevel ?></td>
                                    <td style="width: 20%;"><?= $studentsFors->parentsandguardian->full_name ?></td>
                                    <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                                </tr>
                        <?php $accountLine = 1; ?>
                    <?php else: ?>
                        <tr>
                            <td style="width: 2%;"><?= $accountStudent ?></td>
                            <td style="display: none;"><?= $studentsFors->id ?></td>
                            <td style="width: 20%;"><?= $studentsFors->full_name ?></td>
                            <?php if ($studentsFors->type_of_identification != 'PN' && $studentsFors->identity_card > '9999'): ?>
                                <td style="width: 10%;"><?= $studentsFors->type_of_identification . '-' . $studentsFors->identity_card ?></td>
                            <?php else: ?>
                                <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                            <?php endif; ?>
                            <td style="width: 2%;"><?= $studentsFors->sex ?></td>
                            <?php if (isset($studentsFors->birthdate)): ?>
                                <td style="width: 10%;"><?= $studentsFors->birthdate->format('d-m-Y') ?></td>
                            <?php endif; ?>
                            <td style="width: 20%;"><?= $studentsFors->section->sublevel ?></td>
                            <td style="width: 20%;"><?= $studentsFors->parentsandguardian->full_name ?></td>
                            <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                        </tr>
                    <?php endif; ?>
            <?php endif; ?>
            <?php $accountStudent++; ?>
            <?php $accountLine++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
</div>
<!-- Archivo EXCEL -->
<div class='noverScreen'>
    <?php $accountStudent = 1; ?>
    <table id='egresados' class="table">
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
                <?php if ($complement[$studentsFors->id]['swGraduate'] == 1): ?>
                    <tr>
                        <td style="width: 2%;"><?= $accountStudent ?></td>
                        <td style="display: none;" class='noExl'><?= $studentsFors->id ?></td>
                        <td style="width: 20%;"><?= $studentsFors->full_name ?></td>
                        <?php if ($studentsFors->type_of_identification != 'PN' && $studentsFors->identity_card > '9999'): ?>
                            <td style="width: 10%;"><?= $studentsFors->type_of_identification . '-' . $studentsFors->identity_card ?></td>
                        <?php else: ?>
                            <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                        <?php endif; ?>
                        <td style="width: 2%;"><?= $studentsFors->sex ?></td>
                        <?php if (isset($studentsFors->birthdate)): ?>
                            <td style="width: 10%;"><?= $studentsFors->birthdate->format('d-m-Y') ?></td>
                        <?php endif; ?>
                        <td style="width: 20%;"><?= $studentsFors->section->sublevel ?></td>
                        <td style="width: 20%;"><?= $studentsFors->parentsandguardian->full_name ?></td>
                        <td style="width: 10%;"><?= $studentsFors->parentsandguardian->type_of_identification . '-' . $studentsFors->parentsandguardian->identidy_card ?></td>
                    </tr>
                    <?php $accountStudent++; ?>
                <?php endif; ?>
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
        
        $("#egresados").table2excel({
    
            exclude: ".noExl",
        
            name: "Alumnos egresados",
        
            filename: "alumnos egresados" 
    
        });
    });
});
</script>