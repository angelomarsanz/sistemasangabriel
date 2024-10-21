<?php
    use Cake\Routing\Router; 
?>
<?php 
$controlador = isset($controlador) ? $controlador : null;
$accion = isset($accion) ? $accion : null;
$idEstudiante = isset($idEstudiante) ? $idEstudiante : null;
$periodoEscolar = isset($periodoEscolar) ? $periodoEscolar : null;
$estatusCuotas = isset($estatusCuotas) ? $estatusCuotas : 0;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="page-header">
            <h3>Cuotas del Estudiante: </h3>
            <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion.'/'.$idEstudiante], ['class' => 'btn btn-sm btn-default']) ?></p>
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
                        '2016' => '2016-2017',
                        '2017' => '2017-2018',
                        '2018' => '2018-2019',
                        '2019' => '2019-2020',
                        '2020' => '2020-2021',
                        '2021' => '2021-2022',
                        '2022' => '2022-2023',
                        '2023' => '2023-2024',
                        '2024' => '2024-2025',
                        '2025' => '2025-2026',
                        '2026' => '2026-2027',
                        '2027' => '2027-2028',
                        '2028' => '2028-2029',
                        '2029' => '2029-2030'
                    ]]); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php
                echo $this->Form->input('estatus_cuotas', ['label' => 'Estatus de la cuota: ', 'value' => $estatusCuotas, 'options' => 
                    [
                        false => 'Activa',
                        true => 'Eliminada'
                    ]]); ?>
            </div>
        </div>
    </fieldset>
    <div class='row'>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <?= $this->Form->button(__('Buscar cuotas'), ['class' =>'btn btn-success']) ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php 
if (isset($estudiante)): ?>
    <h3><?= $estudiante ?></h3>
    <h4>Cuotas : <?= $estatusCuotas ? 'Eliminadas' : 'Activas' ?> del período escolar : <?= $periodoEscolar.'-'.($periodoEscolar + 1) ?></h4>
    <?php
    if (isset($contadorTransacciones)):
        if ($contadorTransacciones > 0): ?> 
            <?= $this->Form->create() ?>
                <fieldset>
                    <input type='hidden' name='id_estudiante_modificado' value=<?= $idEstudiante ?>>
                    <input type='hidden' name='estudiante_modificado' value='<?= $estudiante ?>'>
                    <input type='hidden' name='periodo_escolar_modificado' value=<?= $periodoEscolar ?>>
                    <input type='hidden' name='estatus_cuotas_modificado' value=<?= $estatusCuotas ?>>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>        
                                    <th style='text-align: center;'><?= $estatusCuotas ? 'Restaurar' : 'Eliminar' ?></th>
                                    <th style='text-align: center;'>id</th>
                                    <th style='text-align: center;'>Cuota</th>
                                    <th style='text-align: center;'>Monto Cuota $</th>
                                    <th style='text-align: center;'>Monto Original $</th>
                                    <th style='text-align: center;'>Pago Parcial</th>
                                    <th style='text-align: center;'>Pago Total</th>
                                    <th style='text-align: center;'>Monto Abonado $</th>
                                    <th style='text-align: center;'>Porcentaje Descuento %</th>
                                    <th><th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $contador = 1;
                                foreach ($transaccionesEstudiante as $transaccion): ?>
                                    <tr>
                                        <td style='text-align: center;'>
                                            <input type="checkbox" id=<?= 'invoiced_'.$contador ?> name='invoiced[<?= $contador ?>]' value=<?= $transaccion->id ?>>
                                        </td>
                                        <td style='text-align: center;'>
                                            <?= $transaccion->id ?>
                                        </td>
                                        <td style='text-align: left;'>
                                            <?= $transaccion->transaction_description ?>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_'.$contador ?> name='amount[<?= $contador ?>]' value=<?= $transaccion->amount ?> step='0.01' class='form-control'>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'original_amount_'.$contador ?> name='original_amount[<?= $contador ?>]' value=<?= $transaccion->original_amount ?> step='0.01' class='form-control'>
                                        </td>                                       
                                        <td>
                                            <select id=<?= 'partial_payment_'.$contador ?> name='partial_payment[<?= $contador ?>]' class='form-control'>
                                                <option value="1" <?= $transaccion->partial_payment ? 'selected' : '' ?>>Sí</option>
                                                <option value="0" <?= $transaccion->partial_payment ? '' : 'selected' ?>>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id=<?= 'paid_out_'.$contador ?> name='paid_out[<?= $contador ?>]' class='form-control'>
                                                <option value="1" <?= $transaccion->paid_out ? 'selected' : '' ?>>Sí</option>
                                                <option value="0" <?= $transaccion->paid_out ? '' : 'selected' ?>>No</option>
                                            </select>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'amount_dollar_'.$contador ?> name='amount_dollar[<?= $contador ?>]' value=<?= $transaccion->amount_dollar ?> step='0.01' class='form-control'>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="number" id=<?= 'porcentaje_descuento_'.$contador ?> name='porcentaje_descuento[<?= $contador ?>]' value=<?= $transaccion->porcentaje_descuento ?> step='0.01' class='form-control'>
                                        </td>
                                        <td>
                                            <input type='hidden' id=<?= 'id_transaccion_'.$contador ?> name='id_transaccion[<?= $contador ?>]' value=<?= $transaccion->id ?>>
                                        </td>
                                    </tr>
                                    <?php
                                    $contador++; 
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <div class='row'>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <?= $this->Form->button(__('Enviar'), ['class' =>'btn btn-success']) ?>
                </div>
            <?= $this->Form->end() ?>
        <?php
        else: ?>
            <p>No se encontraron cuotas para el estudiante</p>
        <?php
        endif;
    endif; ?>
<?php
endif; ?>
<script>
//  Declaración de variables

// Funciones Jquery

    $(document).ready(function() 
    {
        $('#estudiante').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Students", "action" => "findStudent")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                $('#id_estudiante').val(ui.item.id);
              }
        });

    }); 

</script>