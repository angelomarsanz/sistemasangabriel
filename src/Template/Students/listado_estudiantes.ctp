<?php
    use Cake\Routing\Router; 
?>
<?php 
$controlador = isset($controlador) ? $controlador : null;
$accion = isset($accion) ? $accion : null;
$idRepresentante = isset($idRepresentante) ? $idRepresentante : null;
$estatusEstudiante = isset($estatusEstudiante) ? $estatusEstudiante : null;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="page-header">
            <h3>Estudiantes: </h3>
            <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion.'/'.$idRepresentante], ['class' => 'btn btn-sm btn-default']) ?></p>
        </div>
    </div>
</div>
<?= $this->Form->create() ?>
    <fieldset>
        <div class='row'>
            <input type='hidden' name='id_representante' id='id_representante' value=<?= $idRepresentante ?>>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <label for="representante">Escriba los apellidos de la familia</label>
                <br />
                <input type="text" class="form-control" name="representante" id="representante" value='<?= isset($representante) ? $representante : '' ?>'>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php
                echo $this->Form->input('estatus_estudiante', ['label' => 'Estatus del estudiante: ', 'value' => $estatusEstudiante, 'options' => 
                    [   
                        '' => '',
                        'Egresado' => 'Egresado',
                        'Eliminado' => 'Eliminado',
                        'Expulsado' => 'Expulsado',
                        'Nuevo' => 'Nuevo',
                        'Regular' => 'Regular',
                        'Retirado' => 'Retirado',
                        'Suspendido' => 'Suspendido',
                    ]]); ?>
            </div>
        </div>
    </fieldset>
    <div class='row'>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <?= $this->Form->button(__('Buscar estudiantes'), ['class' =>'btn btn-success']) ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php 
if (isset($representante)): ?>
    <h3><?= $representante ?></h3>
    <h4>Estudiantes con estatus: <?= $estatusEstudiante ?></h4>
    <?php
    if (isset($contadorEstudiantes)):
        if ($contadorEstudiantes > 0): ?> 
            <?= $this->Form->create() ?>
                <fieldset>
                    <input type='hidden' name='id_representante_modificado' value=<?= $idRepresentante ?>>
                    <input type='hidden' name='representante_modificado' value='<?= $representante ?>'>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>        
                                    <th style='text-align: center;'>id</th>
                                    <th style='text-align: center;'>Primer Apellido</th>
                                    <th style='text-align: center;'>Primer Nombre</th>
                                    <th style='text-align: center;'>Estatus estudiante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $contador = 1;
                                foreach ($estudiantes as $estudiante): ?>
                                    <tr>
                                        <td style='text-align: center;'>
                                            <?= $estudiante->id ?>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="text" id=<?= 'surname_'.$contador ?> name='surname[<?= $contador ?>]' value=<?= $estudiante->surname ?> class='form-control'>
                                        </td>
                                        <td style='text-align: center;'>
                                            <input type="text" id=<?= 'first_name_'.$contador ?> name='first_name[<?= $contador ?>]' value=<?= $estudiante->first_name ?> class='form-control'>
                                        </td>
                                        <td>
                                            <select id=<?= 'student_condition_'.$contador ?> name='student_condition[<?= $contador ?>]' class='form-control'>
                                                <option value=''></option>
                                                <option value='Egresado'>Egresado</option>
                                                <option value='Eliminado'>Eliminado</option>
                                                <option value='Expulsado'>Expulsado</option>
                                                <option value='Nuevo>'>Nuevo</option>
                                                <option value='Regular'>Regular</option>
                                                <option value='Retirado'>Retirado</option>
                                                <option value='Suspendido'>Suspendido</option>
                                            </select>
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

// Funciones

    $(document).ready(function() 
    {
        $('#representante').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => 'findFamily')); ?>',
            minLength: 3,
            select: function( event, ui ) {
                $('#id_representante').val(ui.item.id);
              }
        });
    }); 

</script>