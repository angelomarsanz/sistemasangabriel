<?php
/**
 * Reporte General de Estudiantes - Seguro Escolar
 *
 * Esta vista permite generar diferentes tipos de reportes relacionados con el seguro escolar de los estudiantes.
 * Tipos de reporte:
 * - Reporte para aseguradora: Muestra datos detallados de estudiantes y representantes para la póliza de seguro,
 *   incluyendo una sección especial para registros que ya cuentan con instrucción previa.
 * - Reporte de alumnos solventes: Lista estudiantes que están al día con sus pagos.
 * - Reporte de alumnos pendientes de pago: Lista estudiantes con deudas pendientes.
 */
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
<?php
    setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');
    date_default_timezone_set('America/Caracas');
    $currentDate = Time::now();
    $accountStudent = 1;
    $nivel =
        [
            '' => '',
            'Maternal' => '0',
            'Pre-escolar, pre-kinder' => '1',
            'Pre-escolar, kinder' => '1',
            'Pre-escolar, preparatorio' => '1',
            'Primaria, 1er. grado' => '2',
            'Primaria, 2do. grado' => '2',
            'Primaria, 3er. grado' => '2',
            'Primaria, 4to. grado' => '2',
            'Primaria, 5to. grado' => '2',
            'Primaria, 6to. grado' => '2',
            'Secundaria, 1er. año' => '3',
            'Secundaria, 2do. año' => '3',
            'Secundaria, 3er. año' => '3',
            'Secundaria, 4to. año' => '4',
            'Secundaria, 5to. año' => '4'
        ];
    $grado =
        [
            '' => '',
            'Maternal' => '01',
            'Pre-escolar, pre-kinder' => '01',
            'Pre-escolar, kinder' => '02',
            'Pre-escolar, preparatorio' => '03',
            'Primaria, 1er. grado' => '01',
            'Primaria, 2do. grado' => '02',
            'Primaria, 3er. grado' => '03',
            'Primaria, 4to. grado' => '04',
            'Primaria, 5to. grado' => '05',
            'Primaria, 6to. grado' => '06',
            'Secundaria, 1er. año' => '07',
            'Secundaria, 2do. año' => '08',
            'Secundaria, 3er. año' => '09',
            'Secundaria, 4to. año' => '01',
            'Secundaria, 5to. año' => '02'
        ];

    $seccion =
        [
            '1' => 'No asignada',
            '2' => 'A',
            '3' => 'B',
            '4' => 'C',
            '5' => 'A',
            '6' => 'B',
            '7' => 'C',
            '8' => 'A',
            '9' => 'B',
            '10' => 'C',
            '11' => 'A',
            '12' => 'B',
            '13' => 'C',
            '14' => 'A',
            '15' => 'B',
            '16' => 'C',
            '17' => 'A',
            '18' => 'B',
            '19' => 'C',
            '20' => 'A',
            '21' => 'B',
            '22' => 'C',
            '23' => 'A',
            '24' => 'B',
            '25' => 'C',
            '26' => 'A',
            '27' => 'B',
            '28' => 'C',
            '29' => 'A',
            '30' => 'B',
            '31' => 'C',
            '32' => 'A',
            '33' => 'B',
            '34' => 'C',
            '35' => 'A',
            '36' => 'B',
            '37' => 'C',
            '38' => 'A',
            '39' => 'B',
            '40' => 'C',
            '41' => 'A',
            '42' => 'B',
            '43' => 'C',
            '44' => 'A'
        ];
    ?>
