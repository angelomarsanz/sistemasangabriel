<br>
<h3>Alumnos de 5to. Año, período escolar anterior (2023-2024)</h3>

<table class="table table-striped table-hover">
    <thead>
        <tr> 
            <th>Nro.</td>       
            <th>Estudiante</th>
            <th>Grado</th>
            <th>Estatus</th>
            <th>Beca %</th>
            <th>Cancelado</>
            <th>Pago julio 2024</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $contador = 1; 
        foreach ($transacciones as $transaccion): ?>
            <tr>
                <td>
                    <?= $contador ?>
                </td>
                <td>
                    <?= $transaccion->student->full_name ?>
                </td>
                <td>
                    <?= $transaccion->student->section->full_name ?>
                </td>
                <td>
                    <?= $transaccion->student->student_condition ?>
                </td>
                <td>
                    <?= $transaccion->student->descuento_ano_anterior ?>
                </td>
                <td>
                    <?= $transaccion->paid_out ? 'Sí' : 'No' ?>
                </td>
                <td>
                    <?= number_format($transaccion->amount_dollar, 2, ",", ".") ?>
                </td>
            </tr>
        <?php
        $contador++;
        endforeach; ?>
    </tbody>
</table>