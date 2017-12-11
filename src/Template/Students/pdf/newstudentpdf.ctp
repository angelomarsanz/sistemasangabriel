<style>
table, th, td {
    border-bottom: 1px solid black;
}
th, td {
    padding: 5px;
    text-align: left;
}
</style>
<div>
    <h4>Unidad Educativa Colegio</h4>
    <h4>"San Gabriel Arcángel"</h4>
</div>
<div style="width: 100%; text-align: center;">
    <h4>Relación de Pagos de Nuevos Alumnos al <?= $currentDate->format('d-m-Y') ?></h4>
</div>
<hr size="4" />
<div style="font-size: 23px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width: 25%;">Nivel de estudio</th>
                <th style="width: 25%;">Apellidos y nombres</th>
                <th style="width: 5%;">id</th>  
                <th style="width: 20%;">Cuota</th>
                <th style="width: 15%; text-align: right;">Pagado</th>
                <th style="width: 15%; text-align: right;">Por pagar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newStudents as $newStudent): ?>
                <tr>
                    <td><?= h($newStudent['levelOfStudy']) ?></td>
                    <td><?= h($newStudent['nameStudent']) ?></td>
                    <td><?= h($newStudent['id']) ?></td>
                    <td><?= h($newStudent['transactionDescription']) ?></td>
                    <td style="text-align: right;"><?= number_format($newStudent['paidOut'], 2, ",", ".") ?></td>
                    <td style="text-align: right;"><?= number_format($newStudent['toPay'], 2, ",", ".") ?></td>
                </tr>                    
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><b>Totales: </b></td>
                <td style=" text-align: right;"><b><?= number_format($totalPaid, 2, ",", ".") ?></b></td>
                <td style=" text-align: right;"><b><?= number_format($totalPayable, 2, ",", ".") ?></b></td>
            </tr>
        </tfoot>
    </table>  
</div>