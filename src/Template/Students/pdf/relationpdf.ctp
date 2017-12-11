<div>
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Unidad Educativa Colegio</td>
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
<div style="font-size: 20px;">
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