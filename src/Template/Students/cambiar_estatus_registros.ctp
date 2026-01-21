<?php // Tomar la variable estudiantesActualizados pasada desde el controlador ?>
<h3>Cambiar Estatus Registro</h3>
<!-- Mostrar todos los estudiantes actualizados -->
<?php
$contadorFilas = 1;
if (!empty($estudiantesActualizados)): ?>  
    <h4>Registros Actualizados</h4>
    <table border="1">
        <thead>
            <tr>
                <th>Nro.</th>
                <th>ID Estudiante</th>
                <th>Nombre Estudiante</th>
                <th>Mensaje de Actualización</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($estudiantesActualizados as $registro): ?>
                <tr>
                    <td><?= $contadorFilas; ?></td>
                    <td><?= h($registro['id_estudiante']) ?></td>
                    <td><?= h($registro['nombre_estudiante']) ?></td>
                    <td><?= h($registro['mensaje_actualizacion']) ?></td>
                </tr>
                <?php $contadorFilas++; 
            endforeach; ?>
        </tbody>
    </table>
<?php 
endif; ?>