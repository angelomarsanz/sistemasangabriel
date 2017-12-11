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
    <h3 style="text-align: center;">Alumnos a los que se les aplicó el descuento en las mensualidades al <?= $currentDate->format('d-m-Y') ?></h3>
    <?php $accountStudent = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Familia</th>
                <th scope="col">Descuento</th>
                <th scope="col" style="display: none;">id</th>
                <th scope="col">Alumno</th>
                <th scope="col">Grado</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayDiscounts as $arrayDiscount): ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $arrayDiscount['family'] ?></td>
                    <td><?= $arrayDiscount['discount'] ?></td>
                    <td style="display: none;"><?= $arrayDiscount['id'] ?></td>
                    <td><?= $arrayDiscount['student'] ?></td>
                    <td><?= $arrayDiscount['grade'] ?></td>
                </tr>
                <?php $accountStudent++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<!--
    <h3 style="text-align: center;">Alumnos Becados a los que no se les debe aplicar el descuento</h3>
    <?php $accountStudent = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Alumno</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayScholarship as $arrayScholarships): ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $arrayScholarships['student'] ?></td>
                </tr>
                <?php $accountStudent++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3 style="text-align: center;">Alumnos que ya tenían el descuento aplicado</h3>
    <?php $accountStudent = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Alumno</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayApplied as $arrayApplieds): ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $arrayApplieds['student'] ?></td>
                </tr>
                <?php $accountStudent++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3 style="text-align: center;">Casos de alumnos que se deben revisar</h3>
    <?php $accountStudent = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Alumno</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayReview as $arrayReviews): ?>
                <tr>
                    <td><?= $accountStudent ?></td>
                    <td><?= $arrayReviews['student'] ?></td>
                </tr>
                <?php $accountStudent++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><?= 'Total familias con tres hijos : ' . $accountTresHijos ?></p>
    <p><?= 'Total familias con cuatro o más hijos : ' . $accountCuatroOmas ?></p>
    <p><?= 'Total alumnos inscritos: ' . $account ?></p>
-->
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