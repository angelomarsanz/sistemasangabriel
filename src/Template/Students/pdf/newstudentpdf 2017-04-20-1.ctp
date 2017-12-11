<div>
    <table style="width:100%">
        <tbody>
            <tr>
                <td>Unidad Educativa Colegio</td>
            </tr>
            <tr>
                <td><b>"San Gabriel Arcángel"</b></td>
            </tr>
        </tbody>
    </table>
</div>
<br />
<div style="width: 100%; text-align: center;">
    <h4>Relación de Pagos Nuevos estudiantes</h4>
</div>
<hr size="4" />
<div style="font-size: 20px;">
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:40%; text-align:center;">Nivel de estudio</th>
                <th style="width:30%; text-align:left;">Nombres y apellidos</th>
                <th style="width:10%; text-align:center;">Cuota</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newStudents as $newStudent): ?>
                <tr>
                    <td><?= h($newStudent['levelOfStudy']) ?></td>
                    <td><?= h($newStudent['nameStudent']) ?></td>
                    <?php foreach (($newStudent['studentTransactions']) as $studentTransaction): ?>
                        <td><?= h($studentTransaction['paidOut']) ?></td>
                    <?php endforeach; ?>
                </tr>                    
            <?php endforeach; ?>
        </tbody>
    </table>  
</div>