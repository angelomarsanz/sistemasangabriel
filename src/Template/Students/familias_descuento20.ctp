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
    <h3 style="text-align: center;">Familias con Tres Hijos</h3>
    <?php $accountStudent = 0; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Familia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vectorFamilias as $vectorFamilia): ?>
			    <?php $accountStudent++ ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $vectorFamilia ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><?= 'Total familias con tres hijos : ' . $accountStudent ?></p>
    
    <button title="Imprimir" onclick="myFunction()" class="nover imprimir img-thumbnail img-responsive"><img src='../img/impresora.jpg' width = 25 height = 25 border="0"/></button>
</div>
<script>
function myFunction() 
{
    window.print();
}
</script>