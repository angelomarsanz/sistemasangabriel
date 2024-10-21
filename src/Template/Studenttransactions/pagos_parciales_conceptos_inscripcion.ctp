<br>
<h3>Pagos parciales conceptos inscripción</h3>

<table class="table table-striped table-hover">
    <thead>
        <tr> 
            <th>Nro.</td>       
            <th>Estudiante</th>
            <th>Grado</th>
            <th>Estatus</th>
            <th>Nuevo</th>
            <th>Concepto</>
            <th>Abono</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $contador = 1; 
        foreach ($pagosParcialesConceptosInscripcion as $pago): ?>
            <tr>
                <td>
                    <?= $contador ?>
                </td>
                <td>
                    <?= $pago->student->full_name ?>
                </td>
                <td>
                    <?= $pago->student->section->full_name ?>
                </td>
                <td>
                    <?= $pago->student->student_condition ?>
                </td>
                <td>
                    <?= $pago->student->new_student ? 'Sí' : 'No' ?>
                </td>
                <td>
                    <?= $pago->transaction_description ?>
                </td>
                <td>
                    <?= number_format($pago->amount_dollar, 2, ",", ".") ?>
                </td>
            </tr>
        <?php
        $contador++;
        endforeach; ?>
    </tbody>
</table>