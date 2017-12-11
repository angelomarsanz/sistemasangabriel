<style>
@media screen
{
    .cerrar 
    {
        display:scroll;
        position:fixed;
        bottom:5%;
        right: 50px;
    }
    .volver 
    {
        display:scroll;
        position:fixed;
        bottom:5%;
        right: 95px;
    }
    .imprimir 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 140px;
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
    <a title="Cerrar" class='nover cerrar img-thumbnail img-responsive' href='../users/wait'><img src='../img/x.png' width = 25 height = 25 border="0"/></a>
    <a title="Volver" class='nover volver img-thumbnail img-responsive' href='../users/wait'><img src='../img/volver.jpg' width = 25 height = 25 border="0"/></a>
    <button title="Imprimir" onclick="myFunction()" class="nover imprimir img-thumbnail img-responsive"><img src='../img/impresora.jpg' width = 25 height = 25 border="0"/></button>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>