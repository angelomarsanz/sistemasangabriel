<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-3">
        <div class="page-header">
            <?php if (isset($idPaysheet)): ?>
                <p><?= $this->Html->link(__('Volver'), ['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification], ['class' => 'btn btn-sm btn-default']) ?></p>
            <?php else: ?>
                <p><?= $this->Html->link(__('Volver'), ['controller' => 'Employees', 'action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></p>
            <?php endif; ?>
            <h3>Cambio de estado del empleado</h3>
        </div>
        <?= $this->Form->create($employee, ['type' => 'file']) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                            date_default_timezone_set('America/Caracas');
                            
                            echo $this->Form->input('reason_withdrawal', ['label' => 'Estado: *', 'options' =>
                                ['null' => '',
                                'Activo' => 'Activo',
                                'Despido' => 'Despido',
                                'Eliminado' => 'Eliminado',
                                'Reducción de personal' => 'Reducción de personal',
                                'Retiro voluntario' => 'Retiro voluntario',
                                'Suspensión temporal' => 'Suspensión temporal']]);
                            echo $this->Form->input('retirement_date', ['label' => 'Fecha del cambio de estado: *']);

                        ?>
                    </div>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-employee']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#save-employee').click(function(e) 
        {
        });
    });
</script>