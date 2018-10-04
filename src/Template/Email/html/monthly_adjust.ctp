<?php if ($varError == 0): ?> 
	<p>Estimado usuario:</p>
	<p>Le informamos que ya se ajustaron las mensualidades del colegio en el sistema San Gabriel Arcángel, arrojando los siguientes resultados:</p>
	<p>- Total cuotas ajustadas: <?= $varAdjust ?></p>
	<p>- Total alumnos a los que no se les ajustó la mensualidad porque ya han pagado el año escolar completo: <?= $varNotAdjust ?></p>
	<p>- Total alumnos morosos a los que se les ajustó las mensualidades: <?= $varAdjustDefaulters ?></p>
<?php else: ?>
	<p>Estimado usuario el proceso de ajustar mensualidades no se ejecutó satisfactoriamente, por favor informar al personal de sistemas</>
<?php endif; ?>