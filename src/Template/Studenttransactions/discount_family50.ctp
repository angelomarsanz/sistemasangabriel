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
    <div>
        <div style="float: left; width:10%;">
            <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
        </div>
        <div style="float: left; width: 90%;">
            <h5><b><?= $school->name ?></b></h5>
            <p>RIF: <?= $school->rif ?></p>
        </div>
    </div>
    <h3 style="text-align: center;">Familias con Cuatro o más Hijos</h3>
    <?php $accountStudent = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Familia</th>
                <th scope="col">id</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayFamily50 as $arrayFamily50s): ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $arrayFamily50s['family'] ?></td>
                    <td><?= $arrayFamily50s['id'] ?></td>
                </tr>
                <?php $accountStudent++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><?= 'Total familias con cuatro o más hijos : ' . $accountCuatroOmas ?></p>
    <p><?= 'Total alumnos inscritos: ' . $account ?></p>
    
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