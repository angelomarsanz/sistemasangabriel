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
                    <h3 style="text-align: center;"><?=  $level . ", sección '" . $section . "'" ?> </h3>
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
            <?php if ($accountLine > 30): ?>
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
                    <h3 style="text-align: center;"><?=  $level . ", sección '" . $section . "'" ?> </h3>
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
        <?php endif; ?>
        <?php $accountStudent++; ?>
        <?php $accountLine++; ?>
    <?php endforeach; ?>
                </tbody>
            </table>
    <a title="Cerrar" class='nover cerrar img-thumbnail img-responsive' href='/sistemasangabriel/users/wait'><img src='/sistemasangabriel/img/x.png' width = 25 height = 25 border="0"/></a>
    <a title="Volver" class='nover volver img-thumbnail img-responsive' href='/sistemasangabriel/studenttransactions/searchSections'><img src='/sistemasangabriel/img/volver.jpg' width = 25 height = 25 border="0"/></a>
    <button title="Imprimir" onclick="myFunction()" class="nover imprimir img-thumbnail img-responsive"><img src='/sistemasangabriel/img/impresora.jpg' width = 25 height = 25 border="0"/></button>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>