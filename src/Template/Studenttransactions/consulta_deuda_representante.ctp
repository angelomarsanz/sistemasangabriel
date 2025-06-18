<?php
    use Cake\Routing\Router; 
?>
<?php 
$idEstudiante = isset($idEstudiante) ? $idEstudiante : null;
$controlador = isset($controlador) ? $controlador : null;
$accion = isset($accion) ? $accion : null;
?>
<div id='consulta-deuda-representante'></div>
<div id='vector-estudiantes' class='noVerEnPantalla noVerImpreso'><?php echo json_encode($vectorEstudiantes); ?></div>
<div id='id-usuario' class='noVerEnPantalla noVerImpreso'><?= $idUsuario ?></div>
<div id='rol-usuario' class='noVerEnPantalla noVerImpreso'><?= $rolUsuario ?></div>
<div id='ruta-busqueda-familia' class='noVerEnPantalla noVerImpreso'><?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findFamily")); ?></div>
<div id='ruta-busqueda-representante' class='noVerEnPantalla noVerImpreso'><?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "findGuardian")); ?></div>
<div id='ruta-consulta-deuda-representante' class='noVerEnPantalla noVerImpreso'><?php echo Router::url(array("controller" => "Studenttransactions", "action" => "consultaDeudaRepresentante")); ?></div>
<div id='ruta-busqueda-estudiantes-representante' class='noVerEnPantalla noVerImpreso'><?php echo Router::url(array("controller" => "Students", "action" => "buscarEstudiantesRepresentante", $idRepresentante)); ?></div>
<div class="row noVerImpreso">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="page-header">
            <h3>Consultar Deuda</h3>
            <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion.'/'.$idUsuario.'/'.$rolUsuario.'/'.$idRepresentante.'/'.$idEstudiante], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
    </div>
</div>
<?php
if ($rolUsuario != 'Representante')
{ ?>
    <div class="row noVerImpreso">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <label for="familia">Escriba los apellidos que identifican la familia:</label>
            <br />
            <input type="text" class="form-control" id="familia">
            <br />
            <label for="representante">Si desconoce los apellidos de la familia, entonces escriba el primer apellido del representante:</label>
            <br />
            <input type="text" class="form-control" id="representante">
            <br />
        </div>
    </div>
<?php
} 
if ($rolUsuario != 'Representante' && $idRepresentante > 0)
{ ?>
    <h4><?= 'Familia: '.$representante->family ?></h4>
    <h5><?= 'Representante: '.$representante->full_name ?></h5>
<?php
} ?> 
<h3><br>Total deuda de la familia $(USD): &nbsp;&nbsp;<?= number_format($totalDeudaRepresentante, 2, ",", ".") ?><br/></h3>
<hr />
<h5>Estudiantes:</h5>
<?php
$contadorEstudiantes = 0;
$etiquetaNombre = '';
$etiquetaPeriodoEscolar = '';
$etiquetaDeudaTotalEstudianteAnio = '';

