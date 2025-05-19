<?php
    use Cake\Routing\Router; 
?>
<?php 
$controlador = isset($controlador) ? $controlador : null;
$accion = isset($accion) ? $accion : null;
$idEstudiante = isset($idEstudiante) ? $idEstudiante : null;
$periodoEscolar = isset($periodoEscolar) ? $periodoEscolar : null;
?>
<div id='consulta-deuda-representante'></div>
<?php 
if ($idRepresentante > 0): ?>
    <div id='ruta-programa' class='noVerEnPantalla'><?php echo Router::url(array("controller" => "Students", "action" => "buscarEstudiantesRepresentante", $idRepresentante)); ?></div>
<?php
else: ?>
    <div id='ruta-programa' class='noVerEnPantalla'><?php echo Router::url(array("controller" => "Students", "action" => "findStudent")); ?></div>
<?php
endif; ?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="page-header">
            <h3>Consultar Deuda</h3>
            <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion.'/'.$idUsuario.'/'.$rolUsuario.'/'.$idRepresentante.'/'.$idEstudiante], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
    </div>
</div>
<?= $this->Form->create() ?>
    <fieldset>
        <div class='row'>
            <input type='hidden' name='id_estudiante' id='id_estudiante' value=<?= $idEstudiante ?>>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <label for="estudiante">Escriba el primer apellido del alumno</label>
                <br />
                <input type="text" class="form-control" name="estudiante" id="estudiante" value='<?= isset($estudiante) ? $estudiante : '' ?>'>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php
                echo $this->Form->input('periodo_escolar', ['label' => 'Período escolar: ', 'value' => $periodoEscolar, 'options' => 
                    [
                        '2023' => '2023-2024',
                        '2024' => '2024-2025',
                        '2025' => '2025-2026',
                    ]]); ?>
            </div>
        </div>
    </fieldset>
    <div class='row'>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <?= $this->Form->button(__('Consulta'), ['class' =>'btn btn-success']) ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php 
if (isset($estudiante)): ?>
    <h3><?= $estudiante ?></h3>
    <h4>Cuotas del período escolar : <?= $periodoEscolar.'-'.($periodoEscolar + 1) ?></h4>
    <?php
    if (isset($contadorTransacciones)):
        if ($contadorTransacciones > 0): ?> 
            <?= $this->Form->create() ?>
                <fieldset>
                    <input type='hidden' name='id_estudiante' value=<?= $idEstudiante ?>>
                    <input type='hidden' name='estudiante' value='<?= $estudiante ?>'>
                    <input type='hidden' name='periodo_escolar' value=<?= $periodoEscolar ?>>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>        
                                    <th style='text-align: center;'>id</th>
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
                                foreach ($transaccionesEstudiante as $transaccion): 
                                    $mostrarCuota = 0;
                                    $porcentajeDescuento = 0;
                                    $porcentajeDescuentoDecimal = 0;
                                    $anioMesTransaccion = '';
                                    $tarifaCuota = 0;
                                    $diferenciaOriginalMonto = 0;
                                    if ($rolUsuario == 'Representante'):
                                        if ($transaccion->transaction_type == 'Matrícula' || $transaccion->transaction_type == 'Mensualidad'):
                                            $mostrarCuota = 1; 
                                        endif;
                                    else: 
                                        $mostrarCuota = 1;
                                    endif; 
                                    if ($transaccion->transaction_type == 'Mensualidad' && substr($transaccion->transaction_description, 0, 3) != 'Ago'):
                                        $anioMesTransaccion = substr($transaccion->payment_date, 0, 4).substr($transaccion->payment_date, 5, 2);
                                        foreach ($mesesTarifas as $indice => $mesTarifa):
                                            if ($anioMesTransaccion == $mesTarifa['anoMes']):
                                                $tarifaCuota = $mesTarifa['tarifaDolar'];
                                                break;
                                            endif;
                                        endforeach;    
                                        $diferenciaOriginalMonto = round($transaccion->original_amount - $transaccion->amount, 2);
                                        if ($diferenciaOriginalMonto > 0):
                                            $tarifaCuota = round($tarifaCuota - $diferenciaOriginalMonto, 2);
                                        endif;
                                        if ($transaccion->paid_out == 1): 
                                            $porcentajeDescuento = $transaccion->porcentaje_descuento;
                                        else:
                                            if ($transaccion->ano_escolar < $anioEscolarActual):
                                                $porcentajeDescuento = $registroEstudiante->descuento_ano_anterior;
                                            elseif ($transaccion->ano_escolar == $anioEscolarActual):
                                                $porcentajeDescuento = $registroEstudiante->discount;
                                            else:
                                                $porcentajeDescuento = 0;
                                            endif;
                                        endif;
                                        if ($porcentajeDescuento == 0):
                                            $porcentajeDescuentoDecimal = 1;
                                        else:
                                            $porcentajeDescuentoDecimal = round((100 - $porcentajeDescuento)/100, 2);
                                        endif;
                                        $tarifaCuota = round($tarifaCuota * $porcentajeDescuentoDecimal, 2);
                                    else:
                                        if (substr($transaccion->transaction_description, 0, 18) == 'Servicio educativo'):
                                            $tarifaCuota = $transaccion->amount;
                                        else:
                                            foreach ($otrasTarifas as $indice => $otraTarifa):
                                                if ($transaccion->transaction_description == $otraTarifa['conceptoAno']):
                                                    $tarifaCuota = $otraTarifa['tarifaDolar'];
                                                    break;
                                                endif;
                                            endforeach;
                                        endif;
                                        $diferenciaOriginalMonto = round($transaccion->original_amount - $transaccion->amount, 2);
                                        if ($diferenciaOriginalMonto > 0):
                                            $tarifaCuota = round($tarifaCuota - $diferenciaOriginalMonto, 2);
                                        endif;
                                    endif;
                                    if ($mostrarCuota == 1): ?>
                                        <tr>
                                            <td style='text-align: center;'>
                                                <?= $transaccion->id ?>
                                            </td>
                                            <td style='text-align: left;'>
                                                <?= $transaccion->transaction_description ?>
                                            </td>
                                            <td style='text-align: center;'>
                                                <input type="number" id=<?= 'amount_'.$contador ?> name='amount[<?= $contador ?>]' value=<?= $tarifaCuota ?> step='0.01' class='form-control' disabled>
                                            </td>
                                            <td style='text-align: center;'>
                                                <input type="number" id=<?= 'amount_dollar_'.$contador ?> name='amount_dollar[<?= $contador ?>]' value=<?= $transaccion->amount_dollar ?> step='0.01' class='form-control' disabled>
                                            </td>
                                            <td style='text-align: center;'>
                                                <input type="number" id=<?= 'pendiente_dollar_'.$contador ?> name='pendiente_dollar[<?= $contador ?>]' value=<?= round($tarifaCuota - $transaccion->amount_dollar, 2) ?> step='0.01' class='form-control' disabled>
                                            </td>
                                            <td style='text-align: center;'>
                                                <input type="number" id=<?= 'porcentaje_descuento_'.$contador ?> name='porcentaje_descuento[<?= $contador ?>]' value=<?= $porcentajeDescuento ?> step='0.01' class='form-control' disabled>
                                            </td>
                                        </tr>
                                        <?php
                                        $contador++;
                                    endif; 
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            <?= $this->Form->end() ?>
        <?php
        else: ?>
            <p>No se encontraron cuotas para el estudiante</p>
        <?php
        endif;
    endif; ?>
<?php
endif; ?>