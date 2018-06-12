<?php if ($varError == 0): ?> 
	<p>Estimado usuario:</p>
	<p>Le informamos que se actualizó exitosamente el monto de la diferencia de agosto <?= $varYear ?> arrojando el siguiente resultado:</p>
	<p>- Total alumnos a los que se les actualizó el monto de diferencia de agosto: <?= $varAdjust ?></p>
<?php else: ?>
	<p>Estimado usuario el proceso de actualizar el monto de la diferencia de agosto <?= $varYear ?> no se ejecutó satisfactoriamente, por favor informar al personal de sistemas</>
<?php endif; ?>