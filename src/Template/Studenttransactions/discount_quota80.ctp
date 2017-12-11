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
<!-- Reporte principal -->
<div>
    <?php $accountItem = 1; ?>
    <?php $accountLine = 1; ?>
    <?php $accountPage = 1; ?>

    <?php foreach ($arrayDiscounts as $arrayDiscount): ?> 
        <?php if ($accountItem == 1): ?>
            <div>
                <div style="float: left; width:50%; text-align: left;">
                    <p><?= 'Fecha/hora: ' . $currentDate->format('d-m-Y H:i:s') ?></p>
                </div>
                <div style="float: left; width:50%; text-align: right;">
                    <p><?= 'Página: ' . $accountPage ?></p>
                </div>
            </div>
            <?php $accountPage++ ?>
            <div>
                <div style="float: left; width:10%;">
                    <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                </div>
                <div style="float: left; width: 90%;">
                    <h5><b><?= $school->name ?></b></h5>
                    <p>RIF: <?= $school->rif ?></p>
                </div>
            </div>
            <h3 style="text-align: center;">Alumnos a los que se les Aplicó el Descuento del 20% en las Mensualidades</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Familia</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Alumno</th>
                        <th scope="col">Grado</th>
                        <th scope="col" style="display: none;">id</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $accountItem ?></td>
                        <td><?= $arrayDiscount['family'] ?></td>
                        <td><?= $arrayDiscount['discount'] ?></td>
                        <td><?= $arrayDiscount['student'] ?></td>
                        <td><?= $arrayDiscount['grade'] ?></td>
                        <td style="display: none;"><?= $arrayDiscount['id'] ?></td>
                    </tr>
                    <?php $accountItem++ ?>
                    <?php $accountLine++ ?>
        <?php else: ?>
            <?php if ($accountLine > 25): ?>
                </tbody>
                </table>
                <div class="saltopagina">
                    <div style="float: left; width:50%; text-align: left;">
                        <p><?= 'Fecha/hora: ' . $currentDate->format('d-m-Y H:i:s') ?></p>
                    </div>
                    <div style="float: left; width:50%; text-align: right;">
                        <p><?= 'Página: ' . $accountPage ?></p>
                    </div>
                </div>
                <?php $accountPage++; ?>
                <?php $accountLine = 1 ?>
                <div>
                    <div style="float: left; width:10%;">
                        <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                    </div>
                    <div style="float: left; width: 90%;">
                        <h5><b><?= $school->name ?></b></h5>
                        <p>RIF: <?= $school->rif ?></p>
                    </div>
                </div>
                <h3 style="text-align: center;">Alumnos a los que se les Aplicó el Descuento del 20% en las Mensualidades</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Familia</th>
                            <th scope="col">Descuento</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Grado</th>
                            <th scope="col" style="display: none;">id</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $accountItem ?></td>
                            <td><?= $arrayDiscount['family'] ?></td>
                            <td><?= $arrayDiscount['discount'] ?></td>
                            <td><?= $arrayDiscount['student'] ?></td>
                            <td><?= $arrayDiscount['grade'] ?></td>
                            <td style="display: none;"><?= $arrayDiscount['id'] ?></td>
                        </tr>
                        <?php $accountItem++ ?>
                        <?php $accountLine++ ?>
            <?php else: ?>
                <tr>
                    <td><?= $accountItem ?></td>
                    <td><?= $arrayDiscount['family'] ?></td>
                    <td><?= $arrayDiscount['discount'] ?></td>
                    <td><?= $arrayDiscount['student'] ?></td>
                    <td><?= $arrayDiscount['grade'] ?></td>
                    <td style="display: none;"><?= $arrayDiscount['id'] ?></td>
                </tr>
                <?php $accountItem++ ?>
                <?php $accountLine++ ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
    <br />
    <p><b><?= 'Total alumnos a los que se les aplicó el descuento en las mensualidades: ' . ($accountItem - 1) ?></b></p>
    <p><b><?= 'Total familias con tres hijos: ' . ($accountTresHijos) ?></b></p>
