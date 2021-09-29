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
    <?php 
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');  
        date_default_timezone_set('America/Caracas'); 
        $currentDate = Time::now(); 
        $accountStudent = 1; 
        $accountLine = 1; 
        $accountPage = 1; 
        $nivel = 
            [
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
                '43' => 'C'
            ];
        ?>
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
        <table id='inscritos' class="table">
            <thead>
                <tr>
                    <th scope="col" style="display: none;" class="noExl">Id</th>
                    <th scope="col">NÚMERO DE PÓLIZA</th>
                    <th scope="col">NACIONALIDAD ALUMNO</th>
                    <th scope="col">CÉDULA ALUMNO</th>
                    <th scope="col">APELLIDOS ALUMNO</th>
                    <th scope="col">NOMBRES ALUMNO</th>
                    <th scope="col">NIVEL DE ESTUDIOS</th>
                    <th scope="col">AÑO O GRADO</th>
                    <th scope="col">SECCIÓN</th>
                    <th scope="col">FECHA_CARGA</th>
                    <th scope="col">FECHA_NACIMIENTO</th>
                    <th scope="col">NACIONALIDAD REPRESENTANTE</th>
                    <th scope="col">CÉDULA REPRESENTANTE</th>
                    <th scope="col">NOMBRE REPRESENTANTE</th>
                    <th scope="col">NÚMERO ALUMNO</th>
                    <th scope="col">INDICADOR</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($studentsFor as $studentsFors): ?>
            <tr>
                <td style="display: none;" class="noExl"><?= $studentsFors->student->id ?></td>
                <td></td>
                <?php if ($studentsFors->student->type_of_identification != 'PN'): ?>
                    <td><?= $studentsFors->student->type_of_identification ?></td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
                <?php if ($studentsFors->student->type_of_identification != 'PN' && $studentsFors->student->identity_card > '9999'): ?>
                    <td><?= $studentsFors->student->identity_card ?></td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
                <td><?= $studentsFors->student->surname . ' ' . $studentsFors->student->second_surname ?></td>
                <td><?= $studentsFors->student->first_name . ' ' . $studentsFors->student->second_name ?></td>
                <td><?= $nivel[$studentsFors->student->level_of_study] ?></td>
                <td><?= $grado[$studentsFors->student->level_of_study] ?></td>
                <td><?= $seccion[$studentsFors->student->section_id] ?></td>
                <td><?= $currentDate->format('Ymd') ?></td>
                <td><?= $studentsFors->student->birthdate->format('Ymd') ?></td>
                <td><?= $studentsFors->student->parentsandguardian->type_of_identification ?></td>
                <td><?= $studentsFors->student->parentsandguardian->identidy_card ?></td>
                <td><?= $studentsFors->student->parentsandguardian->full_name ?></td>
                <td><?= $accountStudent ?></td>
                <?php if ($studentsFors->student->new_student == 0): ?>
                    <td>N</td>                          
                <?php else: ?>
                    <td>R</td>
                <?php endif; ?>
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