<br />
<?php if (isset($tipo_reporte)): ?>
    <?php if ($tipo_reporte == "Reporte para aseguradora"): ?>
        <div>
            <div>
                <div style="float: left; width:10%;">
                    <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                </div>
                <div style="float: left; width: 90%;">
                    <h5><b><?= $school->name ?></b></h5>
                    <p>RIF: <?= $school->rif ?></p>
                    <h3 style="text-align: center;">Reporte Seguro Escolar al: <?= $currentDate->format('d-m-Y') ?></h3>
                </div>
            </div>
            <div class="noExl">
                <h2 style="text-align: center;">Tipo de estudiante: <?= $tipo_estudiante ?></h2>
            </div>
            <div>
                <table id='seguro' class="table">
                    <thead>
                        <tr>
                            <th scope="col">NOMBRE UNIDAD EDUCATIVA</th>
                            <th scope="col">U.E. COLEGIO SAN GABRIEL ARCÁNGEL C.A.</th>
                            <th scope="col">RIF</th>
                            <th scope="col">J-40490885-4</th>
                        </tr>
                        <tr>
                            <th scope="col">DATOS DEL ASEGURADO</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th scope="col">DATOS DEL REPRESENTANTE</th>
                        </tr>
                        <tr>
                            <th scope="col" class="noExl">NRO.</th>
                            <th scope="col">NACIONALIDAD TITULAR</th>
                            <th scope="col">CÉDULA TITULAR ESCOLAR</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO</th>
                            <th scope="col">SEXO TITULAR</th>
                            <th scope="col">FECHA NAC. TITULAR</th>
                            <th scope="col">GRADO</th>
                            <th scope="col">NACIONALIDAD REPRESENTANTE</th>
                            <th scope="col">CEDULA REPRESENTANTE</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO REPRESENTANTE</th>
                            <th scope="col">SEXO REPRESENTANTE</th>
                            <th scope="col">CORREO/EMAIL</th>
                            <th scope="col">NÚMERO TELEFÓNICO</th>
                            <th scope="col">CÓDIGO COLEGIO SAN GABRIEL</th>
                            <th scope="col">EJECUCION REPORTE SEGURO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($studentsFor as $studentsFors):
                            $encontrado = 0;
                            foreach ($alumnosAdicionales as $adicional):
                                if ($studentsFors->student->id == $adicional)
                                {
                                    $encontrado = 1;
                                    break;
                                }
                            endforeach;
                            if ($encontrado == 1): ?>
                                <tr>
                                    <td class="noExl"><?= $accountStudent ?></td>
                                    <td><?= $studentsFors->student->type_of_identification ?></td>
                                    <td><?= $studentsFors->student->identity_card ?></td>
                                    <td><?= $studentsFors->student->first_name ?></td>
                                    <td><?= $studentsFors->student->second_name ?></td>
                                    <td><?= $studentsFors->student->surname ?></td>
                                    <td><?= $studentsFors->student->second_surname ?></td>
                                    <td><?= $studentsFors->student->sex ?></td>
                                    <td><?= $studentsFors->student->birthdate->format('d-m-Y') ?></td>
                                    <td><?= $studentsFors->student->section->full_name ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->type_of_identification ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->identidy_card ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->first_name ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->second_name ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->surname ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->second_surname ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->sex ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->email ?></td>
                                    <td><?= $studentsFors->student->parentsandguardian->cell_phone ?></td>
                                    <td><?= $studentsFors->student->id ?></td>
                                    <td><?= $nuevaEjecucionStr ?></td>
                                </tr>
                                <?php $accountStudent++; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (isset($estudiantesCondicionEspecial) && !empty($estudiantesCondicionEspecial)): ?>
                <div class="saltopagina"></div>
                <div class="page-header">
                    <h3>Estudiantes con condición distinta a Regular</h3>
                </div>
                <table id="tabla-condicion-especial" class="table">
                    <thead>
                        <tr>
                            <th scope="col">NRO.</th>
                            <th scope="col">NOMBRES DEL ESTUDIANTE</th>
                            <th scope="col">CÉDULA</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col">SECCIÓN</th>
                            <th scope="col">FECHA MODIFICACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantesCondicionEspecial as $est): ?>
                            <tr>
                                <td><?= $est['consecutivo'] ?></td>
                                <td><?= $est['nombres'] ?></td>
                                <td><?= $est['cedula'] ?></td>
                                <td><?= $est['condicion'] ?></td>
                                <td><?= $est['seccion'] ?></td>
                                <td><?= $est['modified']->format('d-m-Y H:i:s') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (isset($estudiantesEncontradosSeguro) && !empty($estudiantesEncontradosSeguro)): ?>
                <div class="saltopagina"></div>
                <div class="page-header">
                    <h3>Estudiantes encontrados en las listas del colegio y del seguro (Registros encontrados)</h3>
                </div>
                <table id="tabla-encontrados-seguro" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="noExl">NRO.</th>
                            <th scope="col">NACIONALIDAD TITULAR</th>
                            <th scope="col">CÉDULA TITULAR ESCOLAR</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO</th>
                            <th scope="col">SEXO TITULAR</th>
                            <th scope="col">FECHA NAC. TITULAR</th>
                            <th scope="col">GRADO</th>
                            <th scope="col">NACIONALIDAD REPRESENTANTE</th>
                            <th scope="col">CEDULA REPRESENTANTE</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO REPRESENTANTE</th>
                            <th scope="col">SEXO REPRESENTANTE</th>
                            <th scope="col">CORREO/EMAIL</th>
                            <th scope="col">NÚMERO TELEFÓNICO</th>
                            <th scope="col">CÓDIGO COLEGIO SAN GABRIEL</th>
                            <th scope="col">EJECUCION REPORTE SEGURO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $accInst = 1;
                        foreach ($estudiantesEncontradosSeguro as $item): ?>
                            <tr>
                                <td class="noExl"><?= $accInst++ ?></td>
                                <td><?= $item->student->type_of_identification ?></td>
                                <td><?= $item->student->identity_card ?></td>
                                <td><?= $item->student->first_name ?></td>
                                <td><?= $item->student->second_name ?></td>
                                <td><?= $item->student->surname ?></td>
                                <td><?= $item->student->second_surname ?></td>
                                <td><?= $item->student->sex ?></td>
                                <td><?= $item->student->birthdate->format('d-m-Y') ?></td>
                                <td><?= $item->student->section->full_name ?></td>
                                <td><?= $item->student->parentsandguardian->type_of_identification ?></td>
                                <td><?= $item->student->parentsandguardian->identidy_card ?></td>
                                <td><?= $item->student->parentsandguardian->first_name ?></td>
                                <td><?= $item->student->parentsandguardian->second_name ?></td>
                                <td><?= $item->student->parentsandguardian->surname ?></td>
                                <td><?= $item->student->parentsandguardian->second_surname ?></td>
                                <td><?= $item->student->parentsandguardian->sex ?></td>
                                <td><?= $item->student->parentsandguardian->email ?></td>
                                <td><?= $item->student->parentsandguardian->cell_phone ?></td>
                                <td><?= $item->student->id ?></td>
                                <td><?= $nuevaEjecucionStr ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (isset($estudiantesNoEncontradosSeguro) && !empty($estudiantesNoEncontradosSeguro)): ?>
                <div class="saltopagina"></div>
                <div class="page-header">
                    <h3>Estudiantes no encontrados en archivo del seguro</h3>
                </div>
                <table id="tabla-no-encontrados-seguro" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="noExl">NRO.</th>
                            <th scope="col">NACIONALIDAD TITULAR</th>
                            <th scope="col">CÉDULA TITULAR ESCOLAR</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO</th>
                            <th scope="col">SEXO TITULAR</th>
                            <th scope="col">FECHA NAC. TITULAR</th>
                            <th scope="col">GRADO</th>
                            <th scope="col">NACIONALIDAD REPRESENTANTE</th>
                            <th scope="col">CEDULA REPRESENTANTE</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO REPRESENTANTE</th>
                            <th scope="col">SEXO REPRESENTANTE</th>
                            <th scope="col">CORREO/EMAIL</th>
                            <th scope="col">NÚMERO TELEFÓNICO</th>
                            <th scope="col">CÓDIGO COLEGIO SAN GABRIEL</th>
                            <th scope="col">EJECUCION REPORTE SEGURO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $accNoEnc = 1;
                        foreach ($estudiantesNoEncontradosSeguro as $item): ?>
                            <tr>
                                <td class="noExl"><?= $accNoEnc++ ?></td>
                                <td><?= $item->student->type_of_identification ?></td>
                                <td><?= $item->student->identity_card ?></td>
                                <td><?= $item->student->first_name ?></td>
                                <td><?= $item->student->second_name ?></td>
                                <td><?= $item->student->surname ?></td>
                                <td><?= $item->student->second_surname ?></td>
                                <td><?= $item->student->sex ?></td>
                                <td><?= $item->student->birthdate->format('d-m-Y') ?></td>
                                <td><?= $item->student->section->full_name ?></td>
                                <td><?= $item->student->parentsandguardian->type_of_identification ?></td>
                                <td><?= $item->student->parentsandguardian->identidy_card ?></td>
                                <td><?= $item->student->parentsandguardian->first_name ?></td>
                                <td><?= $item->student->parentsandguardian->second_name ?></td>
                                <td><?= $item->student->parentsandguardian->surname ?></td>
                                <td><?= $item->student->parentsandguardian->second_surname ?></td>
                                <td><?= $item->student->parentsandguardian->sex ?></td>
                                <td><?= $item->student->parentsandguardian->email ?></td>
                                <td><?= $item->student->parentsandguardian->cell_phone ?></td>
                                <td><?= $item->student->id ?></td>
                                <td><?= $nuevaEjecucionStr ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (isset($estudiantesInstruccionActualizada) && !empty($estudiantesInstruccionActualizada)): ?>
                <div class="saltopagina"></div>
                <div class="page-header">
                    <h3>Estudiantes con instrucción ya actualizada</h3>
                </div>
                <table id="tabla-instruccion-actualizada" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="noExl">NRO.</th>
                            <th scope="col">NACIONALIDAD TITULAR</th>
                            <th scope="col">CÉDULA TITULAR ESCOLAR</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO</th>
                            <th scope="col">SEXO TITULAR</th>
                            <th scope="col">FECHA NAC. TITULAR</th>
                            <th scope="col">GRADO</th>
                            <th scope="col">NACIONALIDAD REPRESENTANTE</th>
                            <th scope="col">CEDULA REPRESENTANTE</th>
                            <th scope="col">PRIMER NOMBRE</th>
                            <th scope="col">SEGUNDO NOMBRE</th>
                            <th scope="col">PRIMER APELLIDO</th>
                            <th scope="col">SEGUNDO APELLIDO REPRESENTANTE</th>
                            <th scope="col">SEXO REPRESENTANTE</th>
                            <th scope="col">CORREO/EMAIL</th>
                            <th scope="col">NÚMERO TELEFÓNICO</th>
                            <th scope="col">CÓDIGO COLEGIO SAN GABRIEL</th>
                            <th scope="col">EJECUCION REPORTE SEGURO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $accInstAct = 1;
                        foreach ($estudiantesInstruccionActualizada as $item): ?>
                            <tr>
                                <td class="noExl"><?= $accInstAct++ ?></td>
                                <td><?= $item->student->type_of_identification ?></td>
                                <td><?= $item->student->identity_card ?></td>
                                <td><?= $item->student->first_name ?></td>
                                <td><?= $item->student->second_name ?></td>
                                <td><?= $item->student->surname ?></td>
                                <td><?= $item->student->second_surname ?></td>
                                <td><?= $item->student->sex ?></td>
                                <td><?= $item->student->birthdate->format('d-m-Y') ?></td>
                                <td><?= $item->student->section->full_name ?></td>
                                <td><?= $item->student->parentsandguardian->type_of_identification ?></td>
                                <td><?= $item->student->parentsandguardian->identidy_card ?></td>
                                <td><?= $item->student->parentsandguardian->first_name ?></td>
                                <td><?= $item->student->parentsandguardian->second_name ?></td>
                                <td><?= $item->student->parentsandguardian->surname ?></td>
                                <td><?= $item->student->parentsandguardian->second_surname ?></td>
                                <td><?= $item->student->parentsandguardian->sex ?></td>
                                <td><?= $item->student->parentsandguardian->email ?></td>
                                <td><?= $item->student->parentsandguardian->cell_phone ?></td>
                                <td><?= $item->student->id ?></td>
                                <td><?= $nuevaEjecucionStr ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
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
    <?php else: ?>
        <div>
            <div>
                <div style="float: left; width: 90%;">
                    <h3 style="text-align: center;"><?= $tipo_reporte." (Seguro Escolar) al ".$currentDate->format('d-m-Y') ?></h3>
                </div>
            </div>
            <div>
                <table id='seguro' class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Estudiante</th>
                            <th scope="col">familia</th>
                            <th scope="col">Nivel de estudios</th>
                            <th scope="col">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador_estudiante = 0;
                        foreach ($alumnos_seleccionados as $seleccionado):
                            $contador_estudiante++; ?>
                            <tr>
                                <td><?= $contador_estudiante ?></td>
                                <td><?= $seleccionado['estudiante'] ?></td>
                                <td><?= $seleccionado['familia'] ?></td>
                                <td><?= $seleccionado['nivel_estudios'] ?></td>
                                <td><?= $seleccionado['id'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
    <?php endif; ?>
<?php else: ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="page-header">
                <h3>Reporte de Seguro Escolar</h3>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <?= $this->Form->create() ?>
                        <fieldset>
                            <?php
                                echo $this->Form->input('tipo_reporte', ['id' => 'tipo_reporte', 'label' => 'Tipo de reporte: ', 'required', 'options' =>
                                [
                                    null => "",
                                    "Reporte para aseguradora" => "Reporte para aseguradora",
                                    "Reporte de alumnos solventes" => "Reporte de alumnos solventes",
                                    "Reporte de alumnos pendientes de pago" => "Reporte de alumnos pendientes de pago"
                                ]]);
                            ?>
                            <div id="div-periodo-escolar" class="noverScreen">
                                <?php
                                    echo $this->Form->input('periodo_escolar', ['id' => 'periodo-escolar', 'label' => 'Período escolar: ', 'options' =>
                                    [
                                        null => "",
                                        $periodo_escolar_anterior => $periodo_escolar_anterior,
                                        $periodo_escolar_actual => $periodo_escolar_actual,
                                        $periodo_escolar_proximo => $periodo_escolar_proximo
                                    ]]);
                                ?>
                            </div>
                            <div id="div-tipo-estudiante" class="noverScreen">
                                <?php
                                    echo $this->Form->input('tipo_estudiante', ['id' => 'tipo-estudiante', 'label' => 'Tipo de estudiante: ', 'options' =>
                                    [
                                        null => "",
                                        "Nuevo" => "Nuevo",
                                        "Regular" => "Regular versus archivo del seguro",
                                        "Nuevo y Regular" => "Nuevo y Regular",
                                        "5to. Año" => "5to. Año"
                                    ]]);
                                ?>
                            </div>
                        </fieldset>
                        <?= $this->Form->button(__('Generar'), ['class' =>'btn btn-success']) ?>
                        <?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-default']) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
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

    $("#excel").click(function(e){
        e.preventDefault();
        
        var wb = XLSX.utils.book_new();
        var tipoReporte = "<?= isset($tipo_reporte) ? $tipo_reporte : '' ?>";
        
        // Función para agregar tabla al libro si existe
        function addTableToSheet(tableId, sheetName) {
            var table = document.getElementById(tableId);
            if (table) {
                // Clonar tabla para remover columnas con clase .noExl
                var tempTable = table.cloneNode(true);
                $(tempTable).find('.noExl').remove();
                
                var ws = XLSX.utils.table_to_sheet(tempTable);
                XLSX.utils.book_append_sheet(wb, ws, sheetName);
            }
        }

        // Caso: Reporte para aseguradora
        if (tipoReporte == "Reporte para aseguradora") {
            addTableToSheet('seguro', 'Seguro Escolar');
            addTableToSheet('tabla-condicion-especial', 'Condicion Especial');
            addTableToSheet('tabla-encontrados-seguro', 'Encontrados Seguro');
            addTableToSheet('tabla-no-encontrados-seguro', 'No Encontrados Seguro');
            addTableToSheet('tabla-instruccion-actualizada', 'Instruccion Actualizada');
        } else {
            // Otros reportes
            addTableToSheet('seguro', 'Reporte');
        }

        // Exportar archivo
        XLSX.writeFile(wb, "reporte_seguro.xlsx");
    });

    /**
     * Gestiona la visibilidad y obligatoriedad de los campos del formulario
     * según el tipo de reporte seleccionado.
     */
    $("#tipo_reporte").on("change", function(e)
    {
        const tipoReporte = $(this).val();

        if (tipoReporte == "Reporte para aseguradora")
        {
            $("#div-periodo-escolar").addClass("noverScreen");
            $("#periodo-escolar").attr('required', false);

            $("#div-tipo-estudiante").removeClass("noverScreen");
            // Verificar si el campo existe antes de establecer required
            if ($("#tipo-estudiante").length > 0) {
                $("#tipo-estudiante").attr('required', true);
            }
        }
        else if (tipoReporte == "Reporte de alumnos solventes" || tipoReporte == "Reporte de alumnos pendientes de pago")
        {
            $("#div-tipo-estudiante").addClass("noverScreen");
            if ($("#tipo-estudiante").length > 0) {
                $("#tipo-estudiante").attr('required', false);
            }

            $("#div-periodo-escolar").removeClass("noverScreen");
            if ($("#periodo-escolar").length > 0) {
                $("#periodo-escolar").attr('required', true);
            }
        }
        else
        {
            $("#div-periodo-escolar").addClass("noverScreen");
            if ($("#periodo-escolar").length > 0) {
                $("#periodo-escolar").attr('required', false);
            }

            $("#div-tipo-estudiante").addClass("noverScreen");
            if ($("#tipo-estudiante").length > 0) {
                $("#tipo-estudiante").attr('required', false);
            }
        }
    });
});
</script>