</div>
<!-- Archivo EXCEL -->
<div class='noverScreen'>
    <?php $accountItem = 1; ?>
    <table id='descuentos' class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>
                <th scope="col">Familia</th>
                <th scope="col">Descuento</th>
                <th scope="col">Alumno</th>
                <th scope="col">Grado</th>
                <th scope="col" style="display: none;" class="noExl">id</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arrayDiscounts as $arrayDiscount): ?> 
                <tr>
                    <td><?= $accountItem ?></td>
                    <td><?= $arrayDiscount['family'] ?></td>
                    <td><?= $arrayDiscount['discount'] ?></td>
                    <td><?= $arrayDiscount['student'] ?></td>
                    <td><?= $arrayDiscount['grade'] ?></td>
                    <td style="display: none;" class="noExl"><?= $arrayDiscount['id'] ?></td>
                </tr>
                <?php $accountItem++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Reporte de registos descartados -->
<div class="saltopagina">
    <?php $accountItem = 1; ?>
    <?php $accountLine = 1; ?>
    <?php $accountPage = 1; ?>
    <?php foreach ($arrayDiscarded as $arrayDiscardeds): ?> 
        <?php if ($accountItem == 1): ?>
            <div>
                <div style="float: left; width:50%; text-align: left;">
                    <p><?= 'Fecha/hora: ' . $currentDate->format('d-m-Y H:i:s') ?></p>
                </div>
                <div style="float: left; width:50%; text-align: right;">
                    <p><?= 'Página: ' . $accountPage ?></p>
                </div>
            </div>
            <?php $accountPage++ ?>
            <div>
                <div style="float: left; width:10%;">
                    <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                </div>
                <div style="float: left; width: 90%;">
                    <h5><b><?= $school->name ?></b></h5>
                    <p>RIF: <?= $school->rif ?></p>
                </div>
            </div>
            <h3 style="text-align: center;">Registros Descartados</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Motivo</th>
                        <th scope="col">Alumno</th>
                        <th scope="col">id</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $accountItem ?></td>
                        <td><?= $arrayDiscardeds['reason'] ?></td>
                        <td><?= $arrayDiscardeds['student'] ?></td>
                        <td><?= $arrayDiscardeds['id'] ?></td>
                    </tr>
                    <?php $accountItem++ ?>
                    <?php $accountLine++ ?>
        <?php else: ?>
            <?php if ($accountLine > 25): ?>
                </tbody>
                </table>
                <div class="saltopagina">
                    <div style="float: left; width:50%; text-align: left;">
                        <p><?= 'Fecha/hora: ' . $currentDate->format('d-m-Y H:i:s') ?></p>
                    </div>
                    <div style="float: left; width:50%; text-align: right;">
                        <p><?= 'Página: ' . $accountPage ?></p>
                    </div>
                </div>
                <?php $accountPage++; ?>
                <?php $accountLine = 1 ?>
                <div>
                    <div style="float: left; width:10%;">
                        <p><?= $this->html->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
                    </div>
                    <div style="float: left; width: 90%;">
                        <h5><b><?= $school->name ?></b></h5>
                        <p>RIF: <?= $school->rif ?></p>
                    </div>
                </div>
                <h3 style="text-align: center;">Registros Descartados</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">id</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $accountItem ?></td>
                            <td><?= $arrayDiscardeds['reason'] ?></td>
                            <td><?= $arrayDiscardeds['student'] ?></td>
                            <td><?= $arrayDiscardeds['id'] ?></td>
                        </tr>
                        <?php $accountItem++ ?>
                        <?php $accountLine++ ?>
            <?php else: ?>
                <tr>
                    <td><?= $accountItem ?></td>
                    <td><?= $arrayDiscardeds['reason'] ?></td>
                    <td><?= $arrayDiscardeds['student'] ?></td>
                    <td><?= $arrayDiscardeds['id'] ?></td>
                </tr>
                <?php $accountItem++ ?>
                <?php $accountLine++ ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
    <br />
    <p><b><?= 'Total registros descartados: ' . ($accountItem - 1) ?></b></p>
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
        
        $("#descuentos").table2excel({
    
            exclude: ".noExl",
        
            name: "descuento 20%",
        
            filename: "descuento 20 porciento" 
    
        });
    });
});
</script>