<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Datos adicionales del alumno</h2>
        </div>
        <?= $this->Form->create() ?>
            <fieldset>
                <?php
                    echo $this->Form->input('id');
					echo $this->Form->input('new');
					echo $this->Form->input('tasaTemporal');
                ?>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>