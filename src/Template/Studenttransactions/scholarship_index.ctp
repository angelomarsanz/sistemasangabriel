<style type="text/css" media="print">
    .nover {display:none}
</style>
<?php
if (isset($periodo_escolar)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>Reporte de alumnos becados 100% correspondientes al período escolar: <?= $periodo_escolar ?></h3>
                <p class="nover">
                    <?= $this->Html->link(__('Becar otro alumno'), ['controller' => 'Students', 'action' => 'searchScholarship'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nro.</th>
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
            <br />
            <p class="nover">
                <?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-default']) ?>
            </p>
        </div>
    </div>
<?php
else: ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="page-header">
                <h3>Reporte de alumnos becados 100%</h3>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <?= $this->Form->create() ?>
                        <fieldset>
                            <?php
                                echo $this->Form->input('periodo_escolar', ['id' => 'periodo-escolar', 'label' => 'Período escolar: ', 'required', 'options' => 
                                [
                                    null => "",
                                    $periodo_escolar_anterior => $periodo_escolar_anterior,
                                    $periodo_escolar_actual => $periodo_escolar_actual,
                                    $periodo_escolar_proximo => $periodo_escolar_proximo
                                ]]);
                            ?>
                        </fieldset>   
                        <?= $this->Form->button(__('Generar'), ['class' =>'btn btn-success']) ?>
                        <?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-default']) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
<?php
endif; ?>