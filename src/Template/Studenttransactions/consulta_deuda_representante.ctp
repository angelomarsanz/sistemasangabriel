<?php
    use Cake\Routing\Router; 
?>
<?php 
$idEstudiante = isset($idEstudiante) ? $idEstudiante : null;
$periodoEscolar = isset($periodoEscolar) ? $periodoEscolar : null;
$controlador = isset($controlador) ? $controlador : null;
$accion = isset($accion) ? $accion : null;
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
            <input type='hidden' name='id_usuario' id='id-usuario' value=<?= $idUsuario ?>>
            <input type='hidden' name='rol_usuario' id='rol-usuario' value=<?= $rolUsuario ?>>
            <input type='hidden' name='id_representante' id='id-representante' value=<?= $idRepresentante ?>>
            <input type='hidden' name='id_estudiante' id='id-estudiante' value=<?= $idEstudiante ?>>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <label for="estudiante">Escriba el primer apellido del alumno</label>
                <br />
                <input type="text" class="form-control" name="estudiante" id="estudiante" value='<?= isset($estudiante) ? $estudiante : ''; ?>'>
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
    <h4>Deuda a la fecha: <?= number_format($totalDeudaEstudiante, 2, ",", ".") ?></h4>
    <h4>Cuotas del período escolar : <?= $periodoEscolar.'-'.($periodoEscolar + 1) ?></h4>
    <?php
    if (isset($contadorCuotasRegistradas)):
        if ($contadorCuotasRegistradas > 0): ?> 
            <?= $this->Form->create() ?>
                <fieldset>
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
                                foreach ($vectorTransacciones as $transaccion): ?> 
                                    <tr>
                                        <td class='noVerEnPantalla' style='text-align: center;'>
                                            <?= $transaccion['id'] ?>
                                        </td>
                                        <td style='text-align: left;'>
                                            <?= $transaccion['cuota'] ?>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_'.$contador ?> name='amount[<?= $contador ?>]' value=<?= $transaccion['tarifaCuota'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_dollar_'.$contador ?> name='amount_dollar[<?= $contador ?>]' value=<?= $transaccion['montoAbonado'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'pendiente_dollar_'.$contador ?> name='pendiente_dollar[<?= $contador ?>]' value=<?= $transaccion['pendienteCuota'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'porcentaje_descuento_'.$contador ?> name='porcentaje_descuento[<?= $contador ?>]' value=<?= $transaccion['porcentajeDescuento'] ?> step='0.01' class='form-control' disabled>
                                        </td>
                                    </tr>
                                    <?php
                                    $contador++;
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