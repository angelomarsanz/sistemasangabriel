<div class="row">
    <div class="col-md-3">
    	<div class="page-header">
            <p><?= $this->Html->link(__('Volver'), ['controller' => 'Users', 'action' => 'wait'], ['class' => 'btn btn-sm btn-default']) ?></p>
    		<h3>Consulta de nota de débito</h3>
        </div>
    	<div>
            <?= $this->Form->create() ?>
                <fieldset>
                    <?php
                        echo $this->Form->input('billNumber', ['label' => 'Número de nota de débito: *', 'required' => 'true', 'type' => 'number']);
                    ?>
                </fieldset>   
                <?= $this->Form->button(__('Buscar'), ['class' =>'btn btn-success']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>