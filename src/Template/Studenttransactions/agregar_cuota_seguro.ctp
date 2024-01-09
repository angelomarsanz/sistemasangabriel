<h3>Agregar Cuota Seguro</h3>
<?php $contador_transacciones = 0; ?>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nro.</th>
                <th>Estudiante</th>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($transacciones_agregadas as $transaccion)
            { 
                $contador_transacciones++; ?>
                <tr>
                    <td><?= $contador_transacciones ?></td>
                    <td><?= $transaccion['estudiante'] ?></td>
                    <td><?= $transaccion['id'] ?></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>