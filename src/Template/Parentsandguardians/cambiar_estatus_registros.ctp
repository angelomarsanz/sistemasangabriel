<h3>Cambiar Estatus Registro</h3>
<!-- Mostrar todos los representantes actualizados -->
<?php
$contadorFilas = 1;
if (!empty($representantesActualizados)): ?>  
    <h4>Registros Actualizados</h4>
    <table border="1">
        <thead>
            <tr>
                <th>Nro.</th>                
                <th>ID Representante</th>
                <th>Nombre Representante</th>
                <th>ID Usuario</th>
                <th>Nombre Usuario</th>
                <th>Mensaje de Actualización</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($representantesActualizados as $registro): ?>
                <tr>
                    <td><?= $contadorFilas++; ?></td>
                    <td><?= h($registro['id_representante']) ?></td>
                    <td><?= h($registro['nombre_representante']) ?></td>
                    <td><?= h($registro['id_usuario']) ?></td>
                    <td><?= h($registro['nombre_usuario']) ?></td>
                    <td><?= h($registro['mensaje_actualizacion']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?> 