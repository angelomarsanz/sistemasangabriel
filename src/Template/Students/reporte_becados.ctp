<style type="text/css" media="print">
    .nover {display:none}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
			<h3>Reporte de becados: Becas completas, por hijo y especiales</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>Nro.</th>
                        <th scope="col">Alumno</th>
						<th scope="col">Tipo beca</th>
						<th scope="col" style="text-align: center;">Porcentaje descuento</th>
                    </tr>
                </thead>
                <tbody>
					<?php 
						$contador = 1;
						$contadorBecaCompleta = 0;
						$contadorBecaHijos = 0;
						$contadorBecaEspecial = 0;
					?>
                    <?php foreach ($becados as $becado): ?>
						<tr>
							<td><?= $contador ?></td>
							<td><?= h($becado->full_name) ?></td>
							<?php if ($becado->scholarship == true): ?>
								<td>Completa</td>
								<td style="text-align: center;">100</td>
							<?php else: ?>
								<td><?= h($becado->tipo_descuento) ?></td>
								<td style="text-align: center;"><?= h($becado->discount) ?></td>
							<?php endif; ?>
						</tr>
						<?php $contador++;
						if ($becado->scholarship == true):
							$contadorBecaCompleta++;
						else:
							if ($becado->tipo_descuento == "Hijos"): 
								$contadorBecaHijos++;
							else:
								$contadorBecaEspecial++;
							endif;
						endif;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
		<?php echo "<br />Total alumnos con beca completa: " . $contadorBecaCompleta;
		echo "<br />Total alumnos con beca por hijos: " . $contadorBecaHijos;
		echo "<br />Total alumnos con beca especial: " . $contadorBecaEspecial; ?>
    </div>
</div>