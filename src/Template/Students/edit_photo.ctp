<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Agregar foto de perfil del alumno</h3>
        </div>
        <?= $this->Form->create($student, ['type' => 'file']) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                            echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil:'));
                        ?>
                    </div>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-student']) ?>
        <?= $this->Html->link('Cancelar', ['controller' => 'Students', 'action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>