foreach ($vectorEstudiantes as $indiceEstudiante => $estudiante)
{ 
    $ultimoAnioInscripcionEstudiante = $estudiante['ultimo_anio_inscripcion_estudiante']; 
    if ($contadorEstudiantes == 0)
    { 
        $etiquetaNombre = 'Nombre:';
        $etiquetaPeriodoEscolar = 'Período escolar:';
        $etiquetaDeudaTotalEstudianteAnio = 'Deuda:';
    }
    else
    {
        $etiquetaNombre = ' ';                
        $etiquetaPeriodoEscolar = ' ';
        $etiquetaDeudaTotalEstudianteAnio = ' ';
    } 
    $contadorEstudiantes++;
    ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <label for="estudiante"><?= $etiquetaNombre ?></label>
            <input type="text" class="form-control" name="estudiante" id="estudiante" value="<?= $estudiante['nombre_estudiante'] ?>" disabled>    
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <?php
            echo $this->Form->input('periodo_escolar['.$indiceEstudiante.']', ['class' => 'periodo-escolar', 'label' => $etiquetaPeriodoEscolar, 'value' => $ultimoAnioInscripcionEstudiante, 'options' => 
                [
                    '2023' => '2023-2024',
                    '2024' => '2024-2025',
                    '2025' => '2025-2026',
                ]]); ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <label for="total-deuda-estudiante-anio"><?= $etiquetaDeudaTotalEstudianteAnio ?></label>
            <input type="text" class="form-control" name="total_deuda_estudiante_anio" id="<?= 'total-deuda-estudiante-anio-'.$indiceEstudiante ?>" value="<?= $estudiante['anios'][$ultimoAnioInscripcionEstudiante]['total_deuda_estudiante_anio'] ?>" disabled>    
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 noVerImpreso" style='margin-top: 2.2rem'>
            <button id="<?= 'ver-detalle-'.$indiceEstudiante ?>" class="btn btn-success ver-detalle" >Ver detalle</button>
        </div>
        <input type='hidden' id='<?= 'indicador-detalle-'.$indiceEstudiante ?>' name='<?= 'indicador_detalle-'.$indiceEstudiante ?>' value='0'>
    </div>
    <div id='<?= 'detalle-cuotas-'.$indiceEstudiante ?>'></div>
    <?php
    foreach ($estudiante['anios'] as $indiceAnio => $anio)
    { 
        $inicioPeriodoEscolarDetalle = $indiceAnio; 
        $finPeriodoEscolarDetalle = $indiceAnio + 1; ?>
        <div id="<?= 'cuotas-'.$indiceEstudiante.'-'.$indiceAnio ?>" class='row noVerEnPantalla noVerImpreso'>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                if ($rolUsuario == 'Representante')
                { ?>
                    <h4>Inscripción <?= $inicioPeriodoEscolarDetalle.'-'.$finPeriodoEscolarDetalle ?></h4>
                    <div class="flex-container">
                        <?php
                        foreach ($anio['cuotas_anio_escolar'] as $indiceCuota => $cuota)
                        { 
                            if ($cuota['tipoCuota'] == 'Anticipo matrícula' || $cuota['tipoCuota'] == 'Diferencia matrícula' || 
                                $cuota['tipoCuota'] == 'Abono agosto' || $cuota['tipoCuota'] == 'Diferencia agosto')
                            {
                                $idCuota = 'cuota-'.$cuota['id'];
                                $nombreCuota = 'cuota_'.$cuota['id']; 
                                $indicadorCuotaVencida = $cuota['indicadorCuotaVencida']; ?>
                                <div>
                                    <?php
                                        if ($indicadorCuotaVencida == 1)
                                        { ?>
                                            <label for="<?= $idCuota ?>"><?= $cuota['cuota'] ?></label>
                                            <input type="number" id="<?= $idCuota ?>" name="<?= $nombreCuota ?>]" value=<?= $cuota['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        <?php
                                        }
                                        else 
                                        { ?>
                                            <label for="<?= $idCuota ?>" style='color: #a4a4c1;' ><?= $cuota['cuota'] ?></label>
                                            <input type="number" id="<?= $idCuota ?>" name="<?= $nombreCuota ?>]" style='color: #a4a4c1;' value=<?= $cuota['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        <?php
                                        } ?>
                                </div>
                            <?php
                            }
                        } ?> 
                    </div>
                    <hr />
                    <h4>Detalle de las cuotas del período escolar <?= $inicioPeriodoEscolarDetalle.'-'.$finPeriodoEscolarDetalle.' (Mensualidad)' ?></h4>
                    <div class="flex-container">
                        <?php
                        foreach ($anio['cuotas_anio_escolar'] as $indiceCuota => $cuota)
                        { 
                            if ($cuota['tipoCuota'] != 'Anticipo matrícula' && $cuota['tipoCuota'] != 'Diferencia matrícula' && 
                            $cuota['tipoCuota'] != 'Abono agosto' && $cuota['tipoCuota'] != 'Diferencia agosto')
                            {
                                $idCuota = 'cuota-'.$cuota['id'];
                                $nombreCuota = 'cuota_'.$cuota['id']; 
                                $indicadorCuotaVencida = $cuota['indicadorCuotaVencida']; ?>
                                <div>
                                    <?php
                                        if ($indicadorCuotaVencida == 1)
                                        { ?>
                                            <label for="<?= $idCuota ?>"><?= $cuota['cuota'] ?></label>
                                            <input type="number" id="<?= $idCuota ?>" name="<?= $nombreCuota ?>]" value=<?= $cuota['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        <?php
                                        }
                                        else 
                                        { ?>
                                            <label for="<?= $idCuota ?>" style='color: #a4a4c1;' ><?= $cuota['cuota'] ?></label>
                                            <input type="number" id="<?= $idCuota ?>" name="<?= $nombreCuota ?>]" style='color: #a4a4c1;' value=<?= $cuota['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        <?php
                                        } ?>
                                </div>
                            <?php
                            }
                        } ?> 
                    </div>
                <?php
                }
                else
                { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>        
                                    <th class='noVerEnPantalla' style='text-align: center;'>id</th>
                                    <th style='text-align: center;'>Cuota</th>
                                    <th style='text-align: center;'>Monto Cuota $</th>
                                    <th style='text-align: center;'>Monto Abonado $</th>
                                    <th style='text-align: center;'>Por pagar $</th>
                                    <th style='text-align: center;'>Porcentaje Descuento %</th>
                                    <th><th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $contador = 1;
                                foreach ($anio['cuotas_anio_escolar'] as $indiceCuota => $cuota)
                                { ?> 
                                    <tr>
                                        <td class='noVerEnPantalla' style='text-align: center;'>
                                            <?= $cuota['id'] ?>
                                        </td>
                                        <td style='text-align: left;'>
                                            <?= $cuota['cuota'] ?>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_'.$contador ?> name='amount[<?= $contador ?>]' value=<?= $cuota['tarifaCuota'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_dollar_'.$contador ?> name='amount_dollar[<?= $contador ?>]' value=<?= $cuota['montoAbonado'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'pendiente_dollar_'.$contador ?> name='pendiente_dollar[<?= $contador ?>]' value=<?= $cuota['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'porcentaje_descuento_'.$contador ?> name='porcentaje_descuento[<?= $contador ?>]' value=<?= $cuota['porcentajeDescuento'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                    </tr>
                                    <?php
                                    $contador++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    <?php
    }
} ?>
<br />
<?php // debug($vectorEstudiantes); ?>