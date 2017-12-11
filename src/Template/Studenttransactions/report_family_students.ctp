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
    <?php $accountPage = 1; ?>
    <p style="text-align: right;"><?= 'Página ' . $accountPage ?></p>
    <div style="width: 100%;">
        <div style="float: left; width:10%;">
            <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
        </div>
        <div style="float: left; width: 90%;">
            <h5><b><?= $school->name ?></b></h5>
            <p>RIF: <?= $school->rif ?></p>
            <h3 style="text-align: center;">Reporte de Alumnos por Familia al: <?= $currentDate->format('d-m-Y') ?></h3>
        </div>
    </div>

    <div style="width: 100%; clear: both;">
        <p>Familias que tienen un hijo: <?= $accountUnHijo ?></p>
        <p>Familias que tienen dos hijos: <?= $accountDosHijos ?></p>
        <p>Familias que tienen tres hijos: <?= $accountTresHijos ?></p>
        <p>Familias que tienen cuatro hijos: <?= $accountCuatroHijos ?></p>
        <p>Familias que tienen cinco hijos o más: <?= $accountCincoOMas ?></p>
        <br />
        <p><b>Total familias en este período escolar: <?= $accountFamily ?></b></p> 
        <p><b>Total alumnos inscritos en este período escolar: <?= $account ?></b></p> 
    </div>

    <a title="Cerrar" class='nover cerrar img-thumbnail img-responsive' href='/sistemasangabriel/users/wait'><img src='/sistemasangabriel/img/x.png' width = 25 height = 25 border="0"/></a>
    <a title="Volver" class='nover volver img-thumbnail img-responsive' href='/sistemasangabriel/users/wait'><img src='/sistemasangabriel/img/volver.jpg' width = 25 height = 25 border="0"/></a>
    <button title="Imprimir" onclick="myFunction()" class="nover imprimir img-thumbnail img-responsive"><img src='/sistemasangabriel/img/impresora.jpg' width = 25 height = 25 border="0"/></button>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>