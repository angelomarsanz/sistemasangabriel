<?php
    use Cake\Routing\Router; 
?>
<style type="text/css" media="print">
    .nover {display:none}
</style>
<div id='servicio-educativo'></div>
<div id='periodo-escolar' class='noVerEnPantalla noVerImpreso'><?= $periodoEscolar ?></div>
<div id='ruta-busqueda-familia' class='noVerEnPantalla noVerImpreso'><?= Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?></div>
<div id='ruta-servicio-educativo' class='noVerEnPantalla noVerImpreso'><?= Router::url(array("controller" => "Studenttransactions", "action" => "servicioEducativo")); ?></div>
<br /><br />
<?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-default']) ?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Servicio Educativo</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <?= $this->Form->create() ?>
            <fieldset>
                <?php
                    echo $this->Form->input('reporte_periodo_escolar', ['id' => 'reporte-periodo-escolar', 'label' => 'Emitir reporte de servicio educativo correspondiente al período escolar: ', 'required', 'options' => 
                    [
                        null => "",
                        $periodoEscolarAnterior => $periodoEscolarAnterior,
                        $periodoEscolarActual => $periodoEscolarActual,
                        $periodoEscolarProximo => $periodoEscolarProximo
                    ]]);
                ?>
            </fieldset>   
        <?= $this->Form->end() ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <?= $this->Form->create() ?>
            <fieldset>
                <?php
                    echo $this->Form->input('familia', ['type' => 'text', 'label' => 'Para exonerar un estudiante por favor introduzca los apellidos de la familia']);                
                ?>
            </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php
if ($indicadorBusquedaEstudiantes == 1 && $indicadorActualizacionExoneracion == 0)
{ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h4>Exonerar Servicio Educativo</h4>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Estudiante</th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($estudiantes as $indiceEstudiante => $estudiante)
                { ?>
                    <tr>
                        <td><?= h($estudiante->full_name) ?></td>
                        <td class="actions">
                            <?php 
                            if ($estudiante->exonerado_servicio_educativo > 0)
                            {
                                echo $this->Html->link('Eliminar exoneración', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', $periodoEscolar, $idFamilia, $estudiante->id, 0], ['class' => 'btn btn-sm btn-info', 'id' => $estudiante->id]); 
                            }
                            else
                            {
                                echo $this->Html->link('Exonerar', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', $periodoEscolar, $idFamilia, $estudiante->id, 1], ['class' => 'btn btn-sm btn-info', 'id' => $estudiante->id]); 
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
<?php
}
elseif (isset($periodoEscolar)) 
{ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h4>Estudiantes Exonerados Correspondiente al Período Escolar: <?= $periodoEscolar ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">    
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
                        <?php foreach ($matriculasEstudiantes as $indiceMatricula => $matricula): ?>
                            <tr>
                                <td><?= $contador ?></td>
                                <td><?= h($matricula->student->full_name) ?></td>
                                <td class="actions nover">
                                    <?php 
                                    echo $this->Html->link('Eliminar exoneración', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', $periodoEscolar, $matricula->student->parentsandguardian_id, $matricula->student->id, 0], ['class' => 'btn btn-sm btn-info', 'id' => $matricula->student->id]);
                                    ?> 
                                </td>
                            </tr>
                            <?php $contador++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
} ?>
