<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Agregar Número de control</h2>
    	</div>
        <?= $this->Form->create($controlnumber) ?>
        <fieldset>
            <?php
                echo $this->Form->input('invoice_series', ['label' => 'Número de serie']);
                echo $this->Form->input('invoice_lot', ['label' => 'Lote']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>