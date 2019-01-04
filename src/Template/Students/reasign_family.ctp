<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3><?= 'Reasignar familia a: ' . $student->full_name ?></h3>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
							 echo $this->Form->input('parentsandguardian_id', 
								['label' => 'Familia:', 'options' => $families]); 
						?>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-student']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>