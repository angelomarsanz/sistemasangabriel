<h3></h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>&nbsp;</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $contador = 0; 
        foreach ($transacciones as $transaccion):
            $contador++; ?>
            <tr>
                <td><?= $transaccion->student->id ?></td>
                <td>&nbsp;</td>
                <td><?= $transaccion->student->full_name ?></td>
            </tr>
        <?php 
        endforeach; ?>
    </tbody>
</table>