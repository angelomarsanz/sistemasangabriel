<?php
    use Cake\Routing\Router; 
?>
<style type="text/css" media="print">
    .nover {display:none}
</style>
<div id='servicio-educativo'></div>
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
                    echo $this->Form->input('periodo_escolar', ['id' => 'periodo-escolar', 'label' => 'Emitir reporte de servicio educativo correspondiente al período escolar: ', 'required', 'options' => 
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
if ($periodoEscolar != null && $periodoEscolar != 0)
{ 
    $cantidadEstudiantesServicioEducativo = 0;
    $totalACobrarServicioEducativo = 0;
    $totalAbonadoServicioEducativo = 0;
    $totalPagadoServicioEducativo = 0;
    $cantidadEstudiantesExoneradoServicioEducativo = 0;
    $totalMontoExoneradoServicioEducativo = 0;
    foreach ($matriculasEstudiantesEncontradas as $indiceMatricula => $matricula)
    {
        if ($matricula->servicio_educativo['codigo_retorno'] == 0)
        {
            $cantidadEstudiantesServicioEducativo++;
            $totalACobrarServicioEducativo += $matricula->servicio_educativo['tarifaCuota'];
            $totalAbonadoServicioEducativo += $matricula->servicio_educativo['montoAbono'];
            if ($matricula->student->servicio_educativo_exonerado > 0)
            {
                $cantidadEstudiantesExoneradoServicioEducativo++;
                $totalMontoExoneradoServicioEducativo += $matricula->servicio_educativo['tarifaCuota'];
            } 
        }
    } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h4>Servicio Educativo Correspondiente al Período Escolar: <?= $periodoEscolar ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= 'Total Alumnos nuevos: '. $cantidadEstudiantesServicioEducativo ?>
        </div>
        <div class="col-md-6">
            <?= 'Total Alumnos exonerados: '. $cantidadEstudiantesExoneradoServicioEducativo ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= 'Total servicio educativo a cobrar: $ '. number_format($totalACobrarServicioEducativo, 2, ",", ".") ?>
        </div>
        <div class="col-md-6">
            <?= 'Total pagado servicio educativo: $ '. number_format($totalAbonadoServicioEducativo, 2, ",", ".") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= 'Total exonerado servicio educativo: $ '. number_format($totalMontoExoneradoServicioEducativo, 2, ",", ".") ?>
        </div>
        <div class="col-md-6">
            <?= 'Pendiente por pagar servicio educativo: $ '. number_format(round($totalACobrarServicioEducativo - $totalAbonadoServicioEducativo - $totalMontoExoneradoServicioEducativo, 2), 2, ",", ".") ?>    
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">    
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nro.</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">ID</th>
                            <th scope="col">Cuota</th>
                            <th scope="col">Abonado</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Exonerado</th>
                            <th scope="col" class="actions nover"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cantidadEstudiantesServicioEducativo = 1; ?>
                        <?php 
                        foreach ($matriculasEstudiantesEncontradas as $indiceMatricula => $matricula):
                            if ($matricula->servicio_educativo['codigo_retorno'] == 0)
                            {
                                $totalACobrarServicioEducativo += $matricula->servicio_educativo['tarifaCuota'];
                                $totalAbonadoServicioEducativo += $matricula->servicio_educativo['montoAbono'];
                                $indicadorExoneracionServicioEducativo = 'No'; 
                                if ($matricula->student->servicio_educativo_exonerado > 0)
                                {
                                    $indicadorExoneracionServicioEducativo = 'Sí';
                                    $cantidadEstudiantesExoneradoServicioEducativo++;
                                    $totalMontoExoneradoServicioEducativo += $matricula->servicio_educativo['tarifaCuota'];
                                } ?>
                                <tr>
                                    <td><?= $cantidadEstudiantesServicioEducativo ?></td>
                                    <td><?= h($matricula->student->full_name) ?></td>
                                    <td><?= h($matricula->student->id) ?></td>
                                    <td><?= h($matricula->servicio_educativo['tarifaCuota']) ?></td>
                                    <td><?= h($matricula->servicio_educativo['montoAbono']) ?></td>
                                    <td><?= h($matricula->servicio_educativo['saldoCuota']) ?></td>
                                    <td><?= h($indicadorExoneracionServicioEducativo) ?></td>
                                    <td class="actions nover">
                                        <?php 
                                        if ($matricula->student->servicio_educativo_exonerado > 0)
                                        {
                                            echo $this->Html->link('Eliminar exoneración', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', 0, 0, $matricula->student->id, 0], ['class' => 'btn btn-sm btn-info', 'id' => $matricula->student->id]); 
                                        }
                                        else
                                        {
                                            echo $this->Html->link('Exonerar', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', 0, 0, $matricula->student->id, 1], ['class' => 'btn btn-sm btn-info', 'id' => $matricula->student->id]); 
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php $cantidadEstudiantesServicioEducativo++ ?>
                                <?php
                            } ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}
elseif ($indicadorBusquedaEstudiantes == 1 && $indicadorActualizacionExoneracion == 0)
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
                    <th scope="col">ID</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Abonado</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Exonerado</th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($estudiantesEncontrados as $indiceEstudiante => $estudiante)
                { 
                    if ($estudiante->servicio_educativo['codigo_retorno'] == 0)
                    {                         
                        $indicadorExoneracionServicioEducativo = 'No'; 
                        if ($estudiante->servicio_educativo_exonerado > 0)
                        {
                            $indicadorExoneracionServicioEducativo = 'Sí';
                        } ?>
                        <tr>
                            <td><?= h($estudiante->full_name) ?></td>
                            <td><?= h($estudiante->id) ?></td>
                            <td><?= h($estudiante->servicio_educativo['tarifaCuota']) ?></td>
                            <td><?= h($estudiante->servicio_educativo['montoAbono']) ?></td>
                            <td><?= h($estudiante->servicio_educativo['saldoCuota']) ?></td>
                            <td><?= h($indicadorExoneracionServicioEducativo) ?></td>
                            <td class="actions">
                                <?php 
                                if ($estudiante->servicio_educativo_exonerado > 0)
                                {
                                    echo $this->Html->link('Eliminar exoneración', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', 0, 0, $estudiante->id, 0], ['class' => 'btn btn-sm btn-info', 'id' => $estudiante->id]); 
                                }
                                else
                                {
                                    echo $this->Html->link('Exonerar', ['controller' => 'Studenttransactions', 'action' => 'servicioEducativo', 0, 0, $estudiante->id, 1], ['class' => 'btn btn-sm btn-info', 'id' => $estudiante->id]); 
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                } ?>
            </tbody>
        </table>
    </div>
<?php
} 