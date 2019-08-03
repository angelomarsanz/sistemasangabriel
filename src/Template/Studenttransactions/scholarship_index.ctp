<style type="text/css" media="print">
    .nover {display:none}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
			<h3>Reporte de alumnos becados</h3>
            <p class="nover"><?= $this->Html->link(__('Becar otro alumno'), ['controller' => 'Students', 'action' => 'searchScholarship'], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>Nro.</tr>
                        <th scope="col">Alumno</th>
                        <th scope="col" class="actions nover"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
					<?php $contador = 1; ?>
                    <?php foreach ($studenttransactions as $studenttransaction): ?>
                    <tr>
						<td><?= $contador ?></td>
                        <td><?= h($studenttransaction->student->full_name) ?></td>
                        <td class="actions nover">
                            <?= $this->Html->link('Eliminar beca', ['controller' => 'Students', 'action' => 'deleteScholarship', $studenttransaction->student->id], ['class' => 'btn btn-sm btn-info', 'id' => $studenttransaction->student->id]) ?>
                        </td>
                    </tr>
					<?php $contador++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="paginator nover">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Anterior') ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next('Siguiente >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div> -->
    </div>
</div>