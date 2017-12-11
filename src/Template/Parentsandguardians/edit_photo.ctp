<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <?php if( (isset($current_user)) && ($current_user['role'] == 'Representante') ): ?>
                <h2>Agregar foto de perfil del Padre o Representante</h2>
            <?php endif; ?>
        </div>
        <?= $this->Form->create($parentsandguardian, ['type' => 'file']) ?>
        <fieldset>
            <div class="row panel panel-default">
                <div class="col-md-11">
                    <br />
                    <?php
                        echo $this->Form->input('profile_photo', array('type' => 'file', 'label' => 'Foto de perfil:'));
                    ?>
                </div>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['id' => 'save-parentsandguardians', 'class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>