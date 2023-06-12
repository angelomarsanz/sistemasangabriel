<h3>testFunction</h3>

<?php
if ($transaccion->respaldo_registro === null)
{
    echo "<br />El campo tiene valor null";
}
else
{
    $transaccion_objeto = json_decode($transaccion, true);
    echo "<br />El campo tiene el valor<br />"; ?>
    <pre>
        <?php var_dump($transaccion_objeto) ?>
    </pre>
    <br />
    <?php
    debug($transaccion_objeto); 
} ?>


<!-- <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>&nbsp;</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php      
        /*$contador = 0; 
        foreach ($transacciones as $transaccion):
            $contador++; */ ?>
            <tr>
                <td><?php // echo $transaccion->student->id ?></td>
                <td>&nbsp;</td>
                <td><?php // echo $transaccion->student->full_name ?></td>
            </tr>
        <?php 
        // endforeach; ?>
    </tbody>
</table> -->