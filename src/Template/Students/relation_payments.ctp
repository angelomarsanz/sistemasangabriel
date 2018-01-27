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
<br />
<br />
<div>
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Año Unidad Educativa Colegio</td>
                <td>Grado: <?= $nameSection->sublevel ?></td>
            </tr>
            <tr>
                <td><b>"San Gabriel Arcángel"</b></td>
                <td>Sección: <?= $nameSection->section ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br />
<div style="width: 100%; text-align: center;">
    <h4>Relación de Mensualidades</h4>
</div>
<hr size="4" />
<div>
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:5%; text-align:center;">Nro.</th>
                <th style="width:30%; text-align:left;">Alumno</th>
                <th style="width:5%; text-align:center;">Sep</th>
                <th style="width:5%; text-align:center;">Oct</th>
                <th style="width:5%; text-align:center;">Nov</th>
                <th style="width:5%; text-align:center;">Dic</th>
                <th style="width:5%; text-align:center;">Ene</th>
                <th style="width:5%; text-align:center;">Feb</th>
                <th style="width:5%; text-align:center;">Mar</th>
                <th style="width:5%; text-align:center;">Abr</th>
                <th style="width:5%; text-align:center;">May</th>
                <th style="width:5%; text-align:center;">Jun</th>
                <th style="width:5%; text-align:center;">Jul</th>
            </tr>
        </thead>
        <tbody>
            <?php $accountStudent = 1; ?>
            <?php foreach ($monthlyPayments as $monthlyPayment): ?>
                <tr>
                    <td style="text-align:center;"><?= $accountStudent ?></td>
                    <td><?= h($monthlyPayment['student']) ?></td>
                    <?php foreach (($monthlyPayment['studentTransactions']) as $studentTransaction): ?>
                        <td style="text-align:center;"><?= h($studentTransaction['monthlyPayment']) ?></td>
                    <?php endforeach; ?>
                </tr>  
                <?php $accountStudent++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>  
    <hr size="4" />
    <p>Leyenda: * = Cancelado, * = Pendiente y B = Becado</p>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="../../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
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
});
</script>