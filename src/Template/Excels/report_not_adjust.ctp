<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Alumnos a los que no se les ajustó la mensualidad porque pagaron el año escolar completo</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Alumno</th>
                    </tr>
                </thead>
                <tbody>
					<?php $accountStudent = 1; ?>
                    <?php foreach ($notAdjust as $notAdjusts): ?>
						<tr>
							<td><?= $accountStudent ?></td>
							<td><?= h($notAdjusts->col2) ?></td>
						</tr>
						<?php $accountStudent++